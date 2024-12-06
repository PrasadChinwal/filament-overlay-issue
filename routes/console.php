<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Spatie\Health\Commands\RunHealthChecksCommand;


if(app()->isProduction()) {
    Schedule::command('telescope:prune --hours=336')->dailyAt('04:00');
}

Schedule::command(RunHealthChecksCommand::class)->everyMinute();
