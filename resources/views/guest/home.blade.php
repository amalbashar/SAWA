@extends('layouts.guest.master') <!-- Linking the page to master.blade.php -->

@section('title', 'Home Page') <!-- Setting the page title -->

@section('content')
<style>
    .icon-white {
        color: #ffffff;
    }
      .btn-primary {
                    transition: transform 0.3s ease-in-out;
                }

                .btn-primary:hover {
                    transform: scale(1.1); /* يكبر الزر بنسبة 10% */
                }
                .owl-carousel .item {
  height: 650px; /* ضبط ارتفاع ثابت للسلايد */
  overflow: hidden; /* إخفاء النص الزائد عن الحجم */
}

.header-text p {
  max-height: 100px; /* تحديد أقصى ارتفاع للنص */
  overflow-y: auto; /* السماح بالتمرير الرأسي للنص */
}
.owl-carousel .item {
  position: relative;
}

.header-text {
  position: absolute;
  bottom: 20px; /* تعديل المسافة من الأسفل حسب الحاجة */
  left: 50%;
  transform: translateX(-50%); /* لمحاذاة النص في الوسط */
  text-align: start; /* محاذاة الأزرار في الوسط */

  width: 100%; /* جعل النص والأزرار يملأ العرض الكامل */
  margin-left: 50px;

}

.header-text .buttons {
  display: flex;
  justify-content: start; /* محاذاة الأزرار في المنتصف */
  gap: 15px; /* إضافة مسافة بين الأزرار */
  margin-left: 25px;
}

/* لتحريك السهم لليسار */




</style>


<div class="main-banner" id="top">
    <br><br> <br><br>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-banner">
            <!-- العنصر الأول ثابت -->
            <div class="item item-1">
                <span class="category">Abou Us</span> <h2>With Scholar Teachers, Everything Is Easier</h2>
                <p>Scholar is free CSS template designed by TemplateMo for online educational related websites. This layout is based on the famous Bootstrap v5.3.0 framework.</p>


              <div class="header-text">
                <div class="buttons">
                  <div class="main-button">
                    <a href="#">Request Demo</a>
                  </div>
                  <div class="icon-button">
                    <a href="#"><i class="fa fa-play"></i> What's Scholar?</a>
                  </div>
                </div>
              </div>
            </div>

            @foreach ($articles as $key => $article)

                @if($loop->index >= 0) <!-- التأكد أن الفور ايتش تبدأ من المقالة الثانية -->
                <div class="item item-{{ $loop->iteration + 1 }}">
                    <span class="category"> Recent Articles</span>

                    <h2>{{ $article->title }}</h2>
                    <p>{{ $article->type }}</p>

                  <div class="header-text">


                    <div class="buttons">
                      <div class="main-button">
                        <a href="#">Request Demo</a>
                      </div>
                      <div class="icon-button">
                        <a href="#"><i class="fa fa-play"></i> More Info</a>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
</div>





<div class="services section" id="services">
    <div class="container">
        <div class="row">
            <!-- Community Section -->
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="icon">
                        <i class="fas fa-users fa-3x icon-white"></i>
                    </div>
                    <div class="main-content">
                        <h4>Community</h4>
                        <p>Building a strong community for support and interaction.</p>
                        <div class="main-button">
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Care Providers Section -->
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="icon">
                        <i class="fas fa-user-md fa-3x icon-white"></i>
                    </div>
                    <div class="main-content">
                        <h4>Care Providers</h4>
                        <p>Connecting with certified care providers for better health services.</p>
                        <div class="main-button">
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Awareness Section -->
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="icon">
                        <i class="fas fa-lightbulb fa-3x icon-white"></i>
                    </div>
                    <div class="main-content">
                        <h4>Awareness</h4>
                        <p>Spreading knowledge and raising awareness about important topics.</p>
                        <div class="main-button">
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Courses Section remains unchanged -->
<section class="section courses" id="courses">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-heading">
                    <h6>Care Providers</h6>
                    <h2>BOOK NOW</h2>
                </div>
            </div>
        </div>

