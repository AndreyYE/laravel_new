<?php

namespace App\Console\Commands\User;

use App\Entity\User;
use App\UseCases\Auth\RegisterServis;
use Illuminate\Console\Command;

class ChangeRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role {email} {role}';

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
        $email = $this->argument('email');
        $role = $this->argument('role');
        $user = User::where('email', $email)->first();
        if(!$user){
            $this->error('User with email - '. $email .' not found');
            return false;
        }
        try{
            $user->changeRole($role);
        }catch (\Exception $e){
             $this->error('ERROR - '.$e->getMessage());
            return false;
        }
        $this->info('You changed '.$user->name. '\'s '.'role - on '. $user->role);
        return true;
    }
}
