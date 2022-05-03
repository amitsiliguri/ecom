<?php

namespace Easy\MultiAuth\Console\Commands;

use Easy\MultiAuth\Models\Admin;
use Illuminate\Console\Command;
use Easy\MultiAuth\Service\Register;
use Illuminate\Validation\ValidationException;

class CreateAdmin extends Command
{
    /**
     * @var Register
     */
    private Register $register;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easy:create-admin {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish frontend assets and view files from easy theme to laravel application.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Register $register)
    {
        $this->register = $register;
        parent::__construct();
    }

    /**
     * @return void installInertiaVueStack
     * @throws ValidationException
     */
    public function handle(): void
    {
        $admin['name'] = $this->argument('name');
        $admin['email'] = $this->argument('email');
        $admin['password'] = $this->argument('password');
        $admin['password_confirmation'] = $this->argument('password');
        try {
            $user = $this->register->createUser($admin, 'admin');
//            $this->table(['Name', 'Email'], $user->toArray());
            $this->info('Admin User Created.');
        } catch (ValidationException $e) {
            $this->error($e->getMessage());
        }
    }
}
