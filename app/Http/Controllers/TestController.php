<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;


class Testcontroller extends Controller



{
    /**
     * Display a listing of the resource.
     */

    public function show($id)
    {
        // جلب الحدث بناءً على الـ id
        $event = Event::find($id);

        // تمرير الحدث إلى الـ view
        return view('test', compact('event')); // تأكد أن الاسم هنا هو نفس اسم الملف
    }

}
