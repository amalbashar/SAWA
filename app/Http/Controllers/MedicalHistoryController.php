<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalHistory;

class MedicalHistoryController extends Controller
{
    // عرض جميع السجلات الطبية
    public function index()
    {
        $medicalHistories = MedicalHistory::with('patient')->get(); // استرجاع جميع السجلات مع معلومات المرضى
        return view('admin.medical_histories.index', compact('medicalHistories'));
    }

    // عرض نموذج لإنشاء سجل طبي جديد
    public function create()
    {
        // قد تحتاج إلى استرجاع قائمة المرضى هنا
        return view('admin.medical_histories.create');
    }

    // حفظ سجل طبي جديد
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'disease' => 'required|string|max:255',
            'medications' => 'nullable|string',
            'surgeries' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        MedicalHistory::create($validatedData);

        return redirect()->route('admin.medical-histories.index')->with('success', 'تم إضافة السجل الطبي بنجاح');
    }

    // عرض نموذج تعديل السجل الطبي
    public function edit($id)
    {
        $medicalHistory = MedicalHistory::findOrFail($id);
        return view('admin.medical_histories.edit', compact('medicalHistory'));
    }

    // تحديث سجل طبي موجود
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'disease' => 'required|string|max:255',
            'medications' => 'nullable|string',
            'surgeries' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        $medicalHistory = MedicalHistory::findOrFail($id);
        $medicalHistory->update($validatedData);

        return redirect()->route('admin.medical-histories.index')->with('success', 'تم تحديث السجل الطبي بنجاح');
    }

    // حذف سجل طبي
    public function destroy($id)
    {
        $medicalHistory = MedicalHistory::findOrFail($id);
        $medicalHistory->delete();

        return redirect()->route('admin.medical-histories.index')->with('success', 'تم حذف السجل الطبي بنجاح');
    }
}

 