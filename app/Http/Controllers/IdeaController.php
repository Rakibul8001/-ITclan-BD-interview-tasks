<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index(){
        return view('ideas.index');
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
            'idea' => $validatedData['idea']
        ]);

        return redirect()->route('ideas.index')->with('success', 'Idea created successfully');
    }
}
