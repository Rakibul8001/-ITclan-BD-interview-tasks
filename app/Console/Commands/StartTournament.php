<?php

namespace App\Console\Commands;

use App\Models\Idea;
use App\Mail\SendEmail;
use App\Models\Tournament;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        Log::info('starting tournament');

        //1st round starts
        $tournaments = Tournament::where('status','=', 'start')->with(['ideas'=>function($query){
            $query->where('status','=', 'participated')->get();
        }])->get();

        if(count($tournaments) > 0){
            // Log::info('starting tournament');
            foreach ($tournaments as $tournament) {

                if ($tournament->created_at->addMinutes(4)->isPast()) {
                    // Perform the third action
                    Log::info('5 minutes gone');

                    $tournamentIdeas = $tournament->ideas
                    ->where('status', 'participated')
                    ->shuffle()
                    ->take(4);
        
                    // return $tournament;
        
                    if(count($tournamentIdeas)  == 4){
                        $message = "Congratulations! You have passed 1st phase of the tournament";
                        $recipients = [];

                        foreach ($tournamentIdeas as $idea){
                            $idea->phase_one = 1;
                            $idea->save();

                            $recipients[]=$idea->email;
                        }
            
                        $tournament->status = 'phase1';
                        $tournament->save();

                        Log::info($recipients);
                        Log::info('1st phase completed successfully');

                        //send mail to
                        Mail::to($recipients)->send(new SendEmail($message));
        
                        // return $tournament;
                    }
                }

    
            }
        }

        //2nd round

        $tournaments = Tournament::where('status','=', 'phase1')->with(['ideas'=>function($query){
            $query->where('phase_one','=', 1)->get();
        }])->get();

        if(count($tournaments) > 0){


            foreach ($tournaments as $tournament) {

                if ($tournament->created_at->addMinutes(9)->isPast()) {
                    Log::info('2nd phase tournament 10 minutes');

                    $tournamentIdeas = $tournament->ideas
                    ->where('phase_one', 1)
                    ->shuffle()
                    ->take(2);
        
                    // return $tournament;
        
                    if(count($tournamentIdeas)  == 2){

                        $message = "Congratulations! You have passed 2nd phase of the tournament";
                        $recipients = [];
                        // return $tournament->ideas;
                        foreach ($tournamentIdeas as $idea){
                            $idea->phase_two = 1;
                            $idea->save();

                            $recipients[]=$idea->email;
                        }
            
                        $tournament->status = 'phase2';
                        $tournament->save();
                        Log::info($recipients);
                        Log::info('2nd phase completed successfully');
                        // return $tournament;

                        Mail::to($recipients)->send(new SendEmail($message));
                    }
                }

    
            }
        }


        //3rd round and final

        $tournaments = Tournament::where('status','=', 'phase2')->with(['ideas'=>function($query){
            $query->where('phase_two','=', 1)->get();
        }])->get();

        if(count($tournaments) > 0){

            foreach ($tournaments as $tournament) {

                if ($tournament->created_at->addMinutes(14)->isPast()) {
                    Log::info('final phase tournament 15 minutes');

                    $tournamentIdeas = $tournament->ideas
                    ->where('phase_two', 1)
                    ->shuffle()
                    ->take(1);
        
                    // return $tournamentIdeas;
        
                    if(count($tournamentIdeas)  == 1){
                        $message = "Congratulations! You have won the tournament";
                        $recipients=[];

                        foreach ($tournamentIdeas as $idea){
                            $idea->final_phase = 1;
                            $idea->save();

                            $recipients[]=$idea->email;
                        }
            
                        $tournament->status = 'finished';
                        $tournament->save();
        
                        Log::info($recipients);
                        Log::info('3rd phase completed successfully');
                        
                        Mail::to($recipients)->send(new SendEmail($message));
                    }
                }

    
            }
        }




        return 1;
    }
}
