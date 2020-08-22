<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;

class SendEmail extends Job
{

    /**
     *
     * @var string
     */
    private $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('New user.', [
            'email' => $this->email
        ]);
    }
}