@extends('layouts.guest.master')

@section('title', 'Care Provider Login')

@section('content')
<br><br><br>
    <style>
        /* Toggle switch styles */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #7a6ad8;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .toggle-text {
            display: inline-block;
            margin-left: 10px;
            font-weight: bold;
        }
    </style>

    <div class="contact-us section" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="section-heading">
                        <h6>Login</h6>
                        <div class="form-check d-flex align-items-center">
                            <span class="mr-2">  User</span>
                            <label class="switch">
                                <input type="checkbox" id="provider-toggle" onclick="toggleLogin()" checked>
                                <span class="slider round"></span>
                            </label>
                            <span class="ml-2">Care Provider</span>
                        </div>
                        <h2>Care Provider Login</h2>
                        <p>Please login to access your care provider dashboard.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-us-content">
                        <form method="POST" action="{{ route('careprovider.login') }}" id="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Your Email..." autocomplete="off" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Your Password..."  autocomplete="new-password" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="orange-button">Login</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12 text-center mt-3">
                            <p>Don't have an account? <a href="{{ route('register.careprovider') }}">Sign up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleLogin() {
            var checkbox = document.getElementById('provider-toggle');
            if (!checkbox.checked) {
                window.location.href = '{{ route('login.user.form') }}';
            }
        }
    </script>
@endsection
