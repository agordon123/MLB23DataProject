<?php

namespace App\Console\Commands;

use App\Models\Set;
use App\Models\Brand;
use App\Models\Series;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ParseMetaData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:meta_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses meta_data files, containing Brand, Series, and Sets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = 'public/json/';
        $fileName = 'meta_data/meta_data-2023-06-02_12-30-05.json';
        // Get all the files in the directory
        $jsonDatas = Storage::get($directory.$fileName);
        $data = json_decode($jsonDatas);
        dd($data);


        // Store the file names in a variable



            foreach ($data['series'] as $item) {
                $series = new Series();
                $series->series_id = $item['series_id'];
                $series->name = $item['name'];
                $series->save();
                $this->info('Series ID #' . $series->id . ' saved');
            }
            foreach ($data['brands'] as $brand) {
                $newBrand = new Brand();
                $newBrand->brand_id = $brand['brand_id'];
                $newBrand->name = $brand['name'];
                $this->info('Brand ID # ' . $newBrand->id . ' saved');
            }
            foreach ($data['sets'] as $set) {
                $newSet = new Set(['name' => $set]);
                $newSet->save();
                $this->info("Set ID # " . $newSet->id . 'saved');
            }

    }
}
