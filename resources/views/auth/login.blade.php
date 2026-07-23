@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600&display=swap"
    rel="stylesheet">

<style>
    :root {
        --accent: #818CF8;
        --accent-strong: #6366F1;
        --accent-dim: rgba(129, 140, 248, 0.14);
        --danger: #F87171;
        --danger-bg: rgba(248, 113, 113, 0.14);
        --bg: #0A0D14;
        --surface: #12161F;
        --surface-2: #171C27;
        --surface-3: #1D2330;
        --text: #E7E9EE;
        --muted: #8891A5;
        --border: rgba(255, 255, 255, 0.07);
        --border-strong: rgba(255, 255, 255, 0.14);
        --shadow: 0 1px 2px rgba(0, 0, 0, 0.3), 0 8px 24px rgba(0, 0, 0, 0.35);
        --display: 'Manrope', sans-serif;
        --body: 'Inter', sans-serif;
    }

    html {
        background: var(--bg) !important;
        color-scheme: dark;
    }

    .loginbox,
    .login-right,
    .login-right-wrap,
    .account-box,
    .account-content,
    .authentication-wrapper {
        background: transparent !important;
        box-shadow: none !important;
    }

    input[type="checkbox"] {
        accent-color: var(--accent);
    }

    .custom_check .checkmark {
        background: var(--surface-2) !important;
        border: 1px solid var(--border-strong) !important;
    }

    .custom_check input:checked ~ .checkmark {
        background: var(--accent-strong) !important;
        border-color: var(--accent-strong) !important;
    }

    body {
        background: url('{{ asset("layout_style/img/background2.png") }}') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--body);
        color: var(--text);
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(10, 13, 20, 0.78);
        z-index: 0;
    }

    ::selection {
        background: var(--accent-dim);
        color: var(--text);
    }

    .login-wrapper {
        max-width: 450px;
        background: var(--surface);
        border-radius: 40px;
        padding: 15px 20px;
        border: 1px solid var(--border-strong);
        box-shadow: var(--shadow), 0 30px 60px -20px rgba(0, 0, 0, 0.6);
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        height: auto;
        min-height: 70vh;
        z-index: 1;
    }

    .heading {
        text-align: center;
        font-family: var(--display);
        font-weight: 800;
        font-size: 24px;
        color: var(--text);
    }

    .form {
        margin-top: 20px;
    }

    .input {
        width: 100%;
        background: var(--surface-2) !important;
        color: var(--text) !important;
        border: none;
        padding: 15px 20px;
        border-radius: 20px;
        margin-top: 15px;
        box-shadow: inset 0 0 0 1px var(--border-strong);
        border-inline: 2px solid transparent;
    }

    .input::placeholder {
        color: var(--muted) !important;
    }

    .input:focus {
        outline: none;
        background: var(--surface-2) !important;
        color: var(--text) !important;
        border-inline: 2px solid var(--accent);
        box-shadow: 0 0 0 3px var(--accent-dim);
    }

    .input:-webkit-autofill,
    .input:-webkit-autofill:hover,
    .input:-webkit-autofill:focus {
        -webkit-text-fill-color: var(--text) !important;
        -webkit-box-shadow: 0 0 0 1000px var(--surface-2) inset !important;
        caret-color: var(--text);
    }

    .login-button {
        display: block;
        width: 100%;
        font-weight: bold;
        background: linear-gradient(45deg, var(--accent-strong) 0%, var(--accent) 100%);
        color: #fff;
        padding-block: 15px;
        margin: 20px auto;
        border-radius: 20px;
        box-shadow: 0 0 0 1px rgba(129, 140, 248, 0.3), 0 20px 30px -15px rgba(99, 102, 241, 0.4);
        border: none;
        transition: all 0.2s ease-in-out;
    }

    .login-button:hover {
        transform: scale(1.03);
        box-shadow: 0 0 0 1px rgba(129, 140, 248, 0.5), 0 23px 30px -20px rgba(99, 102, 241, 0.5);
    }

    .login-button:active {
        transform: scale(0.95);
        box-shadow: 0 0 0 1px rgba(129, 140, 248, 0.5), 0 15px 20px -10px rgba(99, 102, 241, 0.5);
    }

    .social-account-container {
        margin-top: 25px;
    }

    .social-account-container .title {
        display: block;
        text-align: center;
        font-size: 10px;
        color: var(--muted);
    }

    .social-account-container .social-accounts {
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 5px;
    }

    .social-account-container .social-accounts .social-button {
        background: var(--surface-3);
        border: 5px solid var(--surface);
        padding: 5px;
        border-radius: 50%;
        width: 40px;
        aspect-ratio: 1;
        display: grid;
        place-content: center;
        box-shadow: var(--shadow);
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
        color: var(--accent);
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
        background: linear-gradient(135deg, var(--accent-strong), var(--accent));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 0 1px rgba(129, 140, 248, 0.3), 0 8px 20px rgba(99, 102, 241, 0.35);
    }

    .login-logo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
    }

    .show-password {
        color: var(--muted);
        font-size: .85rem;
    }

    .show-password .checkmark {
        color: var(--text);
    }

    .text-danger {
        color: var(--danger) !important;
    }

    .border-danger {
        box-shadow: inset 0 0 0 1px var(--danger) !important;
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
                        <img src="{{ asset('layout_style/img/prod.png') }}" alt="Logo" class="login-logo">
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