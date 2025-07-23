<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Log;

class SendOTP implements ShouldQueue
{
    use Queueable;

    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            Log::info('Start SendOTP for user: ' . $this->user->id);
    

            Mail::to($this->user->email)->send(new VerificationCodeMail($this->user));
    
            Log::info('Email sent to: ' . $this->user->email);
        } catch (\Throwable $e) {
            Log::error('SendOTP failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
