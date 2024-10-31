@extends('layouts.guest.master')

@section('title', 'Register as a Care Provider')

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

    <div class="contact-us section" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="section-heading">
                        <h6>Register</h6>
                        <div class="form-check d-flex align-items-center">
                            <span class="mr-2">User</span>
                            <label class="switch">
                                <input type="checkbox" id="provider-toggle" onclick="toggleRegister()" checked>
                                <span class="slider round"></span>
                            </label>
                            <span class="ml-2"> Care Provider</span>
                        </div>
                        <h2>Register as a Care Provider</h2>
                        <p>Fill in the form below to register as a care provider.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-us-content">
                        <form method="POST" action="{{ route('register.careprovider') }}" id="contact-form">
                            @csrf
                            <div class="row">
                                <!-- Input fields for Care Provider Register Form -->
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Your Name..." required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Your Email..." autocomplete="off" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Your Password..." autocomplete="new-password" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Your Password..." required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="text" id="specialization" name="specialization" class="form-control" placeholder="Your Specialization..." required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea id="bio" name="bio" class="form-control" placeholder="Bio" rows="3"></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="text" id="clinic_address" name="clinic_address" class="form-control" placeholder="Clinic Address">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-check custom-checkbox">
                                        <label class="form-check-label" for="offers_home_services">Offers Home Services</label>
                                        <input type="checkbox" class="form-check-input" id="offers_home_services" name="offers_home_services">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="orange-button">Register</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12 text-center mt-3">
                            <p>You already have an account? <a href="{{ route('login.provider.form') }}">Log in</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleRegister() {
            var checkbox = document.getElementById('provider-toggle');
            if (!checkbox.checked) {
                window.location.href = '{{ route('register.user') }}';
            }
        }
    </script>
@endsection
