@extends('layouts.profile.master')

@section('title', $user->name . ' Timeline')

@section('content')

<div class="profile-container" style="background-color: #f4f4f9; padding: 20px; border-radius: 10px;">
    <!-- صورة المستخدم واسم المستخدم -->
    <div class="user-info" style="text-align: center;">
        <img src="{{ asset('images/' . $user->profile_picture) }}" alt="User Profile Image" class="user-profile-img" style="border-radius: 50%; width: 150px; height: 150px;">
        <h2 style="color: #333; margin-top: 20px;">{{ $user->name }}</h2>
    </div>
</div>

<hr style="margin: 40px 0;">

<!-- عرض المنشورات الخاصة بالمستخدم -->
<div class="user-posts" style="background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
    <h3 style="margin-bottom: 20px;">{{ $user->name }}'s Posts</h3>

    @if($posts->count())
        <ul class="posts" style="list-style-type: none; padding: 0;">
            @foreach($posts as $post)
                <li class="post-item mb-4" style="background-color: #f9f9f9; border-radius: 10px; padding: 15px; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">

                    <!-- رأس المنشور -->
                    <div class="post-header d-flex justify-content-between align-items-center">
                        <div>
                            <div class="post-user-info d-flex align-items-center">
                                <img src="{{ asset('images/' . $post->user->profile_picture) }}" alt="User Image" class="user-profile-img-small" style="width: 50px; height: 50px; border-radius: 50%;">
                                <strong style="margin-left: 10px;">
                                    <a href="{{ route('timeline.profile', $post->user->id) }}" style="color: #333;">{{ $post->user->name }}</a>
                                </strong>
                            </div>
                        </div>
                    </div>

                    <small style="color: #666;">{{ $post->created_at->diffForHumans() }}</small>

                    <!-- محتوى المنشور -->
                    <p class="post-content mt-2" style="color: #555;">{{ $post->content }}</p>

                    <!-- صورة المنشور إذا وجدت -->
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mt-2 post-image" alt="Post Image" style="max-width: 100%; border-radius: 10px;">
                    @endif

                    <br><br>

                    <!-- الأزرار (إعجاب وتعليق) -->
                    <div class="post-actions d-flex justify-content-between align-items-center mt-2">
                        <!-- زر الإعجاب -->
                        <form action="{{ route('post.like', $post->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn" style="background: none; border: none;">
                                <i class="fas fa-heart like-icon" style="color: #f44336;"></i>
                            </button>
                        </form>
                        <span style="color: #666;">{{ $post->reactions->count() }} Likes</span>

                        <!-- زر التعليقات -->
                        <button class="btn" style="background: none; border: none;" onclick="toggleComments({{ $post->id }})">
                            <i class="fas fa-comment comment-icon" style="color: #4CAF50;"></i>{{ $post->comments->count() }} Comments
                        </button>
                    </div>

                    <br>

                    <!-- قسم التعليقات -->
                    <div id="comments-section-{{ $post->id }}" style="display: none;" class="comments-section mt-3">
                        <!-- عرض التعليقات -->
                        <div class="comments-container mt-3">
                            @if($post->comments->count())
                                @foreach($post->comments->take(4) as $comment)
                                    <div class="custom-comment-container mb-2" style="border-bottom: 1px solid #eee; padding-bottom: 10px;">
                                        <p style="color: #555;">{{ $comment->content }}</p>
                                        <div class="comment-user-info d-flex align-items-center">
                                            <img src="{{ asset('images/' . $comment->user->profile_picture) }}" alt="User Image" class="user-profile-img-small" style="width: 30px; height: 30px; border-radius: 50%;">
                                            <div class="post-user-info d-flex align-items-center">
                                                <h5 style="margin: 0 5px 0 0; color: #333;">
                                                    <a href="{{ route('timeline.profile', $comment->user->id) }}" style="color: #333;">{{ $comment->user->name }}</a>
                                                </h5>
                                                <small style="color: #777;">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p style="color: #666;">No comments yet.</p>
                            @endif
                        </div>
                    </div>

                </li>
            @endforeach
        </ul>
    @else
        <p style="color: #666;">No posts available for {{ $user->name }}.</p>
    @endif
</div>

@endsection
