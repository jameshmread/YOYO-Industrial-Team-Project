<?php

namespace App\Console\Commands;

use App\Mail\TransactionsReport;
use Illuminate\Console\Command;
use App\User;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class MailCronCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will send mails based on user frequency';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        User::all()
            ->map(function ($item) {

                $frequency = $this->frequencyCheck($item);

                if ($item->is_reportable && Carbon::now(-$frequency) > $item->last_report_send) {

                    // Will need to do some permission checking for store


                    Mail::to($item)
                        ->send(new TransactionsReport($this->getTransactions($frequency)));

                    $item->last_report_send = Carbon::now();
                    $item->save();
                }
            });
    }

    private function frequencyCheck(User $user)
    {
        if ($user->report_frequency === 'weekly') {
            return 7;
        }
        if ($user->report_frequency === 'monthly') {
            return 30;
        }
    }

    private function getTransactions($frequency)
    {
        return Transaction::where('date', '>=', Carbon::now(-$frequency))
            ->get();
    }
}
