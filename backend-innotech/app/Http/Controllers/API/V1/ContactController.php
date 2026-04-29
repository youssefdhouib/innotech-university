<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactMessageMail;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    use ApiResponseTrait;

    public function submit(ContactFormRequest $request)
    {
        try {
            $data = $request->validated();

            $recipient = match ($data['service']) {
                'scolarite' => 'dhouibyoussef222@gmail.com',
                'bibliotheque' => 'hamado33333@gmail.com',
                'administration' => 'admin@InnoTech.tn',
            };

            Mail::to($recipient)->send(new ContactMessageMail($data));

            return $this->successResponse(__('messages.contact_sent'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.contact_failed'), config('app.debug') ? ['exception' => $e->getMessage()] : null, 500);
        }
    }
}
