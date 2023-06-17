<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Config,Mail;
class CreateDataBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:database {database?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new mysql database schema based on the database config file';

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


       /*  if ($this->argument('database') !== null) {
            $database = $this->argument('database');
        } else {
            $database = $this->ask('Name Database: ', false);
            if ($database === false) {
                $database = env('DB_DATABASE');
            }
        } */

       /*  if ($this->argument('user') !== null) {
            $user = $this->argument('user');
        } else {
            $user = $this->ask('Name user: ', false);
            if ($user === false) {
                $user = env('DB_USERNAME');
            }
        } */


        /* if ($this->argument('pass') !== null) {
            $pass = $this->argument('pass');
        } else {
            $pass = $this->ask('Name pass: ', false);
            if ($pass === false) {
                $pass = env('DB_PASSWORD');
            }
        } */


        /* if ($this->argument('driver') !== null) {
            $driver = $this->argument('driver');
        } else {
            $driver = $this->ask('Name driver: ', false);
            if ($driver === false) {
                $driver = Config::get('database.default');
            }
        } */

       /*  if ($this->argument('host') !== null) {
            $host = $this->argument('host');
        } else {
            $host = $this->ask('Name host: ', false);
            if ($host === false) {
                $host = env('DB_HOST');
            }
        } */

        $dbConfig = (object)Config::get('database.connections.mysql');
        $driver   = $dbConfig?->driver;
        $pass     = $dbConfig?->password;
        $user     =  $dbConfig?->username;
        $host     = $dbConfig?->host;
        $database = $this->argument('database');


        switch ($driver) {
            case 'mysql':
            case 'pgsql':
                $dsn = "{$driver}:host={$host}";
                break;
            case 'sqlsrv':
                $dsn = "{$driver}:Server={$host}";
                break;
            case 'sqlite':
                if (file_exists(storage_path('database.sqlite'))) {
                    unlink(storage_path('database.sqlite'));
                }

                $handle = fopen(storage_path('database.sqlite'), 'w');
                fclose($handle);
                $this->info("SQLite Database created successfully");
                break;
            default:
                $this->error("Invalid database driver: {$driver}");
        }

        if ($driver !== 'sqlite') {
            try {
                $conn = new \PDO($dsn, $user, $pass, [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                ]);

                $conn->exec('DROP DATABASE IF EXISTS '.$database);
                $conn->exec('CREATE DATABASE '.$database);
                $this->info("Database {$driver}:{$database} created successfully");

            } catch (\PDOException $ex) {
                $this->error($ex->getMessage());
            }
        }
    }
}
