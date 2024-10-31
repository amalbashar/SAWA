@extends('layouts.admin.master')

@section('title', 'Manage Consultations')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Consultation ID</th>
                        <th>Patient</th>
                        <th>Care Provider</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consultations as $consultation)
                        <tr>
                            <td>{{ $consultation->id }}</td>
                            <td>{{ $consultation->patient->name }}</td>
                            <td>{{ $consultation->careProvider->user->name }}</td>
                            <td>{{ $consultation->date->format('d/m/Y H:i') }}</td>
                            <td>{{ $consultation->status }}</td>
                            <td>
                                <a href="{{ route('admin.consultations.edit', $consultation->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.consultations.destroy', $consultation->id) }}" method="POST" style="display:inline-block;">
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
