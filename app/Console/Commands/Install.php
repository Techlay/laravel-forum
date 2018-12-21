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

            exec('composer install');
            $this->line("\r\n ~ App dependencies successfully installed\r\n");

            exec('php artisan key:generate');
            $this->line("\r\n ~ Secret key properly generated\r\n");

            // Handle different db types (SQLite etc..), currently defaults to MySQL

            $dbEnv['DB_DATABASE'] = $this->ask('Database name');
            $dbEnv['DB_USERNAME'] = $this->ask('Database user');
            $dbEnv['DB_PASSWORD'] = $this->ask('Database password ("null" for no password)');

            $this->changeEnv($dbEnv);

            // Check if the DB connection is actually working or not

            if ($this->confirm('Do you want to automatically setup the database tables?', true)) {
                exec('php artisan migrate');
                $this->line("\r\n~ Database successfully migrated\r\n");
            }

            // Master user creation (might be useful in case of future ACL implementation)

            $this->outro();
        }
    }

    protected function changeEnv($data = array())
    {
        if (count($data) > 0) {
            $env = file_get_contents(base_path() . '/.env');
            $env = preg_split('/\s+/', $env);

            foreach ((array)$data as $key => $value) {
                foreach ($env as $env_key => $env_value) {
                    $entry = explode("=", $env_value, 2);

                    if ($entry[0] == $key) {
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        $env[$env_key] = $env_value;
                    }
                }
            }

            $env = implode("\n", $env);
            file_put_contents(base_path() . '/.env', $env);

            return true;
        } else {
            return false;
        }
    }

    protected function intro()
    {
        $this->info("\r\n>> Welcome to the Forum installation process >>\r\n");
    }

    protected function outro()
    {
        $this->info("\r\n>> The intallation process is complete. Enjoy your new forum! <<\r\n");
    }
}
