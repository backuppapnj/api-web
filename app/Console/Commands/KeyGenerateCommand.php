<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class KeyGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'key:generate {--show : Display the key instead of modifying files}';

    /**
     * The console command description.
     */
    protected $description = 'Generate a new application key';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $key = 'base64:' . base64_encode(random_bytes(32));

        if ($this->option('show')) {
            $this->line('<comment>' . $key . '</comment>');
            return;
        }

        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            $this->error('.env file not found!');
            return;
        }

        $envContent = file_get_contents($envPath);

        if (preg_match('/^APP_KEY=.*/m', $envContent)) {
            $envContent = preg_replace('/^APP_KEY=.*/m', 'APP_KEY=' . $key, $envContent);
        } else {
            $envContent .= "\nAPP_KEY=" . $key;
        }

        file_put_contents($envPath, $envContent);

        $this->info('Application key set successfully: ' . $key);
    }
}