{{-- <button type="submit" class="btn btn-primary" style="background-color: #7a6ad8; border-color: #7a6ad8; display: block; margin: 0 auto; padding: 12px 15px; font-size: 18px;">
    Book Now
</button> --}}
<br>


        <div class="row event_box">
            @foreach ($careProviders as $provider)
                <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer {{ $provider->specialization }}">
                    <div class="events_item">
                        <div class="thumb">
                            <a href="#">
                                <img src="{{ asset('images/course-04.jpg') }}" alt="{{ $provider->specialization }}"
                                style=" border-bottom-right-radius: 30px;">
                            </a>
                                                        <span  class="category">{{ $provider->specialization }}</span>
                            <form action="{{ route('user.booking.create') }}" method="GET">
                                <input type="hidden" name="care_provider_id" value="{{ $provider->id }}">
                                <button type="submit" class="btn btn-primary" style="background-color: #7a6ad8; border-color: #7a6ad8;">Book Now</button>
                            </form>
                            <span class="price"><h6 style="font-size: 20px;"><em>$</em>{{ $provider->price }}</h6>
                            </span>
                        </div>
                        <div class="down-content">
                            <span class="author"> {{ $provider->user->name }}</span>
                            <h4>{{ $provider->clinic_address }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<br>
<div style="text-align: right;">
    <a href="{{ route('careProviders.filter', ['category' => 'all']) }}">
        <button type="button" class="btn btn-primary" style="background-color: #f5f3ff; border: none; border-radius: 50px; padding: 10px 30px; font-size: 16px; color: #333; margin-right: 120px;">
            Show All <i class="fa-solid fa-chevron-right" style="color: #7a6ad8;"></i>
        </button>
    </a>
</div>


<style>

    .owl-testimonials .item {
        position: relative;
        background-color: #6f42c1; /* لون الخلفية النهدي */
        height: 400px; /* ارتفاع ثابت للصندوق */
        padding: 30px 50px;
        overflow: hidden; /* إخفاء النص الزائد عن الحجم المحدد */
        border-radius: 10px; /* جعل الزوايا مستديرة */
    }

    .owl-testimonials .item p {
        max-height: 200px; /* تحديد أقصى ارتفاع للنص */
        overflow-y: auto; /* السماح بالتمرير الرأسي للنص */
        color: #fff; /* لون النص */
        font-size: 16px; /* حجم الخط */
    }

    .author {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        margin-left: 25px;
    }

    .owl-testimonials .author {
        position: absolute;
        bottom: 20px; /* تثبيت البيانات في الأسفل */
        left: 20px;
    }

    .owl-testimonials .author img {
        width: 80px; /* حجم الصورة */
        height: 80px;
        border-radius: 50%; /* جعل الصورة دائرية */
        margin-right: 8px;
    }

    .author-info h4 {
        font-size: 20px; /* تكبير حجم الخط للاسم */
        margin: 0;
        font-weight: bold;
        color: #fff; /* تعديل اللون حسب الخلفية */
    }

    .author-info .category {
        font-size: 14px; /* حجم أصغر للتخصص */
        /* لون أفتح للتخصص */
        margin-top: 0px; /* تقليل المسافة بين h4 و category */
    }

    .owl-testimonials .main-button {
        position: absolute;
        bottom: 20px;
        right: 20px;
    }

    </style>

<!-- Fun Facts Section remains unchanged -->
<div class="section fun-facts">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="counter">
                                <h2 class="timer count-title count-number" data-to="150" data-speed="1000"></h2>
                                <p class="count-text">Happy Students</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="counter">
                                <h2 class="timer count-title count-number" data-to="804" data-speed="1000"></h2>
                                <p class="count-text">Course Hours</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="counter">
                                <h2 class="timer count-title count-number" data-to="50" data-speed="1000"></h2>
                                <p class="count-text">Employed Students</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="counter end">
                                <h2 class="timer count-title count-number" data-to="15" data-speed="1000"></h2>
                                <p class="count-text">Years Experience</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Care Providers Section (Team Section) modified for Consultation Popup -->





<!-- Consultation Form (Popup) -->
<div id="consultationForm" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.5); z-index: 1000;">
    <div class="modal-header">
        <h5 class="modal-title">Consultation</h5>
        <button type="button" class="btn-close" onclick="closeConsultationForm()">&times;</button>
    </div>
    <form action="{{ route('consultation.store') }}" method="POST">
        @csrf
        <input type="hidden" name="provider_id" id="provider_id" value="">
        <div class="form-group">
            <label for="consultation_content">Consultation Content</label>
            <textarea name="consultation_content" id="consultation_content" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Send Consultation</button>
        <button type="button" class="btn btn-secondary" onclick="closeConsultationForm()">Cancel</button>
    </form>
</div>

