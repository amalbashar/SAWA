<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\User;
use App\Models\CareProviderProfile;



class ConsultationController extends Controller
{
    // عرض جميع الاستشارات
    public function index()
    {
        $consultations = Consultation::with(['patient', 'careProvider'])->get();
        return view('admin.consultations.index', compact('consultations'));
    }

    // عرض نموذج لإنشاء استشارة جديدة
    public function create()
    {
        $patients = User::where('role_id', 2)->get(); // افتراضًا أن role_id = 2 هو للمريض
        $careProviders = CareProviderProfile::with('user')->get(); // استرجاع جميع مقدمي الرعاية مع المستخدمين المرتبطين
        return view('admin.consultations.create', compact('patients', 'careProviders'));
    }


    // حفظ استشارة جديدة
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'care_provider_id' => 'required|exists:care_provider_profiles,id',
            'date' => 'required|date',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
            'notes' => 'nullable|string',
        ]);

        Consultation::create($validatedData);

        return redirect()->route('admin.consultations.index')->with('success', 'تم إضافة الاستشارة بنجاح');
    }

    // عرض نموذج تعديل الاستشارة
    public function edit($id)
    {
        $consultation = Consultation::findOrFail($id);
        return view('admin.consultations.edit', compact('consultation'));
    }

    // تحديث استشارة موجودة
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'care_provider_id' => 'required|exists:care_provider_profiles,id',
            'date' => 'required|date',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
            'notes' => 'nullable|string',
        ]);

        $consultation = Consultation::findOrFail($id);
        $consultation->update($validatedData);

        return redirect()->route('admin.consultations.index')->with('success', 'تم تحديث الاستشارة بنجاح');
    }

    // حذف استشارة
    public function destroy($id)
    {
        $consultation = Consultation::findOrFail($id);
        $consultation->delete();

        return redirect()->route('admin.consultations.index')->with('success', 'تم حذف الاستشارة بنجاح');
    }
}
