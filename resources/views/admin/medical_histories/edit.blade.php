@extends('layouts.admin.master')

@section('title', 'Edit Medical History')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Medical History</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.medical-histories.update', $medicalHistory->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="patient_id">Patient</label>
                            <select name="patient_id" id="patient_id" class="form-control" required>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ $medicalHistory->patient_id == $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="disease">Disease</label>
                            <input type="text" name="disease" id="disease" class="form-control" value="{{ old('disease', $medicalHistory->disease) }}" required>
                            @error('disease')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="medications">Medications</label>
                            <textarea name="medications" id="medications" class="form-control" rows="3">{{ old('medications', $medicalHistory->medications) }}</textarea>
                            @error('medications')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="surgeries">Surgeries</label>
                            <textarea name="surgeries" id="surgeries" class="form-control" rows="3">{{ old('surgeries', $medicalHistory->surgeries) }}</textarea>
                            @error('surgeries')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="allergies">Allergies</label>
                            <textarea name="allergies" id="allergies" class="form-control" rows="3">{{ old('allergies', $medicalHistory->allergies) }}</textarea>
                            @error('allergies')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.medical-histories.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

