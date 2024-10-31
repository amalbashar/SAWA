<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Advice;
use Illuminate\Http\Request;


use App\Models\EducationalContent;


use App\Models\CareProviderProfile;

use Carbon\Carbon;

class GuestController extends Controller
{
    // ميثود للصفحة الرئيسية لعرض أول 3 أحداث فقط
    public function index()
    {
        // جلب الأحداث المرتبطة بمقدمي الرعاية والتي موعدها أكبر من الوقت الحالي
        $events = Event::with('careProvider')
            ->where('date', '>', now())
                        ->whereRaw('interested_users_count < (capacity * hide_percentage / 100)') // شرط النسبة المئوية

            ->orderBy('date', 'asc')
            ->take(3)
            ->get()
            ->map(function ($event) {
                $event->date = Carbon::parse($event->date);
                return $event;
            });

        // جلب مقدمي الرعاية مع معلومات المستخدم المرتبطة (مستخدمين لديهم role_id = 3)
        $careProviders = CareProviderProfile::whereHas('user', function ($query) {
            $query->where('role_id', '3');
        })
        ->with('user')
        ->inRandomOrder()
        ->take(6)
        ->get();

        // جلب جميع التخصصات الفريدة من مقدمي الرعاية
        $specializations = CareProviderProfile::select('specialization')->distinct()->get();

        // جلب النصائح مع معلومات مقدم الرعاية فقط
        $advice = Advice::with('careProviderProfile')->get();

        $articles = EducationalContent::all();
        // تمرير جميع البيانات إلى الصفحة
        return view('guest.home', compact('events', 'careProviders', 'specializations', 'advice' , 'articles'));
    }



    // ميثود جديدة لعرض جميع الأحداث
    public function indexAll()
    {
        $events = Event::with('careProvider')
        ->where('date', '>', now()) // شرط التاريخ
        ->whereRaw('interested_users_count < (capacity * hide_percentage / 100)') // شرط النسبة المئوية
        ->orderBy('date', 'asc') // ترتيب الأحداث حسب التاريخ
        ->get()
        ->map(function ($event) {
            $event->date = Carbon::parse($event->date);
            return $event;
        });

        return view('guest.events', compact('events'));
    }



    public function index1()
    {
        $careProviders = CareProviderProfile::with('user')->paginate(12); // جلب جميع مقدمي الرعاية مع المستخدم المرتبط بهم
        return view('guest.care_providers', compact('careProviders'));
    }
    public function filterCareProvidersByCategory(Request $request)
    {
        // افتراض فئة 'all' إذا لم يتم إرسال فئة في الطلب
        $category = $request->input('category', 'all');

        // جلب مقدمي الرعاية بناءً على الفلتر الخاص بالتصنيف
        $careProviders = CareProviderProfile::whereHas('user', function ($query) {
                $query->where('role_id', '3');  // فلترة حسب دور مقدمي الرعاية
            })
            ->when($category !== 'all', function ($query) use ($category) {
                // الفلترة حسب التصنيف
                if ($category === 'medical') {
                    return $query->whereIn('specialization', [
                        'Pediatrician', 'Cardiologist', 'Neurologist', 'ENT Specialist', 'Ophthalmologist', 'Endocrinologist'
                    ]);
                } elseif ($category === 'rehabilitation') {
                    return $query->whereIn('specialization', [
                        'Physical Therapist', 'Dietitian', 'Occupational Therapist', 'Speech and Language Therapist'
                    ]);
                } elseif ($category === 'psychological') {
                    return $query->whereIn('specialization', [
                        'Psychologist', 'Psychiatrist', 'Special Education Specialist'
                    ]);
                }
            })
            ->with('user')
            ->paginate(12);  // استخدام الـ pagination لعرض النتائج

        // عرض البيانات في الـ Blade المطلوب
        return view('guest.bookings', compact('careProviders'));
    }



public function search(Request $request)
{
    $specialization = $request->input('specialization');

    $careProviders = CareProviderProfile::where('specialization', 'LIKE', "%{$specialization}%")->get();

    return view('care_providers.results', compact('careProviders'));
}
}
