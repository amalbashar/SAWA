<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Booking;
use App\Models\User;
use App\Models\Consultation;
use App\Models\CareProviderProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalHistory;

use App\Notifications\NewBookingNotification;





class UserController extends Controller
{



    public function showProfile()
{
    // جلب المستخدم الذي قام بتسجيل الدخول
    $user = auth()->user();

    // جلب جميع المنشورات الخاصة بالمستخدم
    $posts = $user->posts()->orderBy('created_at', 'desc')->get();
    $medicalHistory = $user->medicalHistory; // Assuming the relationship is set correctly



    // تمرير المستخدم والمنشورات إلى صفحة الملف الشخصي
    return view('user.profile', compact('user', 'posts', 'medicalHistory' ));
}
    public function createPost()
{
    // عرض صفحة إنشاء المنشور
    return view('user.create_post');
}
public function storePost(Request $request)
{
    // التحقق من صحة البيانات
    $validatedData = $request->validate([
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // الصورة أصبحت اختيارية
    ]);

    // التحقق إذا تم رفع صورة
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('post_images', 'public');
    } else {
        $imagePath = null; // إذا لم يتم رفع صورة
    }

    // إنشاء المنشور وربطه بالمستخدم الذي قام بتسجيل الدخول
    auth()->user()->posts()->create([
        'content' => $validatedData['content'],
        'image' => $imagePath,
    ]);

    return redirect()->route('user.profile')->with('success', 'تم إضافة المنشور بنجاح');
}

public function editPost($id)
{
    // جلب المنشور المطلوب تعديله
    $post = auth()->user()->posts()->findOrFail($id);

    // عرض صفحة التعديل
    return view('user.edit_post', compact('post'));
}
public function updatePost(Request $request, $id)
{
    $validatedData = $request->validate([
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'remove_image' => 'required|string'  // نتأكد من أن الحقل المخفي قد تم إرساله
    ]);

    $post = auth()->user()->posts()->findOrFail($id);

    // تحديث محتوى المنشور
    $post->content = $validatedData['content'];

    // إذا طلب المستخدم حذف الصورة
    if ($validatedData['remove_image'] === 'true') {
        // حذف الصورة من التخزين إذا كانت موجودة
        if ($post->image) {
            \Storage::disk('public')->delete($post->image);
            $post->image = null; // إزالة الصورة من قاعدة البيانات
        }
    }

    // إذا تم رفع صورة جديدة
    if ($request->hasFile('image')) {
        // في حالة وجود صورة قديمة يتم حذفها
        if ($post->image) {
            \Storage::disk('public')->delete($post->image);
        }
        // تخزين الصورة الجديدة
        $imagePath = $request->file('image')->store('post_images', 'public');
        $post->image = $imagePath;
    }

    // حفظ التغييرات
    $post->save();

    return redirect()->route('user.profile')->with('success', 'تم تحديث المنشور بنجاح');
}

public function deletePost($id)
{
    // جلب المنشور المطلوب حذفه
    $post = auth()->user()->posts()->findOrFail($id);

    // حذف المنشور
    $post->delete();

    return redirect()->route('user.profile')->with('success', 'تم حذف المنشور بنجاح');
}


// -----------------هلا هون حنبلش تاعون البوكنق من عند اليوزر BOOKING ---------------------
public function showBookings()
{
    $user = auth()->user();  // جلب المستخدم الحالي
    $bookings = $user->bookings()->get();  // جلب جميع الحجوزات الخاصة بالمستخدم الحالي

    // جلب مقدمي الرعاية من جدول care_provider_profiles
    $providers = CareProviderProfile::with('user')->get();  // جلب مقدمي الرعاية مع بيانات المستخدمين المرتبطين

    // تحديد الفترات الزمنية المتاحة
    $timeSlots = [
        '08:00 - 09:30',
        '09:30 - 11:00',
        '11:00 - 12:30',
        '12:30 - 14:00',
        '14:00 - 15:30',
    ];

    return view('user.bookings', compact('bookings', 'providers', 'timeSlots'));
}


    // معالجة الحجز
    public function createBooking(Request $request)
    {
        // تحقق إذا كان المستخدم مسجل الدخول
        if (!auth()->check()) {
            return redirect()->route('login')->with('message', 'Please login to continue your booking.');
        }

        // جلب مقدم الرعاية بناءً على الـ ID الذي تم تمريره
        $provider = CareProviderProfile::find($request->care_provider_id);

        if (!$provider) {
            return redirect()->back()->with('error', 'Care provider not found.');
        }

        // تحديد الفترات الزمنية المتاحة
        $timeSlots = [
            '08:00 - 09:30',
            '09:30 - 11:00',
            '11:00 - 12:30',
            '12:30 - 14:00',
            '14:00 - 15:30',
        ];

        $bookedSlots = Booking::where('care_provider_id', $request->care_provider_id)
            ->where('booking_date', $request->booking_date)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->pluck('notes') // هذا يمثل الفترات المحجوزة
            ->toArray();

        // إزالة الفترات المحجوزة من القائمة
        $availableSlots = array_diff($timeSlots, $bookedSlots);

        return view('user.bookingform', compact('provider', 'availableSlots', 'bookedSlots', 'request', 'timeSlots'));
    }


    public function storeBooking(Request $request)
    {
        // تحقق من صحة البيانات
        $request->validate([
            'care_provider_id' => 'required|exists:care_provider_profiles,id',  // التحقق من أن care_provider_id موجود في جدول care_provider_profiles
            'booking_date' => 'required|date',
            'time_slot' => 'required|string',
        ]);

        // تحقق مما إذا كانت الفترة الزمنية محجوزة بالفعل
        $existingBooking = Booking::where('care_provider_id', $request->care_provider_id)
            ->where('booking_date', $request->booking_date)
            ->where('notes', $request->time_slot)
            ->first();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'This time slot is already booked.');
        }

        // إنشاء حجز جديد
        $booking = new Booking();
        $booking->user_id = auth()->id();
        $booking->care_provider_id = $request->care_provider_id;  // استخدام care_provider_id مباشرة
        $booking->booking_date = $request->booking_date;
        $booking->notes = $request->time_slot;
        $booking->status = 'Pending';
        $booking->save();

        // جلب معلومات مقدم الرعاية
      // جلب مقدم الرعاية مع بيانات المستخدم المرتبط
