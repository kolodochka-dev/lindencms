<?php

namespace LindenCMS\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\User;
use LindenCMS\Cms\CmsServiceProvider;

class InstallCommand extends Command
{
    protected $signature = 'lindencms:install';

    protected $description = 'Install LindenCMS with admin user and initial setup';

    public function handle(): int
    {
        $this->alert('Welcome to LindenCMS Installation!');

        // Step 1: Publish vendor assets
        $this->stepWithDelay(
            'Publishing vendor assets',
            fn() => $this->call('vendor:publish', ['--provider' => CmsServiceProvider::class])
        );

        // Step 2: Run migrations
        $this->stepWithDelay(
            'Migration',
            fn() => $this->call('migrate')
        );

        // Step 3: Create admin user
        $this->stepWithDelay(
            'Create Admin User',
            fn() => $this->createAdminUser()
        );

        // Step 4: Sync DB
        if ($this->refreshConfig()) {
            $this->stepWithDelay(
                'Database synchronization',
                fn() => $this->call('lindencms:sync'),
                false
            );
        }
        
        $this->info('LindenCMS installed successfully!');
        $this->info('You can now log in at: ' . route('login'));

        return self::SUCCESS;
    }

    private function stepWithDelay(string $message, callable $callback, bool $withFeedback = true, int $delay = 500): void
    {
        $colors = [
            'red' => "\033[41m",
            'green' => "\033[42m",
            'yellow' => "\033[43m",
            'blue' => "\033[44m",
            'magenta' => "\033[45m",
            'cyan' => "\033[46m",
            'white' => "\033[47m",
            'fg_black' => "\033[30m",
            'reset' => "\033[0m",
        ];
        $message = str($message)->upper();
        $this->line("{$colors['green']}{$colors['fg_black']} {$message} {$colors['reset']}");

        $callback();

        if ($withFeedback) {
            usleep($delay * 1000);
            $this->info("  ✓ Complete");
        }

        $this->newLine();
    }

    private function refreshConfig()
    {
        $this->call('config:clear');
        if (!config('lindencms.nodes')) {
            $configPath = config_path('lindencms.php');
            if (file_exists($configPath)) {
                $this->laravel['config']->set('lindencms', require $configPath);
            }

            if (!config('lindencms.nodes')) {
                $this->error('Failed to load configuration. Please execute `lindencms:sync` command manually.');
                return false;
            }
        }

        return true;
    }

    private function createAdminUser()
    {
        $email = $this->ask('Enter admin email', 'admin@example.com');
        $name = $this->ask('Enter admin name', 'admin');
        $password = $this->secret('Enter admin password');

        $passwordConfirm = $this->secret('Confirm admin password');
        if ($password !== $passwordConfirm) {
            $this->error('Passwords do not match. Please try again.');
            $this->createAdminUser();
        }

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

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();
    }
}