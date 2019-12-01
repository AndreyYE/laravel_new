<?php

namespace App\Console\Commands;


use Carbon\Carbon;
use Illuminate\Console\Command;

class ExempleCommand extends Command
{

    protected $signature = 'ex:ex';


    protected $description = 'Ex';



    public function handle(): bool
    {
        \Log::info('cron work '. Carbon::now());
        return true;
    }
}
