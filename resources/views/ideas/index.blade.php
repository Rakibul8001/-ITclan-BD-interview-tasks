@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                  <div>Ideas List</div>
                  <div class="ms-auto flex-shrink-0">
                    <a href="{{route('ideas.create')}}"
                    class=" btn btn-primary"

                  >
                    Add New Idea
                  </a>
                  </div>
                 
                </div>

                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($ideas as $key=>$idea)
                      <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$idea->name}}</td>
                          <td>{{$idea->email}}</td>
                          <td>{{$idea->status}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection