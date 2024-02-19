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
     * @param string $toSend    The email address of the recipient.
     * @param string $filePath The path to the file to be attached.
     * @return void
     */
    public function sendFile(string $toSend, string $filePath): void
    {
        Mail::to($toSend)->send(new SendMail($filePath));
    }
}
