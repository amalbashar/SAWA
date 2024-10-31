@extends('layouts.profile.master')

@section('title', 'Timeline')

@section('content')
<div class="post-form-container">
    <!-- فورم إضافة المنشور -->
    <div id="postForm">
        <form action="{{ route('user.store.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-content d-flex align-items-start justify-content-between">
                <!-- حقل الإدخال مع صورة المستخدم في الزاوية -->
                <div class="input-section">
                    <textarea name="content" id="content" class="form-control post-input" placeholder="what would you like to share?" required></textarea>
                </div>
            </div>

            <!-- أيقونات التحكم بالصور -->
            <div class="form-actions d-flex justify-content-around align-items-center mt-3">
                <label for="image" class="btn btn-light"><i class="fas fa-image"></i> photo</label>
                <input type="file" name="image" id="image" class="form-control-file" style="display: none;" accept="image/*" onchange="previewNewImage(event)">
            </div>

            <!-- عرض الصورة المختارة مع زر الإلغاء -->
            <div class="image-preview-container mt-3" style="position: relative;">
                <img id="image-preview-new" src="#" alt="Image Preview" style="display: none; max-width: 100%; height: auto; border-radius: 10px;">
                <button id="remove-image-new" style="display: none; position: absolute; top: 10px; right: 10px; background-color: red; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;" onclick="removeNewImage(event)">X</button>
            </div>

            <!-- زر إضافة المنشور -->
            <div class="form-group d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary add-btn">Add Post</button>
            </div>
        </form>
    </div>
</div>
<hr>
<!-- عرض المنشورات -->
<h2  style="margin-left:40px">Your Timeline</h2>
@if($posts->count())
    <ul class="posts" style="width: 63%; list-style-type: none;">
        @foreach($posts as $post)
            <li class="post-item mb-4" style="background-color: #fff; border-radius: 10px; padding: 15px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">

                <!-- رأس المنشور -->
                <div class="post-header d-flex justify-content-between align-items-center">
                    <div>
                        <div class="post-user-info d-flex align-items-center">
                            <img src="{{ asset('images/' . $post->user->profile_picture) }}" alt="User Image" class="user-profile-img-small">
                            <strong style="margin-left: 10px;">
                                @if(Auth::id() == $post->user->id)
                                    <a href="{{ route('user.profile') }}">{{ $post->user->name }}</a>
                                @else
                                    <a href="{{ route('timeline.profile', $post->user->id) }}">{{ $post->user->name }}</a>
                                @endif
                            </strong>

                        </div>

                    </div>

                </div>
                                       <small>{{ $post->created_at->diffForHumans() }}</small>

                <!-- محتوى المنشور -->
                <p class="post-content mt-2">{{ $post->content }}</p>

                <!-- صورة المنشور إذا وجدت -->
                @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mt-2 post-image" alt="Post Image">
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
                    <span>{{ $post->reactions->count() }} Likes</span>

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
                                <div class="custom-comment-container mb-2">
                                    <p>{{ $comment->content }}</p>
                                    <div class="comment-user-info d-flex align-items-center">
                                        <img src="{{ asset('images/' . $comment->user->profile_picture) }}" alt="User Image" class="user-profile-img-small">
                                        <div class="post-user-info d-flex align-items-center">
                                            <h5 style="margin: 0 5px 0 0;">{{ $post->user->name }}</h5>
                                            <small>{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>


                                    </div>
                                                                    </div>
                            @endforeach

                            <div id="extra-comments-{{ $post->id }}" style="display: none;">
                                @foreach($post->comments->slice(4) as $comment)
                                    <div class="custom-comment-container mb-2">
                                        <p>{{ $comment->content }}</p>
                                        <div class="comment-user-info d-flex align-items-center">
                                            <img src="{{ asset('images/' . $comment->user->profile_picture) }}" alt="User Image" class="user-profile-img-small">
                                            <div class="post-user-info d-flex align-items-center">
                                                <h5 style="margin: 0 5px 0 0;">{{ $post->user->name }}</h5>
                                                <small>{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>


                                        </div>
                                                                            </div>
                                @endforeach
                            </div>

                            @if($post->comments->count() > 4)
                                <button class="btn btn-secondary btn-sm mt-2" onclick="showMoreComments({{ $post->id }})" id="show-more-{{ $post->id }}">
                                    Show more comments
                                </button>
                            @endif
                        @else
                            <p>No comments yet.</p>
                        @endif
                    </div>

                    <!-- فورم إضافة تعليق -->
                    <div class="add-comment mt-2" style="border: 1px solid #ddd; padding: 15px; border-radius: 10px; background-color: #f9f9f9;">
                        <form action="{{ route('post.comment', $post->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-content d-flex align-items-start justify-content-between">
                                <div class="input-section" style="flex: 1;">
                                    <textarea name="content" class="form-control comment-input" placeholder="Add your comment" required></textarea>
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-primary add-btn" style="padding: 10px 20px; margin-top: 20px; margin-right:10px">
                                    Add Comment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>



            </li>
        @endforeach
    </ul>
@else
    <p>No posts available.</p>
@endif

<br><br><br>

<script>
          function showMoreComments(postId) {
                        var extraComments = document.getElementById('extra-comments-' + postId);
                        var showMoreButton = document.getElementById('show-more-' + postId);

                        if (extraComments.style.display === "none" || extraComments.style.display === "") {
                            // إذا كانت التعليقات الإضافية مخفية، اعرضها
                            extraComments.style.display = "block";
                            showMoreButton.innerText = "Show less comments";
                        } else {
                            // إذا كانت التعليقات الإضافية معروضة، اخفها
                            extraComments.style.display = "none";
                            showMoreButton.innerText = "Show more comments";
                        }
                    }
    function toggleComments(postId) {
        var commentsSection = document.getElementById('comments-section-' + postId);
        commentsSection.style.display = commentsSection.style.display === 'none' || commentsSection.style.display === '' ? 'block' : 'none';
    }

    function previewNewImage(event) {
        var imagePreview = document.getElementById('image-preview-new');
        var removeButton = document.getElementById('remove-image-new');
        var file = event.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                removeButton.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    function removeNewImage(event) {
        event.preventDefault();
        var imageInput = document.getElementById('image');
        var imagePreview = document.getElementById('image-preview-new');
        var removeButton = document.getElementById('remove-image-new');

        imageInput.value = "";
        imagePreview.style.display = 'none';
        removeButton.style.display = 'none';
    }
</script>


@endsection
