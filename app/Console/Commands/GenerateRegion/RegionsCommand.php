<?php

namespace App\Console\Commands\GenerateRegion;

use App\Entity\Region;
use Illuminate\Console\Command;

class RegionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:regions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Regions';

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

        $xml = simplexml_load_file(storage_path('regions/Ukraine/Ukraine.xsl'));
        foreach ($xml->children() as $key){
                $region_p = new Region();
                $region_p->name = $key['name']->__toString();
                $str=rand();
                $slug = md5($str);
                $region_p->slug = $slug;
                $region_p->parent_id = null;
                $region_p->save();
                foreach ($key->children() as $val){
                    $region = new Region();
                    $region->name = $val['name']->__toString();
                    $str=rand();
                    $slug = md5($str);
                    $region->slug = $slug;
                    $region->parent_id = $region_p->id;
                    $region->save();
                }
        }
        return true;
    }
}
