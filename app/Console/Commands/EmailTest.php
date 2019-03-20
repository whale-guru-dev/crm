<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Nwidart\Modules\Facades\Module;
use Stringy\Stringy;

/**
 * Class EmailTest
 * @package App\Console\Commands
 */
class EmailTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Test';

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

        $email = $this->ask('Email to test email config?');

        $result = Mail::raw('Test email sent form crm applicaiton to check email configuration', function ($message) use ($email){
            $message->from(config('mail.from.address'));
            $message->to($email);
            $message->subject('Testing email settings');
        });

        $this->info($result);

    }
}
