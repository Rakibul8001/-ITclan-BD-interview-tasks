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
    alert('alert from home page');
    function tournamentRefreshPage() {
        location.reload();
        console.log("welcome");
    }

    // Refresh the page every minutes
    setInterval(tournamentRefreshPage, 60000);
});
</script>
@endpush
