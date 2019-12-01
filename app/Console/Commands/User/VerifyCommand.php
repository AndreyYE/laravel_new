<?php

namespace App\Console\Commands\User;

use App\Entity\User;
use App\UseCases\Auth\RegisterServis;
use Illuminate\Console\Command;

class VerifyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verify {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $service;
    public function __construct(RegisterServis $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();
        if(!$user){
            $this->error('User with email - '. $email .' not found');
            return false;
        }
        try{
            $this->service->verify($user->id);
        }catch (\DomainException $e){
             $this->error('ERROR - '.$e->getMessage());
            return false;
        }
        $this->info('Success Verify - '. $user->name);
        return true;
    }
}
