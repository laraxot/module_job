<?php

namespace Modules\Job\Console\Commands;

use Carbon\Carbon;
use Cron\CronExpression;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Modules\Test\Emails\MailWithSerder;
use Modules\Quaeris\Models\SurveyPdf;

class TestCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'a dummy test';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        
        // $this->info('HELLO !');
        
        Mail::raw('test di email', function ($msg) {
            $msg->from('survey@quaerisofficina.it');
            $msg->to('vair81@gmail.com')->subject('test di prova');
        });

    }

    
}
