@extends('layouts.admin.master')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Admin Dashboard Overview Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">


            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-users fa-3x text-primary"></i>
                    <div class="ms-3">
                        <h5 class=" col-sm-6 ">Total Users</h5>
                        <h3 class="mb-0">{{ \App\Models\User::count() }}</h3>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-user-md fa-3x text-primary"></i>
                    <div class="ms-3">
                        <h5 class="mb-2">Care Providers</h5>
                        <h3 class="mb-0">{{ \App\Models\CareProviderProfile::count() }}</h3>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-calendar-check fa-3x text-primary"></i>
                    <div class="ms-3">
                        <h5 class="mb-2">Consultations</h5>
                        <h3 class="mb-0">{{ \App\Models\Consultation::count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-star fa-3x text-primary"></i>
                    <div class="ms-3">
                        <h5 class="mb-2">Ratings</h5>
                        <h3 class="mb-0">{{ \App\Models\Consultation::count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Admin Dashboard Overview End -->
@endsection
