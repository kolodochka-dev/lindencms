<?php

namespace LindenCMS\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\User;

class InstallCommand extends Command
{
    protected $signature = 'lindencms:install';
    
    protected $description = 'Install LindenCMS with admin user and initial setup';
    
    public function handle(): int
    {
        $this->info('Welcome to LindenCMS Installation!');
        $this->newLine();
        
        // Step 1: Run migrations
        $this->call('migrate');
        
        // Step 2: Create admin user
        $this->createAdminUser();
        
        $this->newLine();
        $this->info('LindenCMS installed successfully!');
        $this->info('You can now log in at: ' . route('login'));
        
        return self::SUCCESS;
    }
    
    protected function createAdminUser()
    {
        $this->info('Create Admin User');
        
        $email = $this->ask('Enter admin email', 'admin@example.com');
        $name = $this->ask('Enter admin name', 'admin');
        $password = $this->secret('Enter admin password');
        
        // Confirm password
        $passwordConfirm = $this->secret('Confirm admin password');
        
        if ($password !== $passwordConfirm) {
            $this->error('Passwords do not match. Please try again.');
            $this->createAdminUser();
        }
        
        // Validate input
        $validator = Validator::make([
            'email' => $email,
            'name' => $name,
            'password' => $password,
        ], [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|min:8',
        ]);
        
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            $this->createAdminUser();
        }
        
        // Create the user
        // $user = User::create([
        //     'name' => $name,
        //     'email' => $email,
        //     'password' => Hash::make($password),
        //     // 'email_verified_at' => now(),
        // ]);

        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        $user->save();
        
        $this->info('✓ Admin user created successfully!');
    }
}