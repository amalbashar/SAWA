@extends('layouts.admin.master')

@section('title', 'Manage Care Providers')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('admin.care_providers.create') }}" class="btn btn-primary mb-3">Create New Care Provider</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($careProviders as $careProvider)
                        <tr>
                            <td>{{ $careProvider->user->name }}</td>
                            <td>{{ $careProvider->specialization }}</td>
                            <td>{{ $careProvider->location }}</td>
                            <td>
                                <a href="{{ route('admin.care_providers.edit', $careProvider->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.care_providers.destroy', $careProvider->id) }}" method="POST" style="display:inline-block;">
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
