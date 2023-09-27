@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-8">

            <div class="card">
              <div class="d-flex align-items-center mb-2">
                <div>
                  <h4 class="card-title">All Restaurant Invoices</h4>
                </div>
               
                <div class="ms-auto flex-shrink-0">
               
                  <a href="{{route('ideas.create')}}"
                    class=" btn btn-primary"

                  >
                    Add New Booking
                  </a>
               

                </div>
            </div>

                </div>
                <div class="card-body">
                    <p>idea list</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection