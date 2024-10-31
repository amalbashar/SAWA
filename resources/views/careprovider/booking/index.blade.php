@extends('layouts.careprovider.master')

@section('content')
<h1 class="text-center mb-4">Upcoming Bookings</h1>

<!-- عرض الحجوزات غير المؤكدة -->
<h2>Pending Bookings</h2>
@if($pendingBookings->isEmpty())
    <p class="text-center">No pending bookings.</p>
@else
    <div class="container" style="display: flex; flex-wrap: wrap; justify-content: flex-start;">
        @foreach($pendingBookings as $booking)
            <div style="border: 1px solid #ccc; border-radius: 8px; padding: 20px; margin: 10px; width: 320px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <h5 class="card-title">Booking Date: {{ $booking->booking_date }}</h5>
                <p class="card-text"><strong>User:</strong> {{ $booking->user ? $booking->user->name : 'No User Assigned' }}</p>
                <p class="card-text">Notes: {{ $booking->notes }}</p>
                <p class="card-text">Status: {{ $booking->status }}</p>

                <button class="btn btn-primary mb-3" data-id="{{ $booking->id }}" onclick="toggleMedicalHistory('medicalHistory{{ $booking->id }}')" type="submit">
                    View Medical History
                </button>

                <div id="medicalHistory{{ $booking->id }}" class="medical-history-details" style="display: none; margin-top: 15px; border: 1px solid #ddd; border-radius: 8px; padding: 15px; position: relative;">
                    <span class="close" style="color: #dc3545; cursor: pointer; float: right; font-size: 24px; font-weight: bold;" onclick="toggleMedicalHistory('medicalHistory{{ $booking->id }}')">&times;</span>
                    @if($booking->patient && $booking->patient->medicalHistory)
                        <h5>Medical History for {{ $booking->patient->name }}</h5>
                        <ul>
                            <li><strong>Illnesses:</strong> {{ $booking->patient->medicalHistory->illnesses }}</li>
                            <li><strong>Medications:</strong> {{ $booking->patient->medicalHistory->medications }}</li>
                            <li><strong>Allergies:</strong> {{ $booking->patient->medicalHistory->allergies }}</li>
                            <li><strong>Surgeries:</strong> {{ $booking->patient->medicalHistory->surgeries }}</li>
                            <li><strong>Notes:</strong> {{ $booking->patient->medicalHistory->notes }}</li>
                        </ul>
                    @else
                        <p>No medical history available for this patient.</p>
                    @endif
                </div>
                <form action="{{ route('careprovider.bookings.accept', $booking->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-success mb-3" type="submit">Accept</button>
                </form>
            </div>
        @endforeach
    </div>
@endif

<!-- عرض الحجوزات المؤكدة -->
<h2>Confirmed Bookings</h2>
@if($confirmedBookings->isEmpty())
    <p class="text-center">No confirmed bookings.</p>
@else
    <div class="container" style="display: flex; flex-wrap: wrap; justify-content: flex-start;">
        @foreach($confirmedBookings as $booking)
            <div style="border: 1px solid #ccc; border-radius: 8px; padding: 20px; margin: 10px; width: 320px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <h5 class="card-title">Booking Date: {{ $booking->booking_date }}</h5>
                <p class="card-text"><strong>User:</strong> {{ $booking->user ? $booking->user->name : 'No User Assigned' }}</p>
                <p class="card-text">Notes: {{ $booking->notes }}</p>
                <p class="card-text">Status: {{ $booking->status }}</p>

                <button class="btn btn-primary mb-3" data-id="{{ $booking->id }}" onclick="toggleMedicalHistory('medicalHistory{{ $booking->id }}')" type="submit">
                    View Medical History
                </button>

                <div id="medicalHistory{{ $booking->id }}" class="medical-history-details" style="display: none; margin-top: 15px; border: 1px solid #ddd; border-radius: 8px; padding: 15px; position: relative;">
                    <span class="close" style="color: #dc3545; cursor: pointer; float: right; font-size: 24px; font-weight: bold;" onclick="toggleMedicalHistory('medicalHistory{{ $booking->id }}')">&times;</span>
                    @if($booking->patient && $booking->patient->medicalHistory)
                        <h5>Medical History for {{ $booking->patient->name }}</h5>
                        <ul>
                            <li><strong>Illnesses:</strong> {{ $booking->patient->medicalHistory->illnesses }}</li>
                            <li><strong>Medications:</strong> {{ $booking->patient->medicalHistory->medications }}</li>
                            <li><strong>Allergies:</strong> {{ $booking->patient->medicalHistory->allergies }}</li>
                            <li><strong>Surgeries:</strong> {{ $booking->patient->medicalHistory->surgeries }}</li>
                            <li><strong>Notes:</strong> {{ $booking->patient->medicalHistory->notes }}</li>
                        </ul>
                    @else
                        <p>No medical history available for this patient.</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <br><br><br>
@endif

<script>
    function toggleMedicalHistory(detailsId) {
        var detailsDiv = document.getElementById(detailsId);
        detailsDiv.style.display = (detailsDiv.style.display === "none" || detailsDiv.style.display === "") ? "block" : "none";

        // إخفاء زر "View Medical History" عند إظهار التفاصيل
        var viewButton = document.querySelector(`[data-id="${detailsId.replace('medicalHistory', '')}"]`);
        if (viewButton) {
            viewButton.style.display = (detailsDiv.style.display === "block") ? "none" : "inline-block";
        }
    }
</script>
@endsection
