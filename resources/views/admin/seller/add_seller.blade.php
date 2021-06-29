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
    <!-- preview image -->
    <script>
        function showPreview(element, cls){
            var url = element.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (element.files && element.files[0] && (ext == "svg" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(cls).attr('src', e.target.result);
                }
                reader.readAsDataURL(element.files[0]);
            }else{
                // $('#img').attr('src', '/storage/avatars/user.png');
            }
        }
    </script>
@endsection