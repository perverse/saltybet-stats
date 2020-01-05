<?php

namespace App\Console\Commands;

use App\Services\MatchService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class ProcessRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'records:process {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MatchService $service)
    {
        $this->service = $service;

        parent::__construct();
    }

    protected function generator($file)
    {
        $handle = fopen($file, "r");

        while (!feof($handle)) {
            yield fgetcsv($handle);
        }

        fclose($handle);
    }

    protected function validator($data)
    {
        return Validator::make($data, [
            'date' => 'date'
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = 0;

        foreach ($this->generator(storage_path('app/imports/' . $this->argument('filename'))) as $row) {
            $count++;
            if ($this->validator([
                'date' => $row[11]
            ])->fails()) {
                $this->info($count . ' | Skipping record - invalid');
            } else {
                $match = $this->service->importMatchCsvRow($row);
                $this->info($count . ' | Created match ' . $match->id . ' with characters ' . $match->character_a_id . ' and ' . $match->character_b_id);
            }
            
        }
    }
}
