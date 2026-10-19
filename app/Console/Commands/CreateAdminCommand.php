<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cso:create-admin
        {--name= : The administrator’s full name}
        {--email= : The administrator’s email address}
        {--password= : The administrator’s password (omit to be prompted securely)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update a MUST CSO administrator account';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = trim((string) ($this->option('name') ?: text(
            label: 'Full name',
            placeholder: 'Site administrator',
            required: true,
            validate: fn (string $value) => strlen(trim($value)) < 2
                ? 'Please enter at least two characters.'
                : null,
        )));

        $email = strtolower(trim((string) ($this->option('email') ?: text(
            label: 'Email address',
            placeholder: 'admin@example.com',
            required: true,
            validate: fn (string $value) => filter_var($value, FILTER_VALIDATE_EMAIL)
                ? null
                : 'Please enter a valid email address.',
        ))));

        $password = (string) ($this->option('password') ?: $this->promptForPassword());

        $validator = Validator::make(
            compact('name', 'email', 'password'),
            [
                'name' => ['required', 'string', 'min:2', 'max:120'],
                'email' => ['required', 'email', 'max:254'],
                'password' => ['required', 'string', 'min:12', 'max:255'],
            ],
            [
                'password.min' => 'Choose a password with at least 12 characters.',
            ],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                error($message);
            }

            return self::FAILURE;
        }

        $user = User::query()->where('email', $email)->first();
        $isNew = $user === null;

        if (! $isNew && ! confirm(
            label: 'An account with this email already exists. Update it and grant administrator access?',
            default: false,
        )) {
            $this->components->warn('No changes were made.');

            return self::SUCCESS;
        }

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password,
                'is_admin' => true,
            ],
        );

        $this->components->info(
            $isNew
                ? 'Administrator account created.'
                : 'Administrator account updated.',
        );

        return self::SUCCESS;
    }

    /**
     * Prompt for and confirm a new password.
     */
    private function promptForPassword(): string
    {
        $password = password(
            label: 'Password',
            required: true,
            validate: fn (string $value) => strlen($value) < 12
                ? 'Choose a password with at least 12 characters.'
                : null,
        );

        $confirmation = password(
            label: 'Confirm password',
            required: true,
        );

        if ($password !== $confirmation) {
            error('The passwords do not match.');

            return '';
        }

        return $password;
    }
}
