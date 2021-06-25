@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Buyer Register') }}</div

                <div class="card-body">
                    <form method="POST" action='{{ url("buyer/register") }}' aria-label="{{ __('Register') }}">
                        @csrf
                        
                        <!-- First Name | first_name -->
                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Last Name | last_name -->
                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- E-Mail Address | email -->
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone | phone -->
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                            <div class="col-md-4 phone_wrapper">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="invalid_phone_alert" hidden>
                                    <strong style="color:red;">Invalid phone number</strong>
                                </span>
                                <span class="valid_phone_alert" hidden>
                                    <strong style="color:green;">OTP has been sent to your phone.</strong>
                                </span>
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-primary form-control btn_send_code" type="button">Send Code</button>
                            </div>
                        </div>

                        <!-- OTP | otp -->
                        <div class="form-group row otp_row" hidden>
                            <label for="otp" class="col-md-4 col-form-label text-md-right">{{ __('OTP') }}</label>

                            <div class="col-md-4 otp_wrapper">
                                <input id="otp" type="number" class="form-control">
                                <span class="invalid_otp_alert" hidden>
                                    <strong style="color:red;">Incorrect OTP</strong>
                                </span>
                                <span class="valid_otp_alert" hidden>
                                    <strong style="color:green;">Verified</strong>
                                </span>
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-primary form-control btn_verify_code" type="button">Verify</button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn_register" disabled>
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        // global vars
        var phone = "";
        var otp = "";

        // on btn_send_code click
        $('.btn_send_code').on('click', function(){
            phone = $('#phone').val();
            var el = $(this);
            el.prop('disabled', true);
            setTimeout(function(){
                if(phone.length > 0){
                    $.ajax({
                        url: '<?php echo(route("send_otp_code")); ?>',
                        type: 'GET',
                        data: {phone: phone},
                        dataType: 'JSON',
                        async: false,
                        success: function (data) {
                            $('.otp_row').prop('hidden', false);
                            $('.invalid_phone_alert').prop('hidden', true);
                            $('.valid_phone_alert').prop('hidden', false);
                            $('#phone').css('border-color', 'green');
                            el.prop('disabled', true);
                        },
                        error: function(){
                            $('.otp_row').prop('hidden', true);
                            $('.invalid_phone_alert').prop('hidden', false);
                            $('.valid_phone_alert').prop('hidden', true);
                            $('#phone').css('border-color', 'red');
                            el.prop('disabled', false);
                        }
                    });
                }
            }, 1);
        });

        // on btn_verify_code click
        $('.btn_verify_code').on('click', function(){
            otp = $('#otp').val();
            var el = $(this);
            el.prop('disabled', true);
            // verify_otp_code
            setTimeout(function(){
                if(otp.length > 0){
                    $.ajax({
                        url: '<?php echo(route("verify_otp_code")); ?>',
                        type: 'GET',
                        data: {
                            otp: otp,
                            phone: phone
                        },
                        dataType: 'JSON',
                        async: false,
                        success: function (data) {
                            if(data == 1){
                                $('.invalid_otp_alert').prop('hidden', true);
                                $('.valid_otp_alert').prop('hidden', false);
                                $('#otp').css('border-color', 'green');
                                $('#btn_register').prop('disabled', false);
                                el.prop('disabled', true);
                            }
                            else{
                                $('.invalid_otp_alert').prop('hidden', false);
                                $('.valid_otp_alert').prop('hidden', true);
                                $('#otp').css('border-color', 'red');
                                $('#btn_register').prop('disabled', true);
                                el.prop('disabled', false);
                            }
                        }
                    });
                }
            }, 1);
        });
    </script>
@endsection
