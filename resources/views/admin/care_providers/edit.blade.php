@extends('layouts.admin.master')

@section('title', 'Edit Care Provider')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Care Provider</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.care_providers.update', $careProvider->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $careProvider->user->name) }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $careProvider->user->email) }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password (Leave blank to keep current password)</label>
                            <input type="password" name="password" id="password" class="form-control">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="specialization">Specialization</label>
                            <input type="text" name="specialization" id="specialization" class="form-control" value="{{ old('specialization', $careProvider->specialization) }}" required>
                            @error('specialization')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea name="bio" id="bio" class="form-control" rows="4">{{ old('bio', $careProvider->bio) }}</textarea>
                            @error('bio')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="offers_home_services">Offers Home Services</label>
                            <select name="offers_home_services" id="offers_home_services" class="form-control" required>
                                <option value="1" {{ $careProvider->offers_home_services == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $careProvider->offers_home_services == 0 ? 'selected' : '' }}>No</option>
                            </select>
                            @error('offers_home_services')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="clinic_address">Clinic Address</label>
                            <input type="text" name="clinic_address" id="clinic_address" class="form-control" value="{{ old('clinic_address', $careProvider->clinic_address) }}" required>
                            @error('clinic_address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.care_providers.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
