@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('content')

<style>


body {
        background: url('{{ asset("layout_style/img/background1.jpg") }}') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 0;
    }

.login-wrapper {
  max-width: 450px;
  background: #f8f9fd;
  background: linear-gradient(0deg, rgb(255, 255, 255) 0%, rgb(244, 247, 251) 100%);
  border-radius: 40px;
  padding: 15px 20px;
  border: 5px solid rgb(255, 255, 255);
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 30px 30px -20px;
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  height: auto;
  min-height: 70vh;
}


/* Styling for header and form */
.heading {
  text-align: center;
  font-weight: 900;
  font-size: 30px;
  color: rgb(16, 137, 211);
}

.form {
  margin-top: 20px;
}

.input {
  width: 100%;
  background: white;
  border: none;
  padding: 15px 20px;
  border-radius: 20px;
  margin-top: 15px;
  box-shadow: #cff0ff 0px 10px 10px -5px;
  border-inline: 2px solid transparent;
}

.input::placeholder {
  color: rgb(170, 170, 170);
}

.input:focus {
  outline: none;
  border-inline: 2px solid #12b1d1;
}

.login-button {
  display: block;
  width: 100%;
  font-weight: bold;
  background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
  color: white;
  padding-block: 15px;
  margin: 20px auto;
  border-radius: 20px;
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 20px 10px -15px;
  border: none;
  transition: all 0.2s ease-in-out;
}

.login-button:hover {
  transform: scale(1.03);
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 23px 10px -20px;
}

.login-button:active {
  transform: scale(0.95);
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 15px 10px -10px;
}

/* Social accounts buttons */
.social-account-container {
  margin-top: 25px;
}

.social-account-container .title {
  display: block;
  text-align: center;
  font-size: 10px;
  color: rgb(170, 170, 170);
}

.social-account-container .social-accounts {
  width: 100%;
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 5px;
}

.social-account-container .social-accounts .social-button {
  background: linear-gradient(45deg, rgb(0, 0, 0) 0%, rgb(112, 112, 112) 100%);
  border: 5px solid white;
  padding: 5px;
  border-radius: 50%;
  width: 40px;
  aspect-ratio: 1;
  display: grid;
  place-content: center;
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 12px 10px -8px;
  transition: all 0.2s ease-in-out;
}

.social-account-container .social-accounts .social-button:hover {
  transform: scale(1.2);
}

.social-account-container .social-accounts .social-button:active {
  transform: scale(0.9);
}

.agreement {
  display: block;
  text-align: center;
  margin-top: 15px;
}

.agreement a {
  text-decoration: none;
  color: #0099ff;
  font-size: 9px;
}
.logo-container {
    display: flex;
    justify-content: center;
    margin-bottom: 10px;
}

.logo-circle {
    width: 90px;
    height: 90px;
    background: linear-gradient(135deg, #007bff, #00c6ff);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.login-logo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
}
.heading {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    color: #333;
}
@keyframes shake {
  0% { transform: translate(-50%, -50%) translateX(0); }
  20% { transform: translate(-50%, -50%) translateX(-10px); }
  40% { transform: translate(-50%, -50%) translateX(10px); }
  60% { transform: translate(-50%, -50%) translateX(-10px); }
  80% { transform: translate(-50%, -50%) translateX(10px); }
  100% { transform: translate(-50%, -50%) translateX(0); }
}

.login-wrapper.shake {
  animation: shake 0.5s;
}


    </style>

<div class="login-wrapper">
    <div class="loginbox">
        <div class="login-right">
            <div class="login-right-wrap">

                <div class="logo-container">
                    <div class="logo-circle">
                        <img src="{{ asset('layout_style/img/logo.jpeg') }}" alt="Logo" class="login-logo">
                    </div>
                </div>

                <h2 class="heading">Welcome To ProTrackAI</h2>

                <form method="POST" class="form" id="submitForm" enctype="multipart/form-data">
                    @csrf
                    <input class="input" name="email" id="email" placeholder="E-mail" type="email" required />
                    <div class="input-block">
                        <small class="text-danger err_email"></small>
                    </div>
                    <input class="input" name="password" id="password" placeholder="Password" type="password" required />
                    <div class="input-block">
                        <small class="text-danger err_password"></small>
                    </div>

                    <!-- Show Password Toggle -->
                    <div class="remember-me show-password">
                        <label class="custom_check mr-2 mb-0 d-inline-flex remember-me">
                            Show Password
                            <input type="checkbox" name="radio" class="toggle-password" onclick="togglePassword()">
                            <span class="checkmark"></span>
                        </label>
                    </div>

                    <div class="input-block login-btn">
                        <button class="login-button" type="submit">Login</button>
                    </div>
                </form>
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
                url: "{{ route('login') }}",
                data: formData,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $('#loader').hide();
                    clearError();

                    if (response.status == false) {
                        $.each(response.errors, function(key, item) {
                            if (key) {
                                $('.err_' + key).text(item);
                                $('.' + key).addClass('border-danger');
                            }
                        });
                        let wrapper = document.querySelector('.login-wrapper');
                        wrapper.classList.add('shake');
                        setTimeout(() => {
                            wrapper.classList.remove('shake');
                        }, 500);

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

            $('.err_password').text('');
            $('.password').removeClass('border-danger');
        }



    </script>
    <script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }
</script>

@endsection
