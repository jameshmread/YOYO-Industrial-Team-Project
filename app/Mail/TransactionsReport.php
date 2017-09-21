<?php

namespace App\Mail;

use App\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionsReport extends Mailable
{
    use Queueable, SerializesModels;

    protected $trasactions;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($trasactions)
    {
        $this->trasactions = $trasactions;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.transactions')
            ->with([
                'transactions' => $this->trasactions,
            ]);
    }
}
