<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Tournament;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index(){
        $ideas = Idea::paginate(10);
        return view('ideas.index',compact('ideas'));
    }
    public function create(){
        return view('ideas.create');
    }
    public function store(Request $request){
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email', // Use 'email' rule for email validation
            'idea' => 'required|string',
        ]);

        // Create a new idea
        Idea::create([
            'user_id' => auth()->user()->id,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'idea' => $validatedData['idea'],
            'status' => 'active'
        ]);


        $ideas = Idea::where('status', 'active')->take(8)->get();

        if ($ideas->count() === 8) {
            $totalTournaments = Tournament::count();
            $nextNumber = $totalTournaments + 1;
    
            $tournament = Tournament::create([
                'title' => 'Tournament Number '.$nextNumber,
                'status' => 'start',
            ]);

            foreach ($ideas as $idea) {
                $tournament->ideas()->attach($idea);
                $idea['status'] = 'participated';
                $idea->save();
            }

            return redirect()->route('tournaments.show', ['id' => $tournament->id]);

        } else {
            
            return redirect()->route('ideas.index')->with('success', 'Idea created successfully');
        }



    }
}
