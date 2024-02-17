<?php

namespace App\Services\Impl;

use App\Mail\SendMail;
use App\Services\MailService;
use Illuminate\Support\Facades\Mail;

class MailServiceImpl implements MailService
{

    /**
     * Send a file attachment to the specified email address.
     *
     * @param string $email    The email address of the recipient.
     * @param string $filePath The path to the file to be attached.
     * @return void
     */
    public function sendFile(string $email, string $filePath): void
    {
        Mail::to($email)->send(new SendMail($filePath));
    }
}
