<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactMessageController extends Controller
{
    /**
     * Display messages submitted through the public contact form.
     */
    public function index(): View
    {
        return view('admin.messages.index', [
            'messages' => ContactMessage::query()
                ->latest()
                ->paginate(20),
        ]);
    }

    /**
     * Toggle the read state of a contact message.
     */
    public function toggleRead(ContactMessage $message): RedirectResponse
    {
        $message->update([
            'read_at' => $message->read_at ? null : now(),
        ]);

        return back()->with(
            'status',
            $message->refresh()->read_at
                ? 'The message was marked as read.'
                : 'The message was marked as unread.',
        );
    }
}
