<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CareProviderProfile;
use App\Models\Consultation;
use App\Models\Event;
use App\Models\Booking;
use App\Models\Advice;

class CareProviderController extends Controller
{
    public function index()
    {
        $careProviders = CareProviderProfile::with('user')->get();
        return view('admin.care_providers.index', compact('careProviders'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('careProviderProfile')->get();
        return view('admin.care_providers.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'specialization' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'offers_home_services' => 'required|boolean',
            'clinic_address' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role_id' => 3,
        ]);

        CareProviderProfile::create([
            'user_id' => $user->id,
            'specialization' => $validatedData['specialization'],
            'bio' => $validatedData['bio'],
            'offers_home_services' => $validatedData['offers_home_services'],
            'clinic_address' => $validatedData['clinic_address'],
        ]);

        return redirect()->route('admin.care_providers.index')->with('success', 'Done    ');
    }

    public function edit($id)
    {
        $careProvider = CareProviderProfile::with('user')->findOrFail($id);
        return view('admin.care_providers.edit', compact('careProvider'));
    }

    public function update(Request $request, $id)
    {
        $careProvider = CareProviderProfile::with('user')->findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $careProvider->user_id,
            'password' => 'nullable|string|min:6|confirmed',
            'specialization' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'offers_home_services' => 'required|boolean',
            'clinic_address' => 'required|string|max:255',
        ]);

        $user = $careProvider->user;
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->save();

        $careProvider->update([
            'specialization' => $validatedData['specialization'],
            'bio' => $validatedData['bio'],
            'offers_home_services' => $validatedData['offers_home_services'],
            'clinic_address' => $validatedData['clinic_address'],
        ]);

        return redirect()->route('admin.care_providers.index')->with('success', 'Done '   );
    }

    public function destroy($id)
    {
        $careProvider = CareProviderProfile::findOrFail($id);
        $careProvider->user->delete();
        $careProvider->delete();

        return redirect()->route('admin.care-providers.index')->with('success', 'Done');
    }


    // ------------------هونا ببدا تاعون الكير بروفايدر
    public function showConsultations()
    {
        $consultations = Consultation::where('status', 'Scheduled')->get();

        return view('careprovider.consultations.index', compact('consultations'));
    }

    public function replyConsultation($id)
    {
        $consultation = Consultation::findOrFail($id);

        return view('careprovider.consultations.reply', compact('consultation'));
    }

    public function storeReply(Request $request, $id)
    {
        $request->validate([
            'response' => 'required',
        ]);

        $consultation = Consultation::findOrFail($id);

        $consultation->update([
            'response' => $request->input('response'),
            'responded_by' => auth()->user()->id,
            'status' => 'Completed',
        ]);

        return redirect()->route('careprovider.consultations.index')->with('success', 'Reply sent successfully.');
    }
// --------------------EVENTS
public function showEvents()
{
    $events = Event::where('care_provider_id', auth()->user()->id)->get();

    return view('careprovider.events.index', compact('events'));
}

public function createEvent()
{
    return view('careprovider.events.create');
}

public function storeEvent(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'date' => 'required|date',
        'location' => 'required|string',
        'capacity' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // التأكد من رفع صورة صالحة
        'short_description' => 'required|string',
        'hide_percentage' => 'required|integer|min:100', // التأكد من إدخال نسبة صحيحة
    ]);

    // رفع الصورة وتخزينها
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('event_images', 'public');
    }

    // إنشاء الحدث
    Event::create([
        'care_provider_id' => auth()->user()->id,
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'date' => $request->input('date'),
        'location' => $request->input('location'),
        'capacity' => $request->input('capacity'),
        'image' => $imagePath, // حفظ مسار الصورة
        'short_description' => $request->input('short_description'),
        'hide_percentage' => $request->input('hide_percentage'), // حفظ النسبة المئوية
        'interested_users_count' => 0, // يبدأ عدد المهتمين من 0
    ]);

    return redirect()->route('careprovider.events.index')->with('success', 'تم إضافة الفعالية بنجاح.');
}

public function editEvent($id)
{
    $event = Event::findOrFail($id);
    return view('careprovider.events.edit', compact('event'));
}

public function updateEvent(Request $request, $id)
{
    $event = Event::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'date' => 'required|date',
        'location' => 'required|string',
        'capacity' => 'required|integer',
        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // تأكد من الصورة فقط إذا تم رفعها
        'short_description' => 'required|string',
        'hide_percentage' => 'required|integer|min:100',
    ]);

    // إذا تم رفع صورة جديدة
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('event_images', 'public');
        $event->update(['image' => $imagePath]); // تحديث الصورة
    }

    // تحديث بقية تفاصيل الحدث
    $event->update([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'date' => $request->input('date'),
        'location' => $request->input('location'),
        'capacity' => $request->input('capacity'),
        'short_description' => $request->input('short_description'),
        'hide_percentage' => $request->input('hide_percentage'), // تحديث النسبة المئوية
    ]);

    return redirect()->route('careprovider.events.index')->with('success', 'تم تحديث الفعالية بنجاح.');
}

public function destroyEvent($id)
{
    $event = Event::findOrFail($id);
    $event->delete();

    return redirect()->route('careprovider.events.index')->with('success', 'تم حذف الفعالية بنجاح.');
}


// --------------------bookings

