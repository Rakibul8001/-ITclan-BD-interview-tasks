<?php

namespace App\Console\Commands;

use App\Models\Tournament;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class secondPhaseTournament extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:secondPhaseTournament';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tournament 2nd Phase';

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
        Log::info('2nd phase tournament');
        $tournaments = Tournament::where('status','=', 'phase1')->with(['ideas'=>function($query){
            $query->where('status','=', 'phase1')->get();
        }])->get();

        foreach ($tournaments as $tournament) {
            $tournamentIdeas = $tournament->ideas
            ->where('status', 'phase1')
            ->shuffle()
            ->take(2);

            // return $tournament;

            if(count($tournamentIdeas)  == 2){
                // return $tournament->ideas;
                foreach ($tournamentIdeas as $idea){
                    $idea->status = 'phase2';
                    $idea->save();
                }
    
                $tournament->status = 'phase2';
                $tournament->save();

                // return $tournament;
            }

        }

        return 1;
    }
}
