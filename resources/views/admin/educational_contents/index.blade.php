@extends('layouts.admin.master')

@section('title', 'Manage Educational Contents')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('admin.educational-contents.create') }}" class="btn btn-primary mb-3">Create New Content</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contents as $content)
                        <tr>
                            <td>{{ $content->id }}</td>
                            <td>{{ $content->title }}</td>
                            <td>{{ $content->type }}</td>
                            <td>
                                <a href="{{ route('admin.educational-contents.edit', $content->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.educational-contents.destroy', $content->id) }}" method="POST" style="display:inline-block;">
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
