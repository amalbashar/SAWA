@extends('layouts.guest.master') <!-- ربط الصفحة بـ master.blade.php -->

@section('title', 'Events') <!-- تحديد العنوان -->

@section('content')
<Style>
    .image img {
    width: 100%;
    height: 255px;
    object-fit: cover;
    border-radius: 10px; /* إضافة تقوس للصورة إذا كنت ترغب بذلك */
}


</Style>
<div class="section events" id="events">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-heading">
                    <h2>All Events</h2>
                </div>
            </div>

            <!-- عرض جميع الأحداث -->
            @foreach ($events as $event)
            <div class="col-lg-12 col-md-6">
                <div class="item">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="image">
                                <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" >
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
@endsection
