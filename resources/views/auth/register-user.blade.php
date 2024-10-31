@extends('layouts.guest.master')

@section('title', 'Register as a User')

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
    </style>

    <div class="contact-us section" id="register">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="section-heading">
                        <h6>Register</h6>
                        <div class="form-check d-flex align-items-center">
                            <span class="mr-2">  User</span>
                            <label class="switch">
                                <input type="checkbox" id="provider-toggle" onclick="toggleRegister()">
                                <span class="slider round"></span>
                            </label>
                            <span class="ml-2">Care Provider</span>
                        </div>
                        <h2>Register as a User</h2>
                        <p>Please fill in your details below to create a new account.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-us-content">
                        <form method="POST" action="{{ route('register.user') }}" id="contact-form">
                            @csrf
                            <div class="row">
                                <!-- Input fields for User Register Form -->
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input id="name" type="text" class="form-control" name="name" placeholder="Your Name..." autocomplete="off" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input id="email" type="email" class="form-control" name="email" placeholder="Your Email..." autocomplete="off" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input id="password" type="password" class="form-control" name="password" placeholder="Your Password..." autocomplete="new-password" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password..." required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" class="orange-button">Register</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12 text-center mt-3">
                            <p>You already have an account? <a href="{{ route('login.user.form') }}">Log in</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleRegister() {
            var checkbox = document.getElementById('provider-toggle');
            if (checkbox.checked) {
                window.location.href = '{{ route('register.careprovider') }}';
            }
        }
    </script>
@endsection
