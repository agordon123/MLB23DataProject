<?php

namespace App\Console\Commands;


use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ParseTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses teams.json and stores it in the teams table';
    protected $team;
    public function __construct()
    {
        parent::__construct();
        $this->team = new Team();
    }
    /**
     * Execute the console command.
     */
    public function handle(Team $team)
    {
        $directory = 'public';
        $teamFile = Storage::get($directory . '/teams.json');
        $data = json_decode($teamFile, true);;

        foreach ($data['teams'] as $team) {
            $name = $team['name'];
            $abbreviation = $team['abbreviation'];
            $team = new Team(['team_name' => $name, 'team_short_name' => $abbreviation]);
            $team->save();
            // DB::table('teams')->insert(['team_name' => $v['name'], 'team_short_name' => $v['abbreviation'],'created_at'=>Date::now(),'updated_at'=>Date::now()]);
            $this->info($team . 'inserted in table');
            //   $newTeam->team_name  = $team['name'];
            //   $newTeam->team_short_name = $team['abbreviation'];
            //   $newTeam->save();

        }
        $this->info('Operation successfully saved');
    }
}
