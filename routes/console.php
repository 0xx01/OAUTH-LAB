<?php

use App\Jobs\RefreshGoogleTokens;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;



Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new RefreshGoogleTokens)->hourly(); # ->everyFiveMinutes() => Run the Job every 5 minutes. 
