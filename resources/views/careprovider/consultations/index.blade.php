@extends('layouts.careprovider.master')

@section('content')
    <h1 class="text-center mb-4">Recent Consultations</h1>

    @if($consultations->isEmpty())
        <p class="text-center">No consultations are available at the moment.</p>
    @else
        <div class="container" style="display: flex; flex-wrap: wrap; justify-content: flex-start;">
            @foreach($consultations as $consultation)
                <div style="border: 1px solid #ccc; border-radius: 8px; padding: 20px; margin: 10px; width: 320px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <h3 class="card-text">{{ $consultation->notes }}</h3>

                    @if($consultation->patient)
                        <!-- زر عرض التاريخ الطبي -->
                        <button class="btn btn-primary mb-3" type="submit" data-id="{{ $consultation->id }}" onclick="toggleMedicalHistory('medicalHistory{{ $consultation->id }}')" >
                            View Medical History
                        </button>

                        <!-- Medical History details (hidden by default) -->
                        <div id="medicalHistory{{ $consultation->id }}" class="medical-history-details" style="display: none; margin-top: 15px; border: 1px solid #ddd; border-radius: 8px; padding: 15px; position: relative;">
                            <span class="close" style="color: #dc3545; cursor: pointer; float: right; font-size: 24px; font-weight: bold;" onclick="toggleMedicalHistory('medicalHistory{{ $consultation->id }}')">&times;</span>
                            @if($consultation->patient && $consultation->patient->medicalHistory)
                                <h5>Medical History for {{$consultation->patient->name }}</h5>
                                <ul>
                                    <li><strong>Illnesses:</strong> {{ $consultation->patient->medicalHistory->illnesses }}</li>
                                    <li><strong>Medications:</strong> {{ $consultation->patient->medicalHistory->medications }}</li>
                                    <li><strong>Allergies:</strong> {{ $consultation->patient->medicalHistory->allergies }}</li>
                                    <li><strong>Surgeries:</strong> {{$consultation->patient->medicalHistory->surgeries }}</li>
                                    <li><strong>Notes:</strong> {{ $consultation->patient->medicalHistory->notes }}</li>
                                </ul>
                            @else
                                <p>No medical history available for this patient.</p>
                            @endif
                        </div>

                        <!-- زر الرد -->
                        <button id="reply-button-{{ $consultation->id }}" class="btn btn-secondary mb-3" type="submit" onclick="toggleReplyForm('replyForm{{ $consultation->id }}', 'reply-button-{{ $consultation->id }}')">
                            <i class="fa-solid fa-reply"></i> Reply
                        </button>
                    @else
                        <p>No Patient Assigned</p>
                    @endif

                    <!-- Reply Form (hidden by default) -->
                    <div id="replyForm{{ $consultation->id }}" class="reply-form" style="display: none; margin-top: 15px; border: 1px solid #ddd; border-radius: 8px; padding: 15px; position: relative;">
                        <span class="close" style="color: #dc3545; cursor: pointer; float: right; font-size: 24px; font-weight: bold;" onclick="toggleReplyForm('replyForm{{ $consultation->id }}', 'reply-button-{{ $consultation->id }}')">&times;</span>

                        <form action="{{ route('careprovider.consultations.storeReply', $consultation->id) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="response" class="form-label">Reply</label>
                                <textarea name="response" id="response" class="form-control" style="width: 265px; height: 100px; resize: none;" placeholder="Enter your reply here" required>{{ old('response') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success" type="submit">Submit Reply</button>
                            <button type="submit" class="btn btn-secondary" onclick="toggleReplyForm('replyForm{{ $consultation->id }}', 'reply-button-{{ $consultation->id }}')" >Cancel</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <script>
        function toggleMedicalHistory(detailsId) {
            var detailsDiv = document.getElementById(detailsId);
            detailsDiv.style.display = (detailsDiv.style.display === "none" || detailsDiv.style.display === "") ? "block" : "none";

            var viewButton = document.querySelector(`[data-id="${detailsId.replace('medicalHistory', '')}"]`);
            if (viewButton) {
                viewButton.style.display = (detailsDiv.style.display === "block") ? "none" : "inline-block";
            }
        }

        function toggleReplyForm(replyFormId, replyButtonId) {
            var replyFormDiv = document.getElementById(replyFormId);
            var replyButton = document.getElementById(replyButtonId);
            if (replyFormDiv.style.display === "none" || replyFormDiv.style.display === "") {
                replyFormDiv.style.display = "block";
                replyButton.style.display = "none"; // إخفاء زر "Reply"
            } else {
                replyFormDiv.style.display = "none";
                replyButton.style.display = "block"; // إظهار زر "Reply" مرة أخرى
            }
        }
    </script>

    <style>
        .medical-history-details,
        .reply-form {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
            background-color: #f1f0fe; /* لون نهدي فاتح */
            position: relative;
        }

        .form-box {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 10px;
            width: 320px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group textarea {
            width: 400px; /* تعديل عرض textarea */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: none; /* تعطيل تغيير الحجم */
        }

        .close {
            color: #dc3545;
            cursor: pointer;
            font-size: 24px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .btn {
            margin-top: 10px;
        }
    </style>
@endsection
