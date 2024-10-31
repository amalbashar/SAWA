<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Event::create($validatedData);

        return redirect()->route('admin.events.index')->with('success', 'تم إضافة الحدث بنجاح');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $event = Event::findOrFail($id);
        $event->update($validatedData);

        return redirect()->route('admin.events.index')->with('success', 'تم تحديث الحدث بنجاح');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'تم حذف الحدث بنجاح');
    }
}
