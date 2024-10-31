@extends('layouts.profile.master')

@section('title', 'Your Bookings')

@section('content')
<!-- زر لفتح فورم الحجز -->


<h2>Your Upcoming Bookings</h2>
<div class="d-flex justify-content-end mb-3">
    <button id="createBookingBtn" class="btn btn-primary " type="submit">Create New Booking</button>
</div>

<!-- نموذج الحجز الجديد -->
<!-- نموذج الحجز الجديد -->
<div id="bookingFormContainer" class="form-box" style="display: none; max-width: 700px; padding: 80px; border: 1px solid #ccc; border-radius: 8px; margin: auto; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); text-align: left; position: relative;"> <!-- أضفنا position: relative للنموذج -->
    <!-- زر الإغلاق مع أيقونة Font Awesome -->
    <button id="closeBookingForm" class="btn btn-danger" style="position: absolute; top: 10px; right: 10px; background-color: transparent; border: none;">
        <i class="fa-solid fa-xmark" style="color: #8375d0; font-size: 24px;"></i>
    </button>

    <form id="contact-form" action="{{ route('user.booking.store') }}" method="POST" onsubmit="return confirmBooking()">
        @csrf
        <div class="row mb-3" style="display: flex; flex-direction: column; gap: 20px; width: 100%; max-width: 400px; margin: 0 auto;">
            <div class="form-group mb-3" style="display: flex; flex-direction: column;">
                <label for="care_provider_id" class="form-label">Select Care Provider</label>
                <select name="care_provider_id" class="form-control" style="border-radius: 10px; text-align: left; width: 100%; height: 40px;" required>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}">{{ $provider->user->name }} - {{ $provider->specialization }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3" style="display: flex; flex-direction: column;">
                <label for="booking_date" class="form-label">Booking Date</label>
                <input type="date" name="booking_date" class="form-control" style="border-radius: 10px; text-align: left; width: 95%;" value="{{ old('booking_date') }}" required>
            </div>

            <div class="form-group mb-3" style="display: flex; flex-direction: column;">
                <label for="time_slot" class="form-label">Choose a Time Slot</label>
                <select name="time_slot" class="form-control" style="border-radius: 10px; text-align: left; width: 100%; height: 40px;" required>
                    @foreach($timeSlots as $slot)
                        <option value="{{ $slot }}">{{ $slot }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3" style="display: flex; flex-direction: column;">
                <label for="notes" class="form-label">Notes (optional)</label>
                <textarea name="notes" class="form-control" style="height: 120px; border-radius: 10px; text-align: left; width: 100%; resize: none;" placeholder="Add any notes...">{{ old('notes') }}</textarea>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-lg">Complete Booking</button>
            </div>
        </div>
    </form>
</div>

@if($bookings->count())
    <div class="row">
        @foreach($bookings as $booking)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $booking->careProvider->user->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $booking->careProvider->specialization }}</h6>
                        <p class="card-text">
                            <strong>Date:</strong> {{ $booking->booking_date }}<br>
                            <strong>Time Slot:</strong> {{ $booking->notes }}<br>
                            <strong>Clinic Location:</strong> {{ $booking->careProvider->clinic_address }}<br>
                            <strong>Status:</strong>
                            <span class="badge {{ $booking->status == 'Pending' ? 'badge-warning' : ($booking->status == 'Confirmed' ? 'badge-success' : 'badge-danger') }}">
                                {{ $booking->status }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>No bookings found.</p>
@endif
<br><br><br>
<script>
    document.getElementById('createBookingBtn').addEventListener('click', function() {
        document.getElementById('bookingFormContainer').style.display = 'block';
        document.getElementById('createBookingBtn').style.display = 'none'; // إخفاء الزر
    });

    // إخفاء النموذج وإظهار الزر عند الضغط على زر الإغلاق (X)
    document.getElementById('closeBookingForm').addEventListener('click', function() {
        document.getElementById('bookingFormContainer').style.display = 'none';
        document.getElementById('createBookingBtn').style.display = 'inline-block'; // إظهار الزر مجدداً
    });
// إظهار النموذج عند الضغط على الزر
document.getElementById('createBookingBtn').addEventListener('click', function() {
    document.getElementById('bookingFormContainer').style.display = 'block';
});

// إخفاء النموذج عند الضغط على زر الإغلاق (X)
document.getElementById('closeBookingForm').addEventListener('click', function() {
    document.getElementById('bookingFormContainer').style.display = 'none';
});

// التأكيد قبل إتمام الحجز
function confirmBooking() {
    const careProvider = document.querySelector('select[name="care_provider_id"] option:checked').text;
    const bookingDate = document.querySelector('input[name="booking_date"]').value;
    const timeSlot = document.querySelector('select[name="time_slot"] option:checked').text;

    const confirmation = confirm(
        `Care Provider: ${careProvider}\n` +
        `Date: ${bookingDate}\n` +
        `Time Slot: ${timeSlot}\n\n` +
        "Are you sure you want to complete this booking?"
    );

    return confirmation;
}
</script>

@endsection
