<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class TimelineController extends Controller
{
    // عرض جميع المنشورات في الـ Timeline
    public function index(Request $request)
    {
        // جلب جميع المنشورات مع التفاعلات والتعليقات
        $posts = Post::with(['reactions', 'comments'])->orderBy('created_at', 'desc')->get();

        // جلب المستخدم الحالي فقط لغرض العرض
        $user = auth()->user();

        // التحقق من نوع المستخدم أو المكان
        if ($request->is('admin/*')) {
            // إذا كان المستخدم يحاول الوصول إلى لوحة التحكم الخاصة بالإدمن
            return view('admin.posts.index', compact('posts', 'user'));
        } else {
            // عرض جميع المنشورات في صفحة الـ Timeline لجميع المستخدمين
            return view('timeline.timeline', compact('posts', 'user'));
        }
    }


    // إضافة/إزالة التفاعل (reaction)
    public function react(Post $post)
    {
        $userId = auth()->id(); // جلب معرف المستخدم الذي قام بتسجيل الدخول

        // التحقق إذا كان المستخدم قد تفاعل مع المنشور من قبل
        if ($post->reactions()->where('user_id', $userId)->exists()) {
            // إذا كان المستخدم قد تفاعل مع المنشور، قم بإزالة التفاعل
            $post->reactions()->where('user_id', $userId)->delete();
        } else {
            // إذا لم يكن قد تفاعل مع المنشور، قم بإضافة التفاعل
            $post->reactions()->create([
                'user_id' => $userId,
                'post_id' => $post->id,
                'type' => 'like' // تأكد من تمرير قيمة لحقل "type"
            ]);
        }

        return redirect()->back();
    }





    // إضافة التعليقات
    public function comment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        // إضافة التعليق
        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return redirect()->back();
    }
    public function showUserProfile($id)
    {
        // جلب بيانات المستخدم بناءً على الـ ID
        $user = User::findOrFail($id);

        // جلب جميع المنشورات الخاصة بالمستخدم
        $posts = $user->posts()->orderBy('created_at', 'desc')->get();

        // تمرير بيانات المستخدم والمنشورات إلى صفحة البروفايل الخاصة بالمستخدمين الآخرين
        return view('timeline.profile', compact('user', 'posts'));
    }


}
