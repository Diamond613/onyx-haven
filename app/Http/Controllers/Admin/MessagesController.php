<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ReplyToContactMessage;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessagesController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->get();
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        return view('admin.messages.show', compact('message'));
    }

    public function reply(Request $request, ContactMessage $message)
    {
        $validated = $request->validate([
            'reply' => 'required|string|max:3000',
        ]);

        Mail::to($message->email)->send(new ReplyToContactMessage($message, $validated['reply']));

        $message->update([
            'reply' => $validated['reply'],
            'replied_at' => now(),
        ]);

        return redirect('/admin/messages')->with('success', 'Reply sent to ' . $message->name . '.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect('/admin/messages')->with('success', 'Message deleted.');
    }
}