<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);
        $startsAt = fake()->dateTimeBetween('+3 days', '+6 weeks');

        return [
            'created_by_id' => User::factory()->admin(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(100, 9999),
            'excerpt' => fake()->sentence(18),
            'description' => fake()->paragraphs(3, true),
            'location' => 'MUST campus',
            'starts_at' => $startsAt,
            'ends_at' => (clone $startsAt)->modify('+2 hours'),
            'is_published' => true,
            'is_demo' => false,
        ];
    }

    /**
     * Indicate that the event is unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }

    /**
     * Indicate that the event is past.
     */
    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'starts_at' => now()->subWeeks(2),
            'ends_at' => now()->subWeeks(2)->addHours(2),
        ]);
    }

    /**
     * Indicate that the event is demonstration content.
     */
    public function demonstration(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_demo' => true,
        ]);
    }
}
