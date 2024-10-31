<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'careprovider')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

    <style>
        .container {
            overflow: visible;
        }

        /* القائمة المنسدلة */
        .dropdown-content {
            display: none;
            position: fixed;
            right: 20px;
            top: 60px;
            background-color: #f1f0fe;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            border-radius: 5px;
        }

        .dropdown-content form button {
            color: black;
            padding: 10px 16px;
            text-decoration: none;
            display: block;
            background: none;
            border: none;
            text-align: left;
            width: 100%;
            cursor: pointer;
            font: inherit;
        }

        .dropdown-content form button:hover {
            background-color: #ddd;
        }

        .dropdown-content.show {
            display: block;
        }

        .notification-icon {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .notification-dot {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 8px;
            height: 8px;
            background-color: red;
            border-radius: 50%;
        }


.profile-info {
    text-align: center;
    margin-bottom: 20px;
}

.profile-image {
    width: 100px;
    height: 100px;
    border-radius: 50%; /* لجعل الصورة دائرية */
    object-fit: cover;
    margin-bottom: 10px;
}

.profile-info h4 {
    color: #ffffff;
    font-size: 18px;
    margin: 0;
}


    </style>
</head>
<body>
    <!-- إضافة الشعار -->
    <div class="logo-container">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="logo">
    </div>

    <!-- الروابط العلوية -->
    <div class="top-nav">
        <div class="nav-links">
            <a  href="{{ route('user.profile') }}"><i class="fa-solid fa-user-doctor" style="color: #fffafa;"></i></a>
            <a href="#" onclick="toggleDropdown(event)" class="{{ request()->routeIs('notifications') ? 'active' : '' }}">
                <i class="fa-regular fa-bell" style="color: #fafcff; position: relative;">
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="notification-dot"></span>
                    @endif
                </i>
            </a>
            <a href="#"><i class="fa-regular fa-comments" style="color: #ffffff;"></i></a>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               <i class="fa-solid fa-arrow-right-from-bracket" style="color: #ffffff;"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- القائمة الجانبية -->
    <div class="sidebar">
        <ul>
            {{-- @if (Request::is('profile'))
            <li class="profile-info">
                <img src="{{ auth()->user()->profile_image ?? asset('images/' . $user->profile_picture) }}" alt="Profile Image" class="profile-image">
                <h4>{{ auth()->user()->name }}</h4>
            </li>
        @endif --}}
            <li>
                <a href="{{ route('timeline') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-bars-staggered" style="color: #fcfcfc; margin-right:2vh"></i> Timeline
                </a>
            </li>
            <li>
                <a href="{{ route('user.bookings') }}" class="{{ request()->routeIs('careprovider.bookings.index') ? 'active' : '' }}">
                    <i class="fa-regular fa-calendar-check" style="color: #ffffff;margin-right:2vh"></i> Bookings
                </a>
            </li>
            <li>
                <a href="{{ route('careprovider.events.index') }}" class="{{ request()->routeIs('careprovider.events.index') ? 'active' : '' }}">
                    <i class="fa-regular fa-calendar-days" style="color: #ffffff;margin-right:2vh"></i> Events
                </a>
            </li>
            <li>
                <a href="{{ route('careprovider.consultations.index') }}" class="{{ request()->routeIs('careprovider.consultations.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-question" style="color: #ffffff;margin-right:2vh"></i> Consultations
                </a>
            </li>
            <li>
                <a href="{{ route('careprovider.advice.create') }}" class="{{ request()->routeIs('careprovider.advice.create') ? 'active' : '' }}">
                    <i class="fa-regular fa-rectangle-list" style="color: #ffffff;margin-right:2vh"></i> Advices
                </a>
            </li>
            <li>
                <a href="{{ route('careprovider.advice.create') }}" class="{{ request()->routeIs('careprovider.advice.create') ? 'active' : '' }}">
                    <i class="fa-regular fa-rectangle-list" style="color: #ffffff;margin-right:2vh"></i> edit
                </a>
            </li>
        </ul>
    </div>

    <div class="gray-box">
        <main>
            <!-- هنا سيتم إدراج محتوى الصفحة -->
            @yield('content')
        </main>
    </div>

    <!-- القائمة المنسدلة للإشعارات خارج الحاويات -->
    <div class="dropdown-content" id="dropdownMenu">
        @if(auth()->user()->notifications->count() > 0)
            @foreach(auth()->user()->unreadNotifications as $notification)
                <form action="{{ route('notifications.markAsReadById', $notification->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="redirect_to" value="{{ route('user.bookings') }}">
                    <button type="submit">
                        {{ $notification->data['message'] ?? 'لا يوجد رسالة' }}
                        <br>
                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                    </button>
                </form>
            @endforeach
        @else
            <p>لا توجد إشعارات جديدة</p>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle dropdown menu
            function toggleDropdown(event) {
                event.preventDefault();
                const dropdownMenu = document.getElementById('dropdownMenu');
                dropdownMenu.classList.toggle('show');
            }

            // Check if notification icon exists and add event listener
            const notificationIcon = document.querySelector('.fa-bell');
            if (notificationIcon) {
                notificationIcon.addEventListener('click', toggleDropdown);
            }

            // Close the dropdown if clicked outside
            document.addEventListener('click', function(event) {
                const dropdownMenu = document.getElementById('dropdownMenu');
                if (dropdownMenu.classList.contains('show') && !event.target.closest('a')) {
                    dropdownMenu.classList.remove('show');
                }
            });
        });
    </script>

</body>
</html>
