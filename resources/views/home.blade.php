@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Active Running Tournaments</div>

                <div class="card-body">
                  @if (count($tournaments)>0)

                  @foreach ($tournaments as $tournament)
                  
                  <div class="text-center mb-3"><u>Running: {{$tournament->title}}</u> </div>

                  <h5 class="countdown text-center text-danger" data-end-time="{{ $tournament->created_at->addMinutes(15) }}"></h5>
                
                    @php
                        $phase_one = $tournament->ideas->where('phase_one', 1)->take(4);
                        $phase_two = $tournament->ideas->where('phase_two', 1)->take(2);
                        $final_phase = $tournament->ideas->where('final_phase', 1)->take(1);
                    @endphp

                        <div><strong>1st Phase</strong></div>
                        <table class="table table-bordered mb-3">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($phase_one)>0)
                                    @foreach ($phase_one as $key=>$participant)
                                    <tr>
                                    
                                        <td>{{$participant->name}}</td>
                                        <td>{{$participant->email}}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div><strong>2nd Phase</strong></div>
                        <table class="table table-bordered mb-3">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($phase_two)>0)
                                    @foreach ($phase_two as $key=>$participant)
                                    <tr>
                                    
                                        <td>{{$participant->name}}</td>
                                        <td>{{$participant->email}}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
    
                        <div><strong>Final Phase</strong></div>
                        <table class="table table-bordered mb-3">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($final_phase)>0)
                                    @foreach ($final_phase as $key=>$participant)
                                    <tr>
                                    
                                        <td>{{$participant->name}}</td>
                                        <td>{{$participant->email}}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                  @endforeach

                      
                  @else
                    <p>No running tournaments</p>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    // alert('alert from home page');
    function tournamentRefreshPage() {
        location.reload();
        console.log("welcome");
    }

    // Refresh the page every minutes
    setInterval(tournamentRefreshPage, 60000);

    //countdown the tournament
    var countdownElements = document.querySelectorAll('.countdown');
    console.log('countdown elements', countdownElements);

    countdownElements.forEach(function(element) {
        var endTime = new Date(element.getAttribute('data-end-time')).getTime();

        // Update the countdown timer for each element
        var x = setInterval(function() {
            var now = new Date().getTime();
            var timeRemaining = endTime - now;

            if (timeRemaining <= 0) {
                clearInterval(x);
                element.innerHTML = "Countdown expired!";
            } else {
                var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
                var formattedTime = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
                element.innerHTML = "Countdown: " + formattedTime;
            }
        }, 1000);
    });
});
</script>
@endpush
