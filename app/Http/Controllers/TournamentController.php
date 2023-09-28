<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{

    public function index(){
        $tournaments = Tournament::paginate(10);

        return view('tournaments.index', compact('tournaments'));
    }

    public function store(Request $request){
        
        $totalTournaments = Tournament::count();
        $nextNumber = $totalTournaments + 1;

        $tournament = Tournament::create([
            'title' => 'Tournament Number '.$nextNumber,
            'status' => 'start',
        ]);

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

}
