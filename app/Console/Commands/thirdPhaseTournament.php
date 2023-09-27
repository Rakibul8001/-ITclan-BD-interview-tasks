<?php

namespace App\Console\Commands;

use App\Models\Tournament;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class thirdPhaseTournament extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:thirdPhaseTournament';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '3rd phase tournament and final round';

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
     * @return int
     */
    public function handle()
    {
        Log::info('3rd phase tournament');

        $tournaments = Tournament::where('status','=', 'phase2')->with(['ideas'=>function($query){
            $query->where('status','=', 'phase2')->get();
        }])->get();

        foreach ($tournaments as $tournament) {
            $tournamentIdeas = $tournament->ideas
            ->where('status', 'phase2')
            ->shuffle()
            ->take(1);

            // return $tournamentIdeas;

            if(count($tournamentIdeas)  == 1){
                // return $tournament->ideas;
                foreach ($tournamentIdeas as $idea){
                    $idea->status = 'win';
                    $idea->save();
                }
    
                $tournament->status = 'finished';
                $tournament->save();

                // return $tournament;
            }

        }

        return 1;
    }
}
