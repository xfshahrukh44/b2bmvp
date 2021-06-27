@extends('admin.layouts.auth')
    
@section('content')
    <div class="container">
        <div class="row col-md-12">

            <!-- Sellers -->
            <div class="col-md-3 mt-4">
                <a href="{{route('seller_index')}}" style="text-decoration: none; color:inherit;">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <strong>Sellers</strong>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection