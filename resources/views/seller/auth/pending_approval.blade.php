@extends('seller.layouts.auth')
    
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Notice from management</div>

                    <div class="card-body">
                        Your account is being reviewed and will be activated within 24 hours. Return to <a href="{{route('home')}}">Home Page</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection