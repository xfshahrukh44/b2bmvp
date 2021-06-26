@extends('admin.layouts.auth')
    
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        Hi Admin!
                    </div>
                </div>
            </div>

            <!-- Sellers -->
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">Sellers</div>
                        <div class="float-right"><a type="button" class="btn btn-sm btn-secondary btn_add_seller" href="{{route('add_seller')}}">Add Seller</a></div>
                    </div>

                    <div class="card-body">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sellers as $seller)
                                    <tr>
                                        <td class="badge_wrapper">
                                            <!-- name -->
                                            {{$seller->first_name . (($seller->last_name) ? (' ' . $seller->last_name) : (''))}}
                                            
                                            <!-- approval badges -->
                                            <div class="bade_approval_wrapper">
                                                @if($seller->is_approved === NULL)
                                                    <span class="badge badge-secondary badge_approval">Pending approval</span>
                                                @endif
                                                @if($seller->is_approved === 1)
                                                    <span class="badge badge-success badge_approval">Approved</span>
                                                @endif
                                                @if($seller->is_approved === 0)
                                                    <span class="badge badge-danger badge_approval">Rejected</span>
                                                @endif
                                            </div>
                                            <!-- status badges -->
                                            <div class="badge_status_wrapper">
                                                @if($seller->account_status === 1)
                                                    <span class="badge badge-primary badge_status">Active</span>
                                                @endif
                                                @if($seller->account_status === 0)
                                                    <span class="badge badge-secondary badge_status">Inactive</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td width="200">
                                            @if($seller->is_approved === NULL)
                                                <button class="btn btn-success btn-sm btn_approve_seller" data-id="{{$seller->id}}">Approve</button>
                                                <button class="btn btn-danger btn-sm btn_reject_seller" data-id="{{$seller->id}}">Reject</button>
                                            @endif
                                            <br>
                                            <br>
                                            <!-- activate -->
                                            <button class="btn btn-primary btn-sm btn_activate_seller" data-id="{{$seller->id}}" @if($seller->account_status === 1) hidden @endif>
                                                Activate account
                                            </button>
                                            <!-- deactivate -->
                                            <button class="btn btn-secondary btn-sm btn_deactivate_seller" data-id="{{$seller->id}}" @if($seller->account_status === 0) hidden @endif>
                                                Deactivate account
                                            </button>
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
@endsection

@section('scripts')
    <script>
        // on btn_approve_seller click
        $('.btn_approve_seller').on('click', function(){
            var seller_id = $(this).data('id');
            $.ajax({
                url: '<?php echo(route("approve_seller")); ?>',
                type: 'GET',
                data: {seller_id: seller_id},
                dataType: 'JSON',
                async: false,
                success: function (data) {
                    if(data.seller.success == true){
                        $('.btn_approve_seller').hide();
                        $('.btn_reject_seller').hide();
                        $('.badge_approval').remove();
                        $('.bade_approval_wrapper').append('<span class="badge badge-success badge_approval">Approved</span>');
                    }
                }
            });
        });

        /// on btn_reject_seller click
        $('.btn_reject_seller').on('click', function(){
            var seller_id = $(this).data('id');
            $.ajax({
                url: '<?php echo(route("reject_seller")); ?>',
                type: 'GET',
                data: {seller_id: seller_id},
                dataType: 'JSON',
                async: false,
                success: function (data) {
                    if(data.seller.success == true){
                        $('.btn_approve_seller').hide();
                        $('.btn_reject_seller').hide();
                        $('.badge_approval').remove();
                        $('.bade_approval_wrapper').append('<span class="badge badge-danger badge_approval">Rejected</span>');
                    }
                }
            });
        });

        // on btn_activate_seller click
        $('.btn_activate_seller').on('click', function(){
            var seller_id = $(this).data('id');
            $.ajax({
                url: '<?php echo(route("activate_seller")); ?>',
                type: 'GET',
                data: {seller_id: seller_id},
                dataType: 'JSON',
                async: false,
                success: function (data) {
                    if(data.seller.success == true){
                        $('.btn_activate_seller').prop('hidden', true);
                        $('.btn_deactivate_seller').prop('hidden', false);
                        $('.badge_status').remove();
                        $('.badge_status_wrapper').append('<span class="badge badge-primary badge_status">Active</span>');
                    }
                }
            });
        });

        // on btn_deactivate_seller click
        $('.btn_deactivate_seller').on('click', function(){
            var seller_id = $(this).data('id');
            $.ajax({
                url: '<?php echo(route("deactivate_seller")); ?>',
                type: 'GET',
                data: {seller_id: seller_id},
                dataType: 'JSON',
                async: false,
                success: function (data) {
                    if(data.seller.success == true){
                        $('.btn_deactivate_seller').prop('hidden', true);
                        $('.btn_activate_seller').prop('hidden', false);
                        $('.badge_status').remove();
                        $('.badge_status_wrapper').append('<span class="badge badge-secondary badge_status">Inactive</span>');
                    }
                }
            });
        });
    </script>
    
    <script>
        $(document).ready(function(){
            // alert('asd');
        });
    </script>
@endsection