@extends('layouts.admin.master')

@section('title', 'Create Appointment')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="{{ route('admin.appointments.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="user_id">User</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="care_provider_id">Care Provider</label>
                    <select name="care_provider_id" id="care_provider_id" class="form-control" required>
                        @foreach(\App\Models\CareProvider::all() as $careProvider)
                            <option value="{{ $careProvider->id }}">{{ $careProvider->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="appointment_date">Appointment Date</label>
                    <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" name="status" id="status" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Appointment</button>
            </form>
        </div>
    </div>
@endsection
