<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalesReport extends Mailable
{
    use Queueable, SerializesModels;

    public $sales;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.sales')
            ->with([
                'sales' => $this->sales,
            ]);
    }
}
