@extends('layouts.admin.master')

@section('title', 'Edit Appointment')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="appointment_date">Appointment Date</label>
                    <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="{{ $appointment->appointment_date }}" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" name="status" id="status" class="form-control" value="{{ $appointment->status }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Appointment</button>
            </form>
        </div>
    </div>
@endsection
