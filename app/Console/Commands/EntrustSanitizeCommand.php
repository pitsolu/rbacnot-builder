<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Strukt\Fs;

class EntrustSanitizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entrust:clean {--reverse}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sanitize entrust migrations';

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
        $migrations = array_merge(

            glob("database/migrations/*entrust*.php"),
            glob("src/database/migrations/*entrust*.php")
        );

        $migration = end($migrations);
        $old_migration = sprintf("%s~", $migration);
        Fs::rename($migration, $old_migration);

        $needle = array(

            "\$table->increments('id');",
            "\$table->integer('user_id')->unsigned();",
            "\$table->integer('role_id')->unsigned();",
            "\$table->integer('permission_id')->unsigned();"
        );

        $haystack = array(

            "\$table->bigIncrements('id');",
            "\$table->unsignedBigInteger('user_id');",
            "\$table->unsignedBigInteger('role_id');",
            "\$table->unsignedBigInteger('permission_id');",
        );

        if($this->option("reverse")){

            $temp = $needle;
            $needle = $haystack;
            $haystack = $temp;
        }

        $content = Fs::cat($old_migration);

        if(Fs::touchWrite($migration, str_replace($needle, $haystack, $content))){

            if(!$this->option("reverse"))
                $this->info("Sanitization of entrust migrations successfully created.");
            else
                $this->info("Rolled back entrust migrations sanitization.");
        }
        else $this->error("Command failed!");
    }
}