@extends('layouts.auth')
    
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
                    <div class="card-header">Sellers</div>

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
                                            {{$seller->first_name . (($seller->last_name) ? (' ' . $seller->last_name) : (''))}}
                                            <br>
                                            @if($seller->is_approved === NULL)
                                                <span class="badge badge-secondary">Pending approval</span>
                                            @endif
                                            @if($seller->is_approved === 1)
                                                <span class="badge badge-success">Approved</span>
                                            @endif
                                            @if($seller->is_approved === 0)
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td width="200">
                                            @if($seller->is_approved === NULL)
                                                <button class="btn btn-success btn-sm btn_approve_seller" data-id="{{$seller->id}}">Approve</button>
                                                <button class="btn btn-danger btn-sm btn_reject_seller" data-id="{{$seller->id}}">Reject</button>
                                            @endif
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
                        $('.badge').remove();
                        $('.badge_wrapper').append('<span class="badge badge-success">Approved</span>');
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
                        $('.badge').remove();
                        $('.badge_wrapper').append('<span class="badge badge-danger">Rejected</span>');
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