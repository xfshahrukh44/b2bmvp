@extends('layouts.auth')
    
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Notice from management</div>

                    <div class="card-body">
                        This account has been rejected. Return to <a href="{{route('home')}}">Home Page</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection