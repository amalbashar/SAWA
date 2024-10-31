<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // جلب جميع المنشورات من قاعدة البيانات
        $posts = Post::all();

        // التحقق من نوع المستخدم أو المكان
        if ($request->is('admin/*')) {
            // إذا كان المستخدم يحاول الوصول إلى لوحة التحكم الخاصة بالإدمن
            return view('admin.posts.index', compact('posts'));
        } else {
            // عرض المنشورات في صفحة الـ Timeline للمستخدم العادي أو مقدم الرعاية
            return view('timeline.timeline', compact('posts'));
        }
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',

        ]);

        Post::create($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'تم إضافة المنشور بنجاح');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($id);
        $post->update($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'تم تحديث المنشور بنجاح');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'تم حذف المنشور بنجاح');
    }
}

