<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Util;

class ProcessNotificationSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $cell_phone_number;
    public $message;
    public $loan_id;
    public $user_id;
    public $notification_type;

    public function __construct($cell_phone_number, $message, $loan_id, $user_id, $notification_type)
    {
        $this->cell_phone_number = $cell_phone_number;
        $this->message = $message;
        $this->loan_id = $loan_id;
        $this->user_id = $user_id;
        $this->notification_type = $notification_type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Util::delegate_shipping($this->cell_phone_number, $this->message, $this->loan_id, $this->user_id, $this->notification_type);
    }
}