$careProvider = CareProviderProfile::with('user')->find($request->care_provider_id);

// التأكد من أن المستخدم موجود
if ($careProvider && $careProvider->user && $careProvider->user->role_id == 3) {
    // هذا للتأكد من أن المستخدم هو مقدم رعاية
    $careProvider->user->notify(new NewBookingNotification($booking));
}


        // عرض رسالة تأكيد تحتوي على تفاصيل الحجز ومعلومات مقدم الرعاية
        return redirect()->back()->with([
            'success' => 'Booking completed successfully!',
            'care_provider_name' => $careProvider->user->name,  // استخدام اسم المستخدم من جدول users
            'specialization' => $careProvider->specialization,
            'booking_date' => $request->booking_date,
            'time_slot' => $request->time_slot,
            'clinic_location' => $careProvider->clinic_address
        ]);
    }


// --------------------------------------استشارات ---------------
public function showConsultationForm()
{
    // التحقق من تسجيل الدخول
    if (!Auth::check()) {
        return response()->json(['error' => 'Please log in to proceed.'], 401);
    }

    // جلب المستخدم الحالي
    $user = Auth::user();

    // التحقق إذا كان السجل الطبي مكتمل
    if (!$user->medicalHistory) {
        // إعادة توجيه المستخدم لملء السجل الطبي
        return view('medical_history_form');
    }

    // إذا كان السجل الطبي موجودًا، يتم عرض نموذج الاستشارة
    return view('consultation_form');
}

    // إرسال الاستشارة
    public function submitConsultation(Request $request)
    {
        // التحقق من تسجيل الدخول
        if (!Auth::check()) {
            return response()->json(['error' => 'Please log in to proceed.'], 401);
        }

        // التحقق من المدخلات
        $request->validate([
            'consultation_content' => 'required|string',
            'provider_id' => 'required|integer',
        ]);

        // التحقق من وجود السجل الطبي
        $medicalHistoryId = Auth::user()->medicalHistory ? Auth::user()->medicalHistory->id : null;

        // إنشاء استشارة جديدة
        Consultation::create([
            'patient_id' => Auth::id(), // تأكد من إضافة `patient_id`
            'medical_history_id' => $medicalHistoryId, // يمكن أن تكون null إذا لم يكن السجل الطبي موجودًا
            'date' => now(),
            'notes' => $request->input('consultation_content'),
            'status' => 'Scheduled',
        ]);

        return redirect()->back()->with('success ,Consultation submitted successfully.');
    }
    public function storeMedicalHistory(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'illnesses' => 'required|string',
            'medications' => 'required|string',
            'allergies' => 'required|string',
            'surgeries' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // إنشاء سجل طبي جديد للمستخدم الحالي
        auth()->user()->medicalHistory()->create([
            'illnesses' => $request->illnesses,
            'medications' => $request->medications,
            'allergies' => $request->allergies,
            'surgeries' => $request->surgeries,
            'notes' => $request->notes,
        ]);

        // إعادة التوجيه إلى صفحة البروفايل مع رسالة نجاح
        return redirect()->route('profile')->with('success', 'تم إضافة السجل الطبي بنجاح.');
    }

// --------------prrofile
public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    // تحقق من صحة البيانات المدخلة
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // تحديث البيانات
    $user->name = $request->name;
    $user->email = $request->email;

    // معالجة الصورة الشخصية في حال تم تحميل صورة جديدة
    if ($request->hasFile('profile_picture')) {
        $imageName = time() . '.' . $request->profile_picture->extension();
        $request->profile_picture->move(public_path('images'), $imageName);
        $user->profile_picture = $imageName;
    }

    $user->save();

    return redirect()->back()->with('success', 'User updated successfully!');
}


public function updateMedicalHistory(Request $request, $id)
{
    // التحقق من صحة البيانات
    $validatedData = $request->validate([
        'illnesses' => 'required|string',
        'medications' => 'required|string',
        'allergies' => 'required|string',
        'surgeries' => 'required|string',
        'notes' => 'nullable|string',
    ]);

    // تحديث البيانات
    $medicalHistory = MedicalHistory::find($id);
    $medicalHistory->update($validatedData);

    return redirect()->back()->with('success', 'تم تحديث السجل الطبي بنجاح');
}

// في الـ Controller
public function showMedicalHistory()
{
    $user = auth()->user();
    $medicalHistory = $user->medicalHistory; // استرداد السجل الطبي للمستخدم

    if ($medicalHistory) {
        // إذا كان يوجد سجل طبي، نعرضه في الصفحة
        return view('profile', compact('user', 'medicalHistory'));
    } else {
        // إذا لم يكن يوجد سجل طبي، نعرض رسالة ونوفر إمكانية إضافة سجل جديد
        return view('profile', compact('user'))->with('message', 'لا يوجد سجل طبي.');
    }
}



}

