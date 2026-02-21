<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactoRequest;
use App\Mail\ContactoMail;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function send(ContactoRequest $request)
    {
        Mail::to(config('mail.from.address'))->send(new ContactoMail($request->validated()));

        return back()->with('success', __('Mensaje enviado correctamente. Te responderemos lo antes posible.'));
    }
}
