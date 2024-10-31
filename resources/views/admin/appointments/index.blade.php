@extends('layouts.admin.master')

@section('title', 'Manage Appointments')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary mb-3">Create New Appointment</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Care Provider</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->user->name }}</td>
                            <td>{{ $appointment->care_provider->user->name }}</td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td>{{ $appointment->status }}</td>
                            <td>
                                <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
