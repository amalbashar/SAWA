<!-- includes/sidebar.blade.php -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>Dashboard</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">Jhon Doe</h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            <a href="{{ route('admin.users.index') }}" class="nav-item nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="fa fa-users me-2"></i>Users
            </a>

            <a href="{{ route('admin.care_providers.index') }}" class="nav-item nav-link {{ request()->is('admin/care_providers*') ? 'active' : '' }}">
                <i class="fa fa-user-md me-2"></i>Care Providers
            </a>

            <a href="" class="nav-item nav-link {{ request()->is('admin/bookings*') ? 'active' : '' }}">
                <i class="fa fa-calendar-check me-2"></i>Bookings
            </a>

            <a href="{{ route('admin.consultations.index') }}" class="nav-item nav-link {{ request()->is('admin/consultations*') ? 'active' : '' }}">
                <i class="fa fa-stethoscope me-2"></i>Consultations
            </a>

            <a href="{{ route('admin.medical-histories.index') }}" class="nav-item nav-link {{ request()->is('admin/medical-histories*') ? 'active' : '' }}">
                <i class="fa fa-file-medical me-2"></i>Medical Histories
            </a>

            <a href="{{ route('admin.educational-contents.index') }}" class="nav-item nav-link {{ request()->is('admin/educational-contents*') ? 'active' : '' }}">
                <i class="fa fa-book me-2"></i>Educational Contents
            </a>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->is('admin/posts*') || request()->is('admin/comments*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-users me-2"></i>Community
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="" class="dropdown-item {{ request()->is('admin/posts*') ? 'active' : '' }}">
                        <i class="fa fa-edit me-2"></i>Posts
                    </a>
                    <a href="{{ route('admin.comments.index') }}" class="dropdown-item {{ request()->is('admin/comments*') ? 'active' : '' }}">
                        <i class="fa fa-comments me-2"></i>Comments
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.events.index') }}" class="nav-item nav-link {{ request()->is('admin/events*') ? 'active' : '' }}">
                <i class="fa fa-calendar-alt me-2"></i>Events
            </a>
        </div>
    </nav>
</div>

<style>
    .sidebar .nav-link {
        white-space: nowrap; /* يمنع التفاف النص */
        font-size: 14px; /* حجم النص */
        padding: 0.75rem 1rem; /* تعديل المسافات */
    }

    .sidebar .nav-link i {
        margin-right: 8px; /* تقليل المسافة بين الأيقونة والنص */
    }

    .sidebar .nav-link span {
        font-size: 14px; /* تقليل حجم النص لتقليل التفافه */
    }

    .sidebar .dropdown-menu .dropdown-item {
        font-size: 14px; /* ضبط حجم النص في القائمة المنسدلة */
        padding-left: 3rem; /* مسافة إلى اليمين */
    }

    .sidebar .nav-link.active {
        background-color: #f0f0f0; /* تغيير الخلفية للعنصر النشط */
        color: #007bff; /* تغيير لون النص للعنصر النشط */
        font-weight: bold; /* جعل النص عريضًا */
    }

    .sidebar .dropdown-menu .dropdown-item.active {
        background-color: #f0f0f0; /* تغيير الخلفية للعنصر النشط في القائمة المنسدلة */
        color: #007bff; /* تغيير لون النص للعنصر النشط */
        font-weight: bold; /* جعل النص عريضًا */
    }
</style>
