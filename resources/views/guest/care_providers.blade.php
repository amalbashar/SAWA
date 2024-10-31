@extends('layouts.guest.master')

@section('title', 'View All Care Providers')

@section('content')


<br><br><br><br><br>
<style>.team-member {
    border-radius: 10px;
}

.team-member .main-content {
    margin-bottom: 150px;
}

.team-member img {
    border-radius: 50%; /* جعل الصورة دائرية */

}
.team {
    margin-top: 50px; /* تعديل المسافة العلوية */
}

.team-member .main-content {
    margin-bottom: 150px;
}


</style>



    <div class="col-lg-12 text-center">
            <h2>Care Providers</h2>
    </div>
<br> <br>
    <ul class="event_filter">
        <li>
          <a class="is_active" href="#!" data-filter="*">Show All</a>
        </li>
        <li>
          <a href="#!" data-filter=".design">Webdesign</a>
        </li>
        <li>
          <a href="#!" data-filter=".development">Development</a>
        </li>
        <li>
          <a href="#!" data-filter=".wordpress">Wordpress</a>
        </li>
      </ul>


<div class="team section" id="team">
    <div class="container">
        <div class="row">
            @if($careProviders->count())
            @foreach($careProviders as $provider)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="team-member">
                    <div class="main-content">
                        <img src="{{ asset('images/course-04.jpg') }}"  class="img-fluid" style="width: 100%; height: 220px;">
                        <span class="category">{{ $provider->specialization }}</span>
                        <h4>{{ $provider->user->name }}</h4>
                        <p>{{ $provider->bio }}</p>
                        <div class="mt-2">
                            <form action="{{ route('user.booking.create') }}" method="GET">
                                <input type="hidden" name="care_provider_id" value="{{ $provider->id }}">
                                <div class="main-button">
                             <button type="submit" class="orange-button" >BOOK</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
            @else
                <p>No Care Providers found.</p>
            @endif
        </div>
    </div>
</div>

{{-- <button class="btn btn-secondary" onclick="viewProviderDetails({{ $provider->id }})">Details</button> --}}




<!-- Consultation Form -->

{{-- <div id="consultationForm" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.5); z-index: 1000;">
    <div class="modal-header">
        <h5 class="modal-title">Consultation</h5>
        <button type="button" class="btn-close" onclick="closeConsultationForm()">&times;</button>
    </div>
    <form action="" method="POST">
        @csrf
        <input type="hidden" name="provider_id" id="provider_id" value="">
        <div class="form-group">
            <label for="consultation_content">Consultation Content</label>
            <textarea name="consultation_content" id="consultation_content" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Send Consultation</button>
        <button type="button" class="btn btn-secondary" onclick="closeConsultationForm()">Cancel</button>
    </form>
</div> --}}

<!-- Login Form -->

{{-- <div id="loginForm" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.5); z-index: 1000;">
    <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="btn-close" onclick="closeLoginForm()">&times;</button>
    </div>
    <div class="contact-us-content">
        <form id="login-form" action="" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <input type="email" name="email" id="email" placeholder="Your Email..." autocomplete="on" required>
                </div>
                <div class="col-lg-12">
                    <input type="password" name="password" id="password" placeholder="Your Password..." required>
                </div>
                <div class="col-lg-12">
                    <button type="submit" id="form-submit" class="orange-button">Log In</button>
                </div>
            </div>
        </form>

        <div class="col-lg-12 text-center mt-3">
            <p>Don't have an account? <a href="{{ route('register.user') }}">Sign up now</a></p>
        </div>
    </div>
</div> --}}



<!-- Script for Handling Consultation and Login Forms -->


{{-- <script>
    function openConsultationForm(providerId) {
        @if(auth()->check())
            document.getElementById('provider_id').value = providerId;
            document.getElementById('consultationForm').style.display = 'block';
        @else
            document.getElementById('loginForm').style.display = 'block';
        @endif
    }

    function closeConsultationForm() {
        document.getElementById('consultationForm').style.display = 'none';
    }

    function closeLoginForm() {
        document.getElementById('loginForm').style.display = 'none';
    }
</script> --}}

@endsection
