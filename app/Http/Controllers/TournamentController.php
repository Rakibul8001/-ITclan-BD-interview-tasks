<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{

    public function index(){
        $tournaments = Tournament::get();

        return view('tournaments.index', compact('tournaments'));
    }

    public function store(Request $request){
        $tournament = Tournament::create([
            'title' => 'Tournament 2',
            'status' => 'start',
        ]);

        $ideas = Idea::pluck('id')->toArray();

        $tournament->ideas()->attach($ideas);

        return $tournament;
    }

    public function show($id){
        $tournament = Tournament::find($id);

        if(!$tournament){
            dd('No tournament found!');
        }


        $all_participant = $tournament->ideas;
        $phase_one = $tournament->ideas->where('phase_one', 1)->take(4);
        $phase_two = $tournament->ideas->where('phase_two', 1)->take(2);
        $final_phase = $tournament->ideas->where('final_phase', 1)->take(1);

        // dd($all_participant) ;
        return view('tournaments.show', compact('tournament','all_participant', 'phase_one','phase_two','final_phase'));


    }


    public function start(Request $request){
        $tournaments = Tournament::where('status','=', 'start')->with(['ideas'=>function($query){
            $query->where('status','=', 'participated')->get();
        }])->get();

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

        return 1;


    }

    public function phaseOne(Request $request){
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

    public function phaseTwo(Request $request){
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
