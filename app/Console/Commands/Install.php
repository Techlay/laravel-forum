<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forum:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simplify installation process';

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
        $this->intro();

        if (!file_exists('.env')) {
            exec('mv .env.example .env');
            $this->line("\r\n.env file successfully created\r\n");
        }

        if (strlen(config('app.key')) === 0) {
            $this->call('key:generate');
            $this->line("\r\n ~ Secret key properly generated\r\n");
        }

        $dbEnv['DB_DATABASE'] = $this->ask('Database name');
        $dbEnv['DB_USERNAME'] = $this->ask('Database user');
        $dbEnv['DB_PASSWORD'] = $this->ask('Database password ("null" for no password)');

        $this->updateEnvironmentFile($dbEnv);

        // Check if the DB connection is actually working or not

        if ($this->confirm('Do you want to automatically setup the database tables?', true)) {
            exec('migrate');
            $this->line("\r\n~ Database successfully migrated\r\n");
        }

        // Master user creation (might be useful in case of future ACL implementation)

        $this->outro();
    }

    protected function updateEnvironmentFile($updatedValues)
    {
        foreach ($updatedValues as $key => $value) {
            file_put_contents($this->laravel->environmentFilePath(), preg_replace(
                "/{$key}={.*}",
                $key.'='.$value,
                file_get_contents($this->laravel->environmentFilePath())
            ));
        }
    }

    protected function intro()
    {
        $this->info("\r\n>> Welcome to the Forum installation process >>\r\n");
    }

    protected function outro()
    {
        $this->info("\r\n>> The installation process is complete. Enjoy your new forum! <<\r\n");
    }
}
