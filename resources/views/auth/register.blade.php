@extends('layouts.auth')

@section('title')
    Register
@endsection

@section('content')
    <div class="col-lg-6 login-wrap">
        <div class="login-sec">
            <div class="log-img">
                <img class="img-fluid" src="{{ asset('layout_style/img/login.png') }}" alt="Logo">
            </div>
        </div>
    </div>

    <div class="col-lg-6 login-wrap-bg">
        <div class="login-wrapper">
            <div class="loginbox">
                <div class="login-right">
                    <div class="login-right-wrap">
                        <h2>Register</h2>

                        <form method="POST" class="text-left" id="submitForm" enctype="multipart/form-data">
                            @csrf
                            <div class="input-block">
                                <label>First Name <span class="login-danger">*</span></label>
                                <input class="form-control lock-icon-field" name="first_name" id="first_name"
                                    placeholder="First name" type="text">
                                <span class="user-icon fa fa-user"></span>
                            </div>
                            <div class="input-block">
                                <small class="text-danger err_first_name"></small>
                            </div>

                            <div class="input-block">
                                <label>Last Name <span class="login-danger">*</span></label>
                                <input class="form-control lock-icon-field" name="last_name" id="last_name"
                                    placeholder="Last name" type="text">
                                    <span class="user-icon fa fa-user"></span>
                            </div>
                            <div class="input-block">
                                <small class="text-danger err_last_name"></small>
                            </div>

                            <div class="input-block">
                                <label>Email <span class="login-danger">*</span></label>
                                <input class="form-control email lock-icon-field" name="email" id="email"
                                    placeholder="example@gmail.com" type="text">
                                <span class="user-icon fa fa-user"></span>
                            </div>
                            <div class="input-block">
                                <small class="text-danger err_email"></small>
                            </div>

                            <div class="input-block">
                                <label>Password <span class="login-danger">*</span></label>
                                <input class="form-control pass-input password lock-icon-field" type="password" id="password" name="password"
                                    placeholder="********">
                                <span class="lock-icon feather-lock"></span>
                            </div>
                            <div class="input-block">
                                <small class="text-danger err_password"></small>
                            </div>

                            <div class="input-block">
                                <label>Confirm Password <span class="login-danger">*</span></label>
                                <input class="form-control pass-input password lock-icon-field" type="password" id="confirm_password" name="confirm_password"
                                    placeholder="********">
                                <span class="lock-icon feather-lock"></span>
                            </div>
                            <div class="input-block">
                                <small class="text-danger err_confirm_password"></small>
                            </div>

                            <input type="hidden" name="status" value="1">

                             <!-- Show Password Toggle -->
                             <div class="remember-me show-password">
                                <label class="custom_check mr-2 mb-0 d-inline-flex remember-me">
                                    Show Password
                                    <input type="checkbox" name="radio"  class= "toggle-password" onclick="togglePassword()">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="forgotpass">
                                <div class="remember-me">
                                    <!--
                                        <label class="custom_check mr-2 mb-0 d-inline-flex remember-me">
                                            Remember me
                                            <input type="checkbox" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    -->
                                </div>
                                <a href="/login">Log in</a>
                            </div>
                            <div class="input-block login-btn">
                                <button class="btn btn-primary btn-block" type="submit">Register</button>
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
        $('#submitForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData($('#submitForm')[0]);

            $.ajax({
                type: "POST",
                beforeSend: function() {
                    $('#loader').show()
                },
                url: "{{ route('register') }}",
                data: formData,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $('#loader').hide()
                    console.log(response);
                    clearError();

                    if (response.status == false) {
                        $.each(response.errors, function(key, item) {
                            if (key) {
                                $('.err_' + key).text(item);
                                $('.' + key).addClass('border-danger');
                            }
                        });
                    } else {
                        location.href = response.route;
                    }
                },
                error: function(data) {
                    console.log(data);
                    $('#loader').hide()
                    alert('Something went to wrong')
                }
            });
        });

        function clearError() {
            $('.err_email').text('');
            $('.email').removeClass('border-danger');

            $('.err_first_name').text('');
            $('.first_name').removeClass('border-danger');

            $('.err_last_name').text('');
            $('.last_name').removeClass('border-danger');

            $('.err_email').text('');
            $('.email').removeClass('border-danger');

            $('.err_password').text('');
            $('.password').removeClass('border-danger');

            $('.err_confirm_password').text('');
            $('.confirm_password').removeClass('border-danger');
        }



    </script>
@endsection
