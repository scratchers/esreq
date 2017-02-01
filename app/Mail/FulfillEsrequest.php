<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Esrequest;

class FulfillEsrequest extends Mailable
{
    use Queueable, SerializesModels;

    public $esrequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Esrequest $esrequest)
    {
        $this->esrequest = $esrequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Enterprise Systems Request has been Fulfilled')
            ->view('emails.fulfilled');
    }
}
