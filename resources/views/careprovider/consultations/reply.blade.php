@extends('layouts.careprovider.master')

@section('title', 'Reply to Consultation')

@section('content')
<div class="form-box">
    <h2>Reply to Consultation</h2>

    <p>{{ $consultation->question }}</p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('careprovider.consultations.storeReply', $consultation->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" name="response" id="response" class="form-control" placeholder="Enter your reply here" required>{{ old('response')}}

        </div>

        <button type="submit" class="btn btn-primary">Submit Reply</button>
    </form>
</div>
@endsection
