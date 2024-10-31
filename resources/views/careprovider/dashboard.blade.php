@extends('layouts.careprovider.master')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Dashboard</h1>

    <!-- عرض الكاردات الأساسية -->
    <div class="row" style="display: flex; flex-wrap: wrap; justify-content: center;">
        <!-- Total Consultations -->
        <div class="col-md-6 col-lg-6 mb-4" style="display: inline-block; width: 37%; margin: 10px;">
            <div class="card-container" style="border: 1px solid #ccc; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center;">
               <br> <div class="icon-container" style="transition: transform 0.3s ease;">
                    <i class="fa-solid fa-question fa-3x" style="color: #8375d0;"></i>
                </div>
                <h5 class="card-title mt-3">Total Consultations</h5>
                <p class="card-text">{{ $totalConsultations }}</p>
                <!-- عرض الـ Current Consultation -->
                <!-- زر Manage -->
                <br>
                <form action="{{ route('careprovider.consultations.index') }}" method="GET">
                    <button type="submit" class="btn btn-primary">Manage Consultations</button>
                </form>
            </div>
        </div>

        <!-- Total Events -->
        <div class="col-md-6 col-lg-6 mb-4" style="display: inline-block; width: 37%; margin: 10px;">
            <div class="card-container" style="border: 1px solid #ccc; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center;">
                <br>   <div class="icon-container" style="transition: transform 0.3s ease;">
                    <i class="fa-solid fa-calendar-days fa-3x" style="color: #8375d0;"></i>
                </div>
                <h5 class="card-title mt-3">Total Events</h5>
                <p class="card-text">{{ $totalEvents }}</p>
                <!-- عرض الـ Current Event -->
                <!-- زر Manage -->
                <br>
                <form action="{{ route('careprovider.events.index') }}" method="GET">
                    <button type="submit" class="btn btn-primary">Manage Events</button>
                </form>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="col-md-6 col-lg-6 mb-4" style="display: inline-block; width: 37%; margin: 10px;">
            <div class="card-container" style="border: 1px solid #ccc; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center;">
                <br>   <div class="icon-container" style="transition: transform 0.3s ease;">
                    <i class="fa-solid fa-calendar-check fa-3x" style="color: #8375d0;"></i>
                </div>
                <h5 class="card-title mt-3">Total Bookings</h5>
                <p class="card-text">{{ $totalBookings }}</p>
                <!-- عرض الـ Current Booking -->
                <br>
                <!-- زر Manage -->
                <form action="{{ route('careprovider.bookings.index') }}" method="GET">
                    <button type="submit" class="btn btn-primary">Manage Bookings</button>
                </form>
            </div>
        </div>

        <!-- Total Advices -->
        <div class="col-md-6 col-lg-6 mb-4" style="display: inline-block; width: 37%; margin: 10px;">
            <div class="card-container" style="border: 1px solid #ccc; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center;">
                <br>   <div class="icon-container" style="transition: transform 0.3s ease;">
                    <i class="fa-solid fa-rectangle-list fa-3x" style="color: #8375d0;"></i>
                </div>
                <h5 class="card-title mt-3">Total Advices</h5>
                <p class="card-text">{{ $totalAdvices }}</p>
                <!-- عرض الـ Current Advice -->
                <br>
                <form action="{{ route('careprovider.advice.create') }}" method="GET">
                    <button type="submit" class="btn btn-primary">Manage Advices</button>
                </form>
            </div>
        </div>
    </div>
</div>
<br><br><br><br>
<!-- جافاسكريبت لتحريك الأيقونة عند تمرير الماوس -->
<script>
    const cardContainers = document.querySelectorAll('.card-container');

    cardContainers.forEach((card) => {
        card.addEventListener('mouseenter', () => {
            card.querySelector('.icon-container').style.transform = 'translateY(-10px)';
        });

        card.addEventListener('mouseleave', () => {
            card.querySelector('.icon-container').style.transform = 'translateY(0)';
        });
    });
</script>

@endsection
