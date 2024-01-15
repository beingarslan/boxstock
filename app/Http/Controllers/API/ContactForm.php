<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use App\Mail\UserWasVerifiedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactForm extends Controller
{
    public function send_contact(Request $request) {

        $contact_form = [
            'name' => $request->name,
            'email' => $request->email,
            'question' => $request->question
        ];

        Mail::to(env('ADMIN_EMAIL'))->send(new ContactFormMail($contact_form));

        return response()->json([
            'message' => 'We will send you email for account approved. Thank you',
        ], 201);
    }
}
