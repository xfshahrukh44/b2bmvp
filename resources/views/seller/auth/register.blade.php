@extends('seller.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Seller Register') }}</div

                <div class="card-body">
                    <form method="POST" action='{{ url("seller/register") }}' aria-label="{{ __('Register') }}">
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

                        <!-- Company Name | company_name -->
                        <div class="form-group row">
                            <label for="company_name" class="col-md-4 col-form-label text-md-right">{{ __('Company Name') }}</label>

                            <div class="col-md-6">
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name">

                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- I am a | type -->
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('I am a') }}</label>

                            <div class="col-md-6">
                                <select name="type" class="form-control @error('type') is-invalid @enderror type" value="{{ old('type') }}" required>
                                    <option value="">Select type</option>
                                    <option value="Manufacturer">Manufacturer</option>
                                    <option value="Distributor">Distributor</option>
                                    <option value="Seller">Seller</option>
                                </select>
                            </div>
                        </div>

                        <!-- Province | province_id -->
                        <div class="form-group row">
                            <label for="province_id" class="col-md-4 col-form-label text-md-right">{{ __('Province') }}</label>

                            <div class="col-md-6">
                                <select name="province_id" class="form-control @error('province_id') is-invalid @enderror province_id" value="{{ old('province_id') }}" required>
                                    <option value="">Select Province</option>
                                    @foreach($provinces as $province)
                                        <option value="{{$province->id}}">{{$province->name}}</option>
                                    @endforeach
                                </select>

                                @error('province_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- City | city_id -->
                        <div class="form-group row">
                            <label for="city_id" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                            <div class="col-md-6">
                                <select name="city_id" class="form-control @error('city_id') is-invalid @enderror city_id" required>
                                    <option value="">Select City</option>
                                </select>

                                @error('city_id')
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

                            <div class="col-md-4">
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
        $(document).ready(function(){
            $('.province_id').select2();
            $('.city_id').select2();

            // on province_id change
            $('.province_id').on('change', function(){
                var id = $(this).val();
                var url = '<?php echo(route("find_province", 'id')); ?>';
                url = url.replace('id', id);

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {},
                    dataType: 'JSON',
                    async: false,
                    success: function (data) {
                        var cities = data.cities;
                        $('.city_id').html('<option value="">Select City</option>');
                        for(var i = 0; i < cities.length; i++){
                            var option = `<option value="`+cities[i].id+`">`+cities[i].name+`</option>`;
                            $('.city_id').append(option);
                        }
                        $('.city_id').select2();
                    }
                });
            });
        });
    </script>

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
                            $('#phone').css('border-color', '#ced4da');
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
                                $('#otp').css('border-color', '#ced4da');
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
