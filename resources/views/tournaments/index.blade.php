@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Tournaments List</div>
                @php
                    $counter = ($tournaments->currentPage() - 1) * $tournaments->perPage() + 1;
                @endphp
                <div class="card-body">
                  @if (count($tournaments)>0)
                    <table class="table table-bordered mb-3">
                        <thead>
                            <tr>
                                <th>#Sl</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>action</th>

                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($tournaments as $tournament)
                            <tr>
                            
                                <td>{{$counter}}</td>
                                <td>{{$tournament->title}}</td>
                                <td>{{$tournament->status}}</td>
                                <td>
                                    <a href="{{route('tournaments.show',['id'=>$tournament->id])}}">view</a>
                                </td>
                            </tr>
                            @php
                                $counter++;
                            @endphp
                            @endforeach
                            
                        </tbody>
                    </table>

                    {{ $tournaments->links() }}

                  @else
                    <p>No Data Found !</p>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
