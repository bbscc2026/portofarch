<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact', ['projectTypes' => ContactMessage::PROJECT_TYPES]);
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $message = ContactMessage::create($request->safe()->except('website'));

        try {
            Mail::raw(
                "New enquiry from {$message->name} ({$message->email}, {$message->phone})\nProject type: {$message->project_type}\n\n{$message->message}",
                fn ($mail) => $mail->to(Setting::get('email', 'info@portofarch.com'))
                    ->replyTo($message->email, $message->name)
                    ->subject('New project enquiry — '.$message->name),
            );
        } catch (Throwable $e) {
            Log::warning('Contact notification email failed', ['message_id' => $message->id, 'error' => $e->getMessage()]);
        }

        return to_route('contact')->with('sent', true);
    }
}
