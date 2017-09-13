<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Institution;
use Zttp\Zttp;

class GoogleLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google:locations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Queries Google for institutions' missing locations";

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
        $institutions = Institution::whereNull('latitude')->get();

        $quotaCount = 50;

        $bar = $this->output->createProgressBar(count($institutions));

        foreach ($institutions as $institution) {
            if (!$quotaCount--) {
                $quotaCount = 50;
                sleep(1);
            }

            $data = Zttp::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $institution->name,
                'key' => config('google-maps.key'),
            ])->json();

            $bar->advance();

            $location = $data['results'][0]['geometry']['location'] ?? null;

            if (empty($location['lat'])) {
                continue;
            }

            $institution->update([
                'latitude' => $location['lat'],
                'longitude' => $location['lng'],
            ]);
        }

        $bar->finish();
    }
}
