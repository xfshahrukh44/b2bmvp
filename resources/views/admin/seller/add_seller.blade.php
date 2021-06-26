@extends('admin.layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Add Seller</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('create_seller')}}" enctype="multipart/form-data" class="row">
                            @csrf
                            @include('admin.seller.seller_master')
                            
                            <!-- Submit -->
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn- btn-primary btn-sm form-control">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection