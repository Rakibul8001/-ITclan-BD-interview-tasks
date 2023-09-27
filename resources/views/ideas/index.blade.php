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
                  <div class="ms-auto flex-shrink-0">
                    <form method="POST" action="{{ route('tournaments.phaseTwo') }}">
                      @csrf
                      <!-- Form fields here -->
                      <button type="submit">Submit</button>
                  </form>
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
                          <td>John Doe</td>
                          <td>john@example.com</td>
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