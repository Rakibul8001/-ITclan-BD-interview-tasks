@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                  <div><strong>Ideas List</strong></div>
                  <div class="ms-auto flex-shrink-0">
                    <a href="{{route('ideas.create')}}"
                    class=" btn btn-primary"

                  >
                    Add New Idea
                  </a>
                  </div>
                 
                </div>

                @php
                    $counter = ($ideas->currentPage() - 1) * $ideas->perPage() + 1;
                @endphp

                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#Sl</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Idea</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($ideas as $key=>$idea)
                      <tr>
                          <td>{{$counter}}</td>
                          <td>{{$idea->name}}</td>
                          <td>{{$idea->email}}</td>
                          <td>{{$idea->idea}}</td>
                          <td>{{$idea->status}}</td>
                      </tr>

                      @php
                        $counter++;
                      @endphp
                      @endforeach
                    </tbody>
                </table>

                {{$ideas->links()}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection