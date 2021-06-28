@extends('admin.layouts.auth')

@section('content')
    <div class="container">
        <div class="row">
            <!-- main form -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>Edit Seller</strong></div>

                    <div class="card-body">
                        <form method="POST" action="{{route('update_seller', $seller->slug)}}" enctype="multipart/form-data" class="row">
                            @csrf
                            @method('PUT')
                            @include('admin.seller.seller_master')
                            
                            <!-- Submit -->
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn- btn-primary btn-sm form-control">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Shipping regions -->
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <strong>Shipping regions</strong>
                        </div>
                        <div class="float-right">
                            <a type="button" class="btn btn-sm btn-secondary btn_add_shipping_region" data-toggle="modal" data-target="#addShippingRegionModal">Add</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Time</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="tbody_shipping_region">
                                @foreach($seller->shipping_regions as $shipping_region)
                                    <tr>
                                        <!-- title -->
                                        <td>
                                            <input class="form-control shipping_region_title" type="text" value="{{$shipping_region->title}}">
                                        </td>
                                        <!-- time -->
                                        <td>
                                            <input class="form-control shipping_region_time" type="text" value="{{$shipping_region->time}}">
                                        </td>
                                        <!-- price -->
                                        <td>
                                            <input class="form-control shipping_region_price" type="number" value="{{$shipping_region->price}}" step="0.01">
                                        </td>
                                        <!-- actions -->
                                        <td width="50" class="text-center">
                                            <a class="btn_update_shipping_region text-primary" href="#" data-id="{{$shipping_region->id}}"><i class="fas fa-pen"></i></a>
                                            <a class="btn_remove_shipping_region text-danger" href="#" data-id="{{$shipping_region->id}}"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Create shippingRegion view -->
    <div class="modal fade" id="addShippingRegionModal" tabindex="-1" role="dialog" aria-labelledby="addShippingRegionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id=""><strong>Add new shipping region</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" class="shippingRegionForm">
                    @csrf
                    <div class="modal-body row">
                            <!-- seller_id -->
                            <input type="number" name="seller_id" value="{{$seller->id}}" hidden>
                            <!-- Title | title -->
                            <div class="form-group has-feedback col-md-4">
                                <label for=""><strong>Title</strong></label>
                                <input type="text" name="title" value="{{old('title')}}" class="form-control shipping_region_title" required max="50" placeholder="Enter title">
                                <span class="form-control-feedback"></span>
                                <span class="text-danger">
                                    <strong id="shipping-region-title-error"></strong>
                                </span>
                            </div>
                            <!-- Time | time -->
                            <div class="form-group has-feedback col-md-4">
                                <label for=""><strong>Time</strong></label>
                                <input type="text" name="time" value="{{old('time')}}" class="form-control shipping_region_time" required max="50" placeholder="Enter time">
                                <span class="form-control-feedback"></span>
                                <span class="text-danger">
                                    <strong id="shipping-region-time-error"></strong>
                                </span>
                            </div>
                            <!-- Price | price -->
                            <div class="form-group has-feedback col-md-4">
                                <label for=""><strong>Price</strong></label>
                                <input type="number" name="price" value="{{old('price')}}" step="0.01" class="form-control shipping_region_price" value="0.00" required>
                                <span class="form-control-feedback"></span>
                                <span class="text-danger">
                                    <strong id="shipping-region-price-error"></strong>
                                </span>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary col-md-12" id="storeShippingRegionButton" data-id="{{$seller->id}}">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // on storeShippingRegionButton click
        $('#storeShippingRegionButton').on('click', function(e){
            var formData = $('.shippingRegionForm').serialize();
            $('#shipping-region-title-error').html("");
            $('#shipping-region-time-error').html("");
            $('#shipping-region-price-error').html("");

            $.ajax({
                url:`<?php echo(route('create_shipping_region')); ?>`,
                type:'POST',
                async: false,
                data:formData,
                success:function(data) {
                    console.log(data);
                    var shipping_region = data;
                    $('#addShippingRegionModal .shipping_region_title').val('');
                    $('#addShippingRegionModal .shipping_region_time').val('');
                    $('#addShippingRegionModal .shipping_region_price').val(0.00);
                    $('.tbody_shipping_region').append(`<tr>
                                                            <!-- title -->
                                                            <td>
                                                                <input class="form-control shipping_region_title" type="text" value="`+shipping_region.title+`">
                                                            </td>
                                                            <!-- time -->
                                                            <td>
                                                                <input class="form-control shipping_region_time" type="text" value="`+shipping_region.time+`">
                                                            </td>
                                                            <!-- price -->
                                                            <td>
                                                                <input class="form-control shipping_region_price" type="number" value="`+shipping_region.price+`" step="0.01">
                                                            </td>
                                                            <!-- actions -->
                                                            <td width="50" class="text-center">
                                                                <a class="btn_update_shipping_region text-primary" href="#" data-id="`+shipping_region.id+`"><i class="fas fa-pen"></i></a>
                                                                <a class="btn_remove_shipping_region text-danger" href="#" data-id="`+shipping_region.id+`"><i class="fas fa-trash"></i></a>
                                                            </td>
                                                        </tr>`);
                                                        
                    toastr.success('Shipping region added');
                    $('#addShippingRegionModal').modal('hide');
                },
                error: function(data){
                    if(data.responseJSON.errors) {
                        var errors = data.responseJSON.errors;
                        if(errors.title){
                            $('#shipping-region-title-error').html(errors.title[0]);
                        }
                        if(errors.time){
                            $('#shipping-region-time-error').html(errors.time[0]);
                        }
                        if(errors.price){
                            $('#shipping-region-price-error').html(errors.price[0]);
                        }
                        
                    }
                },
            });
        });

        // on btn_update_shipping_region click
        $('.btn_update_shipping_region').on('click', function(){
            var id = $(this).data('id');
            var url = `<?php echo(route('update_shipping_region', 'id')); ?>`;
            url = url.replace('id', id);
            var parent = $(this).parent().parent();
            var title = parent.find('.shipping_region_title').val();
            var time = parent.find('.shipping_region_time').val();
            var price = parent.find('.shipping_region_price').val();

            $.ajax({
                url: url,
                type:'GET',
                async: false,
                data: {
                    title: title,
                    time: time,
                    price: price
                },
                success:function(data) {
                    toastr.success('Shipping region updated.');
                },
                error: function(data){
                    if(data.responseJSON.errors) {
                        var errors = data.responseJSON.errors;
                        var errors_string = "";
                        for (const [key, value] of Object.entries(errors)) {
                            // console.log(key, value);
                            errors_string += value + '<br>';
                        }
                        toastr.error(errors_string, 'Warning');
                    }
                },
            });
        });

        // on btn_remove_shipping_region click
        $('.btn_remove_shipping_region').on('click', function(){
            var parent = $(this).parent().parent();
            var id = $(this).data('id');
            var url = `<?php echo(route('destroy_shipping_region', 'id')); ?>`;
            url = url.replace('id', id);

            // destroy_shipping_region
            $.ajax({
                url: url,
                type:'GET',
                async: false,
                data: {},
                success:function(data) {
                    parent.remove();
                    toastr.success('Shipping region deleted.');
                },
                error: function(data){
                    if(data.responseJSON.errors) {
                        var errors = data.responseJSON.errors;
                        var errors_string = "";
                        for (const [key, value] of Object.entries(errors)) {
                            // console.log(key, value);
                            errors_string += value + '<br>';
                        }
                        toastr.error(errors_string, 'Warning');
                    }
                },
            });
        });
    </script>
    
    <script>
        $(document).ready(function(){
            
        });
    </script>
@endsection