<!-- Medical History Form (Popup) -->
<div id="medicalHistoryForm" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.5); z-index: 1000;">
    <div class="modal-header">
        <h5 class="modal-title">Medical History</h5>
        <button type="button" class="btn-close" onclick="closeMedicalHistoryForm()">&times;</button>
    </div>
    <form action="{{ route('medicalHistory.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="illnesses">Illnesses</label>
            <textarea name="illnesses" id="illnesses" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="medications">Medications</label>
            <textarea name="medications" id="medications" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="allergies">Allergies</label>
            <textarea name="allergies" id="allergies" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Submit Medical History</button>
    </form>
</div>

<!-- Scripts for showing/hiding forms -->
<script>
    function openConsultationForm(providerId) {
        @if(auth()->check())
            // التحقق إذا كان السجل الطبي مكتمل
            if (!{{ Auth::user()->medicalHistory ? 'true' : 'false' }}) {
                document.getElementById('medicalHistoryForm').style.display = 'block';
            } else {
                document.getElementById('provider_id').value = providerId;
                document.getElementById('consultationForm').style.display = 'block';
            }
        @else
            document.getElementById('loginForm').style.display = 'block';
        @endif
    }

    function closeConsultationForm() {
        document.getElementById('consultationForm').style.display = 'none';
    }

    function closeMedicalHistoryForm() {
        document.getElementById('medicalHistoryForm').style.display = 'none';
    }
</script>

<!-- Login Form -->
<div id="loginForm" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.5); z-index: 1000;">
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
</div>

<!-- Script for Handling Consultation and Login Forms -->
<script>
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
</script>

<div class="section testimonials">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="owl-carousel owl-testimonials">
                    @foreach($advice as $singleAdvice)
                    @if(!empty($singleAdvice->careProviderProfile->user->name))
                    <div class="item">
                        <p>“{{ $singleAdvice->content }}”</p>
                        <div class="author d-flex align-items-center">
                            <img src="{{ asset($singleAdvice->careProviderProfile->profile_image) }}" alt="Profile Image" class="profile-image">
                            <div class="author-info">
                                <h4>{{ $singleAdvice->careProviderProfile->user->name ?? 'Unknown' }}</h4>
                                <span style=" margin-top: 0px; font-size:14px;  color: #ccc;" class="category">{{ $singleAdvice->careProviderProfile->specialization }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="col-lg-5 align-self-center">
                <div class="section-heading">
                    <h6>Advices</h6>
                    <h2>What our care providers deeply wish you knew?</h2>
                    <p>لو عندك اشي حاب تستشيرنا فيو سجل دخولك وابعث لنا سؤالك من هون </p>
                    <div class="main-button">
                        <a href="#" class="btn btn-secondary" style="border: none;" onclick="openConsultationForm({{ $provider->id }})">Consult</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Events Section -->
<div class="section events" id="events">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-heading">
                    <h6>Schedule</h6>
                    <h2>Upcoming Events</h2>
                    {{-- <a href="{{ route('events.all', ['all' => true]) }}" class="btn btn-primary mt-3">View All Events</a> --}}


                </div>
            </div>

            @foreach ($events->filter(function($event) {
                return $event->date > now();
            }) as $event)
            <div class="col-lg-12 col-md-6">
                <div class="item">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="image">
                                <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" style="width: 100%; height: 250px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <ul>
                                <li>
                                    <span class="category">{{ $event->careProvider->specialization ?? 'No Specialization' }}</span>
                                    <h4>{{ $event->title }}</h4>
                                </li>
                                <li>
                                    <span>Date:</span>
                                    <h6>{{ $event->date->format('d M Y') }}</h6>
                                </li>
                                <li>
                                    <span>Location:</span>
                                    <h6>{{ $event->location }}</h6>
                                </li>
                                <li>
                                    <span>Capacity:</span>
                                    <h6>{{ $event->capacity }} Seats</h6>
                                </li>
                            </ul>
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

    </div>

</div>


<div style="text-align: right;">
    <button type="button" class="btn btn-primary" style="background-color: #f5f3ff; border: none; border-radius: 50px; padding: 10px 30px; font-size: 16px; color: #333; margin-right: 120px; margin-top: -70px;" onclick="window.location.href='{{ route('events.all', ['all' => true]) }}'">
        Show All <i class="fa-solid fa-chevron-right" style="color: #7a6ad8;"></i>
    </button>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<button onclick="document.getElementById('logout-form').submit();">
    قول بالون</button>

@endsection
