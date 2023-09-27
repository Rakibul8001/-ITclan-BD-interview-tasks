<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function store(Request $request){
        $tournament = Tournament::create([
            'title' => 'Tournament 2',
            'status' => 'start',
        ]);

        $ideas = Idea::pluck('id')->toArray();

        $tournament->ideas()->attach($ideas);

        return $tournament;
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
