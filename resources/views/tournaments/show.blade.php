@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                  <div>Tournament: {{$tournament->title}}</div>
                </div>

                <div class="card-body">
                    <div>Participants List</div>
                    <table class="table table-bordered mb-3">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Idea</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($all_participant)>0)
                                @foreach ($all_participant as $key=>$participant)
                                <tr>
                                    <td>{{$participant->name}}</td>
                                    <td>{{$participant->email}}</td>
                                    <td>{{$participant->idea}}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>


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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    function refreshPage() {
        location.reload();
        console.log("welcome");
    }

    // Refresh the page every minutes
    setInterval(refreshPage, 60000);
});
</script>
@endpush