<?php

namespace App\Console\Commands;

use App\Models\Idea;
use App\Models\Tournament;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class StartTournament extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tournament:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start a tournament with the first 8 active ideas';

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
        // Log::info('starting tournament');

        //1st round starts
        $tournaments = Tournament::where('status','=', 'start')->with(['ideas'=>function($query){
            $query->where('status','=', 'participated')->get();
        }])->get();

        if(count($tournaments) > 0){
            Log::info('starting tournament');
            foreach ($tournaments as $tournament) {
                $tournamentIdeas = $tournament->ideas
                ->where('status', 'participated')
                ->shuffle()
                ->take(4);
    
                // return $tournament;
    
                if(count($tournamentIdeas)  == 4){
                    // return $tournament->ideas;
                    foreach ($tournamentIdeas as $idea){
                        $idea->status = 'phase1';
                        $idea->save();
                    }
        
                    $tournament->status = 'phase1';
                    $tournament->save();
    
                    // return $tournament;
                }
    
            }
        }

        //2nd round

        $tournaments = Tournament::where('status','=', 'phase1')->with(['ideas'=>function($query){
            $query->where('status','=', 'phase1')->get();
        }])->get();

        if(count($tournaments) > 0){
            Log::info('2nd phase tournament');

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
        }


        //3rd round and final

        $tournaments = Tournament::where('status','=', 'phase2')->with(['ideas'=>function($query){
            $query->where('status','=', 'phase2')->get();
        }])->get();

        if(count($tournaments) > 0){
            Log::info('3rd phase tournament');

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
        }




        return 1;
    }
}
