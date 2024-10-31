<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CareProviderController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\EducationalContentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NotificationController;

// --------------guest---------------

use App\Http\Controllers\GuestController;

Route::get('/', [GuestController::class, 'index']);

Route::get('/events/all', [GuestController::class, 'indexAll'])->name('events.all');
Route::get('/guest/care-providers', [GuestController::class, 'showCareProviders'])->name('guest.home');
Route::get('/home', [GuestController::class, 'getCareProviders']);

Route::post('/', [AuthController::class, 'login']);
Route::get('/care-providers', [GuestController::class, 'index1'])->name('all.care.providers');

Route::get('/care-providers/filter', [GuestController::class, 'filterCareProvidersByCategory'])->name('careProviders.filter');





//  التسجيل
Route::get('/choose-registration', function () {
    return view('auth.chreg');
})->name('choose.registration');

Route::get('/register-user', [AuthController::class, 'showUserRegistrationForm'])->name('register.user');
Route::post('/register-user', [AuthController::class, 'registerUser']);

Route::get('/register-careprovider', [AuthController::class, 'showCareProviderRegistrationForm'])->name('register.careprovider');
Route::post('/register-careprovider', [AuthController::class, 'registerCareProvider']);

//  تسجيل الدخول
Route::get('/user/login', function() {
    return view('user.login');
})->name('login.user.form');
Route::post('/login/user', [LoginController::class, 'loginUser'])->name('user.login');

Route::get('/careprovider/login', function() {
    return view('careprovider.login');
})->name('login.provider.form');
Route::post('/login/provider', [LoginController::class, 'loginProvider'])->name('careprovider.login');

Route::get('/admin/login', function() {
    return view('admin.login');
})->name('admin.login.form');
Route::post('/admin/login', [LoginController::class, 'loginAdmin'])->name('admin.login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//  لوحات التحكم
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/careprovider/dashboard', function () {
        return view('careprovider.dashboard');
    })->name('careprovider.dashboard');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    //  الإدمن
    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
        Route::resource('users', AdminController::class)->parameters(['users' => 'id']);
        Route::resource('care_providers', CareProviderController::class)->parameters(['care_providers' => 'id']);
        Route::resource('appointments', AdminController::class)->parameters(['appointments' => 'id']);
        Route::resource('educational-contents', AdminController::class)->parameters(['educational-contents' => 'id']);
    });
});
// في ملف routes/web.php
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('consultations', ConsultationController::class);
    // Route::resource('bookings', BookingController::class);
    Route::resource('medical-histories', MedicalHistoryController::class);
    Route::resource('educational-contents', EducationalContentController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('events', EventController::class);

    //  لوحة التحكم العامة
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});
Route::get('/admin/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');



// --------------------------taranslation--------------
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\TestController;


Route::get('lang/{locale}', [LanguageController::class, 'switchLang']);
Route::get('/test',function(){return view('test');})->name('test');

Route::get('/test/{id}', [TestController::class, 'show']);


//  الخاص بصفحة Timeline مع حماية للمستخدمين المسجلين

use App\Http\Controllers\UserController;
use App\Http\Controllers\TimelineController;

Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline');
// Route::post('/post/{post}/like', [TimelineController::class, 'react'])->name('post.like');
// Route::post('/post/{post}/comment', [TimelineController::class, 'comment'])->name('post.comment');
// Route::get('/profile', [UserController::class, 'showProfile'])->middleware(['auth', 'role:2'])->name('user.profile');
// Route::get('/create-post', [UserController::class, 'createPost'])->middleware(['auth', 'role:2'])->name('user.create.post');
// Route::post('/store-post', [UserController::class, 'storePost'])->name('user.store.post');
// Route::get('/edit-post/{id}', [UserController::class, 'editPost'])->name('user.edit.post');
// Route::put('/update-post/{id}', [UserController::class, 'updatePost'])->name('user.edit.post');
// Route::delete('/delete-post/{id}', [UserController::class, 'deletePost'])->name('user.delete.post');

Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('user.profile');
    Route::get('/create-post', [UserController::class, 'createPost'])->name('user.create.post');
    Route::post('/store-post', [UserController::class, 'storePost'])->name('user.store.post');
    Route::get('/edit-post/{id}', [UserController::class, 'editPost'])->name('user.edit.post');
    Route::put('/update-post/{id}', [UserController::class, 'updatePost'])->name('user.update.post');
    Route::delete('/delete-post/{id}', [UserController::class, 'deletePost'])->name('user.delete.post');
});

// Routes for likes and comments (no role restriction)
Route::post('/post/{post}/like', [TimelineController::class, 'react'])->name('post.like');
Route::post('/post/{post}/comment', [TimelineController::class, 'comment'])->name('post.comment');


// ------------------يوزر بوكنق -----------------------


