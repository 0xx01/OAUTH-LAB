<?php

namespace App\Jobs;

use \Log;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class RefreshGoogleTokens implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::whereNotNull('google_refresh_token')->get();

        foreach ($users as $user) {
            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'grant_type' => 'refresh_token',
                'refresh_token' => $user->google_refresh_token,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                $user->update([
                    'token' => $data['access_token'],
                    //'google_token_expires_at' => now()->addSeconds($data['expires_in']),
                ]);
            }
        }
        Log::info('Running RefreshGoogleTokens job...');
    }
}
