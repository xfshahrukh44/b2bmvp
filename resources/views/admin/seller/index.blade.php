@extends('admin.layouts.auth')
    
@section('content')
    <div class="container">
        <div class="row col-md-12">
            <!-- Sellers -->
            <div class="col-md-12 mt-4">
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
                                            <div class="bade_approval_wrapper float-right">
                                                &nbsp|
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
                                            <div class="badge_status_wrapper float-right">
                                                @if($seller->account_status === 1)
                                                    <span class="badge badge-primary badge_status">Active</span>
                                                @endif
                                                @if($seller->account_status === 0)
                                                    <span class="badge badge-secondary badge_status">Inactive</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td width="200">
                                            <div class="btn-group">
                                                <button type="button" class="btn dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- approve -->
                                                    @if($seller->is_approved === NULL)
                                                        <a class="dropdown-item btn_approve_seller" href="#" data-id="{{$seller->id}}" style="color:green;">
                                                            Approve
                                                        </a>
                                                    @endif
                                                    <!-- reject -->
                                                    @if($seller->is_approved === NULL)
                                                        <a class="dropdown-item btn_reject_seller" href="#" data-id="{{$seller->id}}" style="color:red;">
                                                            Reject
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                    @endif
                                                    <!-- activate -->
                                                    <a class="dropdown-item btn_activate_seller text-primary" data-id="{{$seller->id}}" href="#" @if($seller->account_status === 1) hidden @endif>
                                                        Activate account
                                                    </a>
                                                    <!-- deactivate -->
                                                    <a class="dropdown-item btn_deactivate_seller text-secondary" data-id="{{$seller->id}}" href="#" @if($seller->account_status === 0) hidden @endif>
                                                        Deactivate account
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="{{route('edit_seller', $seller->slug)}}">
                                                        Edit
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        @if(count($sellers) > 0)
                            {{$sellers->appends(request()->except('page'))->links()}}
                        @endif
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
            var parent = $(this).parent().parent().parent().parent();
            $.ajax({
                url: '<?php echo(route("approve_seller")); ?>',
                type: 'GET',
                data: {seller_id: seller_id},
                dataType: 'JSON',
                async: false,
                success: function (data) {
                    if(data.seller.success == true){
                        parent.find('.btn_approve_seller').hide();
                        parent.find('.btn_reject_seller').hide();
                        parent.find('.badge_approval').remove();
                        parent.find('.dropdown-divider').remove();
                        parent.find('.bade_approval_wrapper').append('<span class="badge badge-success badge_approval">Approved</span>');
                    }
                }
            });
        });

        /// on btn_reject_seller click
        $('.btn_reject_seller').on('click', function(){
            var seller_id = $(this).data('id');
            var parent = $(this).parent().parent().parent().parent();
            $.ajax({
                url: '<?php echo(route("reject_seller")); ?>',
                type: 'GET',
                data: {seller_id: seller_id},
                dataType: 'JSON',
                async: false,
                success: function (data) {
                    if(data.seller.success == true){
                        parent.find('.btn_approve_seller').hide();
                        parent.find('.btn_reject_seller').hide();
                        parent.find('.badge_approval').remove();
                        parent.find('.dropdown-divider').remove();
                        parent.find('.bade_approval_wrapper').append('<span class="badge badge-danger badge_approval">Rejected</span>');
                    }
                }
            });
        });

        // on btn_activate_seller click
        $('.btn_activate_seller').on('click', function(){
            var seller_id = $(this).data('id');
            var parent = $(this).parent().parent().parent().parent();
            $.ajax({
                url: '<?php echo(route("activate_seller")); ?>',
                type: 'GET',
                data: {seller_id: seller_id},
                dataType: 'JSON',
                async: false,
                success: function (data) {
                    if(data.seller.success == true){
                        parent.find('.btn_activate_seller').prop('hidden', true);
                        parent.find('.btn_deactivate_seller').prop('hidden', false);
                        parent.find('.badge_status').remove();
                        parent.find('.badge_status_wrapper').append('<span class="badge badge-primary badge_status">Active</span>');
                    }
                }
            });
        });

        // on btn_deactivate_seller click
        $('.btn_deactivate_seller').on('click', function(){
            var seller_id = $(this).data('id');
            var parent = $(this).parent().parent().parent().parent();
            $.ajax({
                url: '<?php echo(route("deactivate_seller")); ?>',
                type: 'GET',
                data: {seller_id: seller_id},
                dataType: 'JSON',
                async: false,
                success: function (data) {
                    if(data.seller.success == true){
                        parent.find('.btn_deactivate_seller').prop('hidden', true);
                        parent.find('.btn_activate_seller').prop('hidden', false);
                        parent.find('.badge_status').remove();
                        parent.find('.badge_status_wrapper').append('<span class="badge badge-secondary badge_status">Inactive</span>');
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