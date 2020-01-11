<?php

namespace App\Console\Commands;

use App\Services\MatchService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class AddNameSearchIndexToRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'records:add_ns_index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update name search indexes';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \DB::statement('
            UPDATE `matches` SET `matches`.`characters_index` = CONCAT(
                (SELECT name FROM `characters` ca WHERE ca.id = `matches`.`character_a_id`),
                "^",
                (SELECT name FROM `characters` cb WHERE cb.id = `matches`.`character_b_id`)
            )
        ');
    }
}
