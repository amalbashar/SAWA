@extends('layouts.admin.master')

@section('title', 'Manage Medical Histories')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Disease</th>
                        <th>Medications</th>
                        <th>Surgeries</th>
                        <th>Allergies</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicalHistories as $history)
                        <tr>
                            <td>{{ $history->id }}</td>
                            <td>{{ $history->patient->name }}</td>
                            <td>{{ $history->disease }}</td>
                            <td>{{ $history->medications }}</td>
                            <td>{{ $history->surgeries }}</td>
                            <td>{{ $history->allergies }}</td>
                            <td>
                                <a href="{{ route('admin.medical-histories.edit', $history->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.medical-histories.destroy', $history->id) }}" method="POST" style="display:inline-block;">
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
