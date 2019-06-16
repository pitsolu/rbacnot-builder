<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Strukt\Fs;

class RbacNotSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rbacnot:setup {--reverse}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup middlewares, facades and providers for entrust and annotations';

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
        $refactor = array(

            "Providers"=>array(

                "pattern"=>"/Provider::class,$/",
                "file"=>"config/app.php",
                "list"=>array(
                    "\n\t\tApp\Providers\AnnotationsServiceProvider::class, //\n",
                    "\t\tZizaco\Entrust\EntrustServiceProvider::class, //\n\n",
                )
            ),
            "Facades"=>array(

                "pattern"=>"/App::class,$/",
                "file"=>"config/app.php",
                "list"=>array(
                    "\n\t\t'Entrust' => Zizaco\Entrust\EntrustFacade::class, //\n\n"
                )
            ),
            "CoreMiddlewares"=>array(

                "pattern"=>"/TrustProxies::class,$/",
                "file"=>"app/Http/Kernel.php",
                "list"=>array(

                    "\n\t\t\Illuminate\Session\Middleware\StartSession::class, //\n"
                )
            ),
            "RouteMiddlewares"=>array(

                "pattern"=>"/Authenticate::class,$/",
                "file"=>"app/Http/Kernel.php",
                "list"=>array(
                    "\n\t\t'role' => \Zizaco\Entrust\Middleware\EntrustRole::class, //\n",
                    "\t\t'permission' => \Zizaco\Entrust\Middleware\EntrustPermission::class, //\n",
                    "\t\t'ability' => \Zizaco\Entrust\Middleware\EntrustAbility::class, //\n\n"
                    )
            )
        );

        foreach($refactor as $items){

            extract($items);

            $files = array_merge(

                glob($file),
                glob(sprintf("src/%s", $file))
            );

            $file = end($files);

            $lines = file($file);

            $insert = true; 

            $newlines = [];

            if(!$this->option("reverse")){

                foreach($lines as $line){

                    if(preg_match($pattern, $line) && $insert == true){

                        $newlines = array_merge($newlines, $list);

                        $insert = false;
                    }

                    $newlines[] = $line;
                }
            }
            else{

                $contents = Fs::cat($file);
                $newlines[] = str_replace($list, "", $contents);
            }

            Fs::rename($file, sprintf("%s~", $file));

            if(Fs::touchWrite($file, implode("", $newlines))){

                if(!$this->option("reverse"))
                    $this->info("RbacNot Setup was successful.");
                else
                    $this->info("RbacNot setup rolled back.");
            }
            else $this->error("RbacNot setup command failed.");
        }
    }
}
