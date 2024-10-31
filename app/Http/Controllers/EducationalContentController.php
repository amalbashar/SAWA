<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EducationalContent;

class EducationalContentController extends Controller
{
    public function index()
    {
        $contents = EducationalContent::all();
        return view('admin.educational_contents.index', compact('contents'));
    }

    public function create()
    {
        return view('admin.educational_contents.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'content' => 'required|string',
        ]);

        EducationalContent::create($validatedData);

        return redirect()->route('admin.educational-contents.index')->with('success', 'تم إضافة المحتوى التعليمي بنجاح');
    }

    public function edit($id)
    {
        $content = EducationalContent::findOrFail($id);
        return view('admin.educational_contents.edit', compact('content'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'content' => 'required|string',
        ]);

        $content = EducationalContent::findOrFail($id);
        $content->update($validatedData);

        return redirect()->route('admin.educational-contents.index')->with('success', 'تم تحديث المحتوى التعليمي بنجاح');
    }

    public function destroy($id)
    {
        $content = EducationalContent::findOrFail($id);
        $content->delete();

        return redirect()->route('admin.educational-contents.index')->with('success', 'تم حذف المحتوى التعليمي بنجاح');
    }
}