//  تقديم الاستشارة
Route::post('/consultation', [UserController::class, 'submitConsultation'])->name('user.consultation.submit');

//  إتمام الحجز

Route::get('/booking', [UserController::class, 'createBooking'])->middleware('auth')->name('user.booking.create');
Route::post('/booking/store', [UserController::class, 'storeBooking'])->name('user.booking.store');

// ---------------------------------استشارة

Route::get('/consultation', [UserController::class, 'showConsultationForm'])->name('consultation.form');

// لإرسال الاستشارة
Route::post('/consultation', [UserController::class, 'submitConsultation'])->name('consultation.submit');
Route::post('/consultation/store', [UserController::class, 'submitConsultation'])->name('consultation.store');
Route::post('/medical-history/store', [UserController::class, 'storeMedicalHistory'])->name('medicalHistory.store');

// careprovider------------------


Route::prefix('careprovider')->name('careprovider.')->middleware(['auth', 'role:3'])->group(function () {

    // --------------------------الاستشارات
    Route::get('/consultations', [CareProviderController::class, 'showConsultations'])->name('consultations.index');
    Route::get('/consultations/{id}/reply', [CareProviderController::class, 'replyConsultation'])->name('consultations.reply');
    Route::post('/consultations/{id}/reply', [CareProviderController::class, 'storeReply'])->name('consultations.storeReply');

    // --------------------الأحداث (Events)
    Route::get('/events', [CareProviderController::class, 'showEvents'])->name('events.index');
    Route::get('/events/create', [CareProviderController::class, 'createEvent'])->name('events.create');
    Route::post('/events/store', [CareProviderController::class, 'storeEvent'])->name('events.store');
    Route::get('/events/{id}/edit', [CareProviderController::class, 'editEvent'])->name('events.edit');
    Route::put('/events/{id}/update', [CareProviderController::class, 'updateEvent'])->name('events.update');
    Route::delete('/events/{id}', [CareProviderController::class, 'destroyEvent'])->name('events.destroy');

    // --------------------الحجوزات (Bookings)
    Route::get('/bookings', [CareProviderController::class, 'showUpcomingBookings'])->name('bookings.index');

    // --------------------النصائح (Advice)
    Route::get('/advices/create', [CareProviderController::class, 'createAdvice'])->name('advice.create');
    Route::post('/advices/store', [CareProviderController::class, 'storeAdvice'])->name('advice.store');

    // ------ تم إضافة هذه الأسطر لطرق التعديل والحذف للنصائح ------
    Route::put('/advices/update/{id}', [CareProviderController::class, 'updateAdvice'])->name('advice.update'); // تعديل النصيحة
    Route::delete('/advices/delete/{id}', [CareProviderController::class, 'deleteAdvice'])->name('advice.delete'); // حذف النصيحة

    // --------------------الملف الشخصي (Profile)
    Route::get('/profile/edit', [CareProviderController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [CareProviderController::class, 'updateProfile'])->name('profile.update');

});
// ------------------------يوزربوكنق
Route::get('/user/bookings', [UserController::class, 'showBookings'])->name('user.bookings');
Route::get('/user/bookings/create', [UserController::class, 'createBooking'])->name('user.bookingform');
Route::put('/careprovider/bookings/{id}/accept', [CareProviderController::class, 'accept'])->name('careprovider.bookings.accept');


// ------------كيربروفايدر بروفايل

// Route to show the Care Provider's profile
Route::get('/careprovider/profile/{id}', [CareProviderController::class, 'showProfile'])->name('careprovider.profile');

// Route to show the form for editing the Care Provider's profile
Route::get('/careprovider/profile/{id}/edit', [CareProviderController::class, 'editProfile'])->name('careprovider.profile.edit');

// Route to handle the form submission for updating the Care Provider's profile
Route::post('/careprovider/profile/{id}/update', [CareProviderController::class, 'updateProfile'])->name('careprovider.profile.update');
Route::put('/careprovider/profile/{id}/update', [CareProviderController::class, 'updateProfile'])->name('careprovider.profile.update');
Route::get('/careprovider/dashboard', [CareProviderController::class, 'dashboard'])->name('careprovider.dashboard');
// --------------------
// عرض جميع الإشعارات

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsReadById'])->name('notifications.markAsReadById');
Route::get('/careprovider/notifications', [NotificationController::class, 'index'])->name('careprovider.notifications');

// ---------------------------profileuser

Route::put('/users/{id}', [UserController::class, 'updateUser'])->name('user.update');
Route::put('/user/medical-history/update/{id}', [UserController::class, 'updateMedicalHistory'])->name('user.update.medicalHistory');
Route::get('/user/profile/{id}', [TimelineController::class, 'showUserProfile'])->name('timeline.profile');
