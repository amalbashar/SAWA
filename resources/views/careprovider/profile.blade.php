@extends('layouts.careprovider.master')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Care Provider Profile</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-box" style="max-width: 600px; padding: 30px; border: 1px solid #ccc; border-radius: 8px;">
                <!-- عرض المعلومات الشخصية -->
                <div id="profile-view">
                    <h3>Profile Information</h3>
                    <p><strong>Name:</strong> {{ $careProvider->user->name }}</p>
                    <p><strong>Email:</strong> {{ $careProvider->user->email }}</p>
                    <p><strong>Specialization:</strong> {{ $careProvider->specialization }}</p>
                    <p><strong>Bio:</strong> {{ $careProvider->bio }}</p>
                    <p><strong>Offers Home Services:</strong> {{ $careProvider->offers_home_services ? 'Yes' : 'No' }}</p>
                    <p><strong>Clinic Address:</strong> {{ $careProvider->clinic_address }}</p>

                    <!-- عرض صورة البروفايل -->
                    <p><strong>Profile Image:</strong>
                        @if($careProvider->profile_image)
                            <img src="{{ asset('storage/' . $careProvider->profile_image) }}" alt="Profile Image" width="100">
                        @else
                            No Image Available
                        @endif
                    </p>

                    <!-- عرض صورة العيادة -->
                    <p><strong>Clinic Image:</strong>
                        @if($careProvider->clinic_image)
                            <img src="{{ asset('storage/' . $careProvider->clinic_image) }}" alt="Clinic Image" width="200">
                        @else
                            No Clinic Image Available
                        @endif
                    </p>

                    <p><strong>Certificate:</strong>
                        @if($careProvider->certificate)
                            <a href="{{ asset('storage/' . $careProvider->certificate) }}" target="_blank">View Certificate</a>
                        @else
                            No Certificate Available
                        @endif
                    </p>

                    <!-- زر التعديل -->
                    <button class="btn btn-primary" onclick="toggleEditForm()" type="submit">Edit Profile</button>
                </div>

                <!-- نموذج تعديل المعلومات (مخفي افتراضيًا) -->
                <div id="profile-edit" style="display: none;">
                    <form action="{{ route('careprovider.profile.update', $careProvider->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $careProvider->user->name) }}" required>
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $careProvider->user->email) }}" required>
                        </div>

                        <!-- Specialization -->
                        <div class="form-group mb-3">
                            <label for="specialization" class="form-label">Specialization</label>
                            <input type="text" name="specialization" id="specialization" class="form-control" value="{{ old('specialization', $careProvider->specialization) }}" required>
                        </div>

                        <!-- Bio -->
                        <div class="form-group mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea name="bio" id="bio" class="form-control" style="width: 80%; resize: none;" rows="4">{{ old('bio', $careProvider->bio) }}</textarea>
                        </div>

                        <!-- Offers Home Services -->
                        <div class="form-group mb-3">
                            <label for="offers_home_services" class="form-label">Offers Home Services</label>
                            <select name="offers_home_services" id="offers_home_services" class="form-control" required>
                                <option value="1" {{ old('offers_home_services', $careProvider->offers_home_services) == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('offers_home_services', $careProvider->offers_home_services) == 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <!-- Clinic Address -->
                        <div class="form-group mb-3">
                            <label for="clinic_address" class="form-label">Clinic Address</label>
                            <input type="text" name="clinic_address" id="clinic_address" class="form-control" value="{{ old('clinic_address', $careProvider->clinic_address) }}" required>
                        </div>

                        <!-- Profile Image -->
                        <div class="form-group mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" name="profile_image" id="profile_image" class="form-control">
                            @if($careProvider->profile_image)
                                <p>Current Image: <img src="{{ asset('storage/' . $careProvider->profile_image) }}" alt="Profile Image" width="100"></p>
                            @endif
                        </div>

                        <!-- Clinic Image -->
                        <div class="form-group mb-3">
                            <label for="clinic_image" class="form-label">Clinic Image</label>
                            <input type="file" name="clinic_image" id="clinic_image" class="form-control">
                            @if($careProvider->clinic_image)
                                <p>Current Clinic Image: <img src="{{ asset('storage/' . $careProvider->clinic_image) }}" alt="Clinic Image" width="200"></p>
                            @endif
                        </div>

                        <!-- Certificate -->
                        <div class="form-group mb-3">
                            <label for="certificate" class="form-label">Certificate (PDF or Image)</label>
                            <input type="file" name="certificate" id="certificate" class="form-control">
                            @if($careProvider->certificate)
                                <p>Current Certificate: <a href="{{ asset('storage/' . $careProvider->certificate) }}" target="_blank">View Certificate</a></p>
                            @endif
                        </div>

                        <!-- زر التحديث -->
                        <button type="submit" class="btn btn-success">Update Profile</button>
                        <button type="submit" class="btn btn-secondary" onclick="toggleEditForm()">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br>
<!-- جافا سكريبت لإظهار وإخفاء النموذج -->
<script>
    function toggleEditForm() {
        var profileView = document.getElementById('profile-view');
        var profileEdit = document.getElementById('profile-edit');
        if (profileEdit.style.display === 'none') {
            profileEdit.style.display = 'block';
            profileView.style.display = 'none';
        } else {
            profileEdit.style.display = 'none';
            profileView.style.display = 'block';
        }
    }
</script>
@endsection
