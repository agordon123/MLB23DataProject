<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service class}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new Service class in app/Services directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $className = $name . 'Service';
        $filePath = app_path('Services/' . $className . '.php');

        if (file_exists($filePath)) {
            $this->error('Service class already exists!');
            return;
        }

        $stub = file_get_contents(__DIR__ . '/stubs/service.stub');
        $stub = str_replace('{{className}}', $className, $stub);

        file_put_contents($filePath, $stub);

        $this->info('Service class created successfully: ' . $className);
    }
}
