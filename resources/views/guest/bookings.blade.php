@extends('layouts.guest.master')

@section('title', 'book')

@section('content')

<!-- إخفاء الفلتر العلوي -->
<ul class="event_filter" style="display: none;">
    <li>
        <a class="is_active" href="{{ route('careProviders.filter', ['category' => 'all']) }}">Show All</a>
    </li>
    <li>
        <a href="{{ route('careProviders.filter', ['category' => 'medical']) }}">Medical Care</a>
    </li>
    <li>
        <a href="{{ route('careProviders.filter', ['category' => 'rehabilitation']) }}">Rehabilitation Care</a>
    </li>
    <li>
        <a href="{{ route('careProviders.filter', ['category' => 'psychological']) }}">Psychological & Educational Support</a>
    </li>
</ul>

<!-- قسم BOOK NOW -->
<section class="section courses" id="courses" style="margin-top: 100px;"> <!-- تعديل الـ margin-top -->
    <div class="container">
        <!-- إضافة فلاتر التصنيف باللغة الإنجليزية -->
        <ul class="event_filter">
            <li>
                <a class="{{ request('category') == 'all' ? 'is_active' : '' }}" href="{{ route('careProviders.filter', ['category' => 'all']) }}">Show All</a>
            </li>
            <li>
                <a class="{{ request('category') == 'medical' ? 'is_active' : '' }}" href="{{ route('careProviders.filter', ['category' => 'medical']) }}">Medical Care</a>
            </li>
            <li>
                <a class="{{ request('category') == 'rehabilitation' ? 'is_active' : '' }}" href="{{ route('careProviders.filter', ['category' => 'rehabilitation']) }}">Rehabilitation Care</a>
            </li>
            <li>
                <a class="{{ request('category') == 'psychological' ? 'is_active' : '' }}" href="{{ route('careProviders.filter', ['category' => 'psychological']) }}">Psychological Support</a>
            </li>
        </ul>

        <!-- إضافة ستايل مخصص للفئة النشطة -->
        <style>
            .event_filter a {
                color: #000; /* لون النص الأساسي */
                text-decoration: none; /* إزالة التسطير */
                padding: 10px 20px; /* مسافة داخلية */
                display: inline-block;
            }

            .event_filter a.is_active {
                background-color: #7a6ad8; /* لون الخلفية للفئة النشطة */
                color: #fff; /* لون النص للفئة النشطة */
                border-radius: 50px; /* جعل الزوايا مستديرة */
            }

            .event_filter a:hover {
                background-color: #f1f1f1; /* لون الخلفية عند التمرير */
                color: #000; /* لون النص عند التمرير */
                border-radius: 50px; /* جعل الزوايا مستديرة */

            }
        </style>

        <!-- عرض الكروت حسب التصنيف -->
        <div class="row event_box">
            @foreach ($careProviders as $provider)
                <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer {{ $provider->specialization }}">
                    <div class="events_item">
                        <div class="thumb">
                            <a href="#">
                                <img src="{{ asset('images/course-04.jpg') }}" alt="{{ $provider->specialization }}"
                                style="border-bottom-right-radius: 30px;">
                            </a>
                            <span class="category">{{ $provider->specialization }}</span>
                            <form action="{{ route('user.booking.create') }}" method="GET">
                                <input type="hidden" name="care_provider_id" value="{{ $provider->id }}">
                                <button type="submit" class="btn btn-primary" style="background-color: #7a6ad8; border-color: #7a6ad8;">Book Now</button>
                            </form>
                            <span class="price">
                                <h6 style="font-size: 20px;"><em>$</em>{{ $provider->price }}</h6>
                            </span>
                        </div>
                        <div class="down-content">
                            <span class="author">{{ $provider->user->name }}</span>
                            <h4>{{ $provider->clinic_address }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