public function showUpcomingBookings()
{
    $bookings = Booking::where('care_provider_id', auth()->user()->id)
                ->where('booking_date', '>=', now())
                ->get();

    $pendingBookings = $bookings->where('status', 'Pending'); // أو الحالة المستخدمة
    $confirmedBookings = $bookings->where('status', 'Confirmed'); // أو الحالة المستخدمة

    return view('careprovider.booking.index', compact('pendingBookings', 'confirmedBookings'));
}


public function accept($id)
{
    // العثور على الحجز باستخدام ID
    $booking = Booking::find($id);

    if ($booking) {
        // تحديث حالة الحجز إلى "مؤكد"
        $booking->status = 'Confirmed';
        $booking->save();

        // جلب المستخدم الذي قام بالحجز
        $user = $booking->user;

        // التحقق من وجود المستخدم
        if ($user) {
            // إرسال إشعار للمستخدم بأن الحجز تم قبوله
            $user->notify(new \App\Notifications\BookingApprovedNotification($booking));
        }

        return redirect()->back()->with('success', 'Booking accepted successfully.');
    }

    return redirect()->back()->with('error', 'Booking not found.');
}


// ----------------------advices
public function storeAdvice(Request $request)
{
    $request->validate([
        'advice' => 'required|string',
    ]);

    // إنشاء النصيحة وربطها بمقدم الرعاية
    Advice::create([
        'care_provider_profile_id' => auth()->user()->id,
        'content' => $request->input('advice'),
    ]);

    return redirect()->route('careprovider.advice.create')->with('success', 'تم إضافة النصيحة بنجاح.');
}

public function createAdvice()
{
    // جلب النصائح الخاصة بمقدم الرعاية
    $adviceList = Advice::where('care_provider_profile_id', auth()->user()->id)->get();

    // تمرير النصائح إلى العرض
    return view('careprovider.advice.create', compact('adviceList'));
}

public function updateAdvice(Request $request, $id)
{
    // التحقق من صحة البيانات المدخلة
    $request->validate([
        'advice' => 'required|string',
    ]);

    // جلب النصيحة المطلوبة
    $advice = Advice::findOrFail($id);

    // التحقق من أن مقدم الرعاية هو صاحب النصيحة
    if ($advice->care_provider_profile_id != auth()->user()->id) {
        return redirect()->back()->with('error', 'لا يمكنك تعديل هذه النصيحة.');
    }

    // تحديث النصيحة
    $advice->update([
        'content' => $request->input('advice'),
    ]);

    return redirect()->route('careprovider.advice.create')->with('success', 'تم تعديل النصيحة بنجاح.');
}

public function deleteAdvice($id)
{
    // جلب النصيحة المطلوبة
    $advice = Advice::findOrFail($id);

    // التحقق من أن مقدم الرعاية هو صاحب النصيحة
    if ($advice->care_provider_profile_id != auth()->user()->id) {
        return redirect()->back()->with('error', 'لا يمكنك حذف هذه النصيحة.');
    }

    // حذف النصيحة
    $advice->delete();

    return redirect()->route('careprovider.advice.create')->with('success', 'تم حذف النصيحة بنجاح.');
}

public function showProfile($id)
{
    $careProvider = CareProviderProfile::with('user')->findOrFail($id);

    // جلب صورة البروفايل من جدول users وصورة العيادة من care_provider_profiles
    $profileImage = $careProvider->user->profile_image; // صورة البروفايل من جدول users
    $clinicImage = $careProvider->profile_image; // صورة العيادة من care_provider_profiles

    return view('careprovider.profile', compact('careProvider', 'profileImage', 'clinicImage'));
}


// Function to edit Care Provider profile
public function editProfile($id)
{
    $careProvider = CareProviderProfile::with('user')->findOrFail($id);
    return view('careprovider.edit-profile', compact('careProvider'));
}

// Function to update Care Provider profile
public function updateProfile(Request $request, $id)
{
    $careProvider = CareProviderProfile::with('user')->findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $careProvider->user_id,
        'specialization' => 'required|string|max:255',
        'bio' => 'nullable|string',
        'offers_home_services' => 'required|boolean',
        'clinic_address' => 'required|string|max:255',
        'profile_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Update the user details
    $user = $careProvider->user;
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->save();

    // Handle profile image upload if provided
    if ($request->hasFile('profile_image')) {
        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        $careProvider->profile_image = $imagePath;
    }

    // Update care provider profile details
    $careProvider->update([
        'specialization' => $validatedData['specialization'],
        'bio' => $validatedData['bio'],
        'offers_home_services' => $validatedData['offers_home_services'],
        'clinic_address' => $validatedData['clinic_address'],
    ]);

    return redirect()->route('careprovider.profile', $careProvider->id)->with('success', 'Profile updated successfully');
}
public function dashboard()
{
    $totalConsultations = Consultation::where('responded_by', auth()->user()->id)->count();
    $totalEvents = Event::where('care_provider_id', auth()->user()->id)->count();
    $totalBookings = Booking::where('care_provider_id', auth()->user()->id)->count();
    $totalAdvices = Advice::where('care_provider_profile_id', auth()->user()->careProviderProfile->id)->count();

    // Fetch latest records for each section
    $latestConsultation = Consultation::where('responded_by', auth()->user()->id)->latest()->first();
    $latestEvent = Event::where('care_provider_id', auth()->user()->id)->latest()->first();
    $latestBooking = Booking::where('care_provider_id', auth()->user()->id)->latest()->first();

    return view('careprovider.dashboard', compact(
        'totalConsultations',
        'totalEvents',
        'totalBookings',
        'totalAdvices',
        'latestConsultation',
        'latestEvent',
        'latestBooking'
    ));
}


}



