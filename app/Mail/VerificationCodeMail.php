<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $code)
    {
    }

    public function build(): self
    {
        return $this
            ->from('verification@darkframe.az', 'DarkFrame.az')
            ->subject('Təsdiq kodunuz: ' . $this->code)
            ->view('emails.verification-code');
    }
}
