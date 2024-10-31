@extends('layouts.profile.master')

@section('title', 'Profile')

@section('content')

<div class="profile-container">
    <!-- صورة المستخدم واسم المستخدم -->
    <div class="user-info">
        <img src="{{ asset('images/' . $user->profile_picture) }}" alt="User Profile Image" class="user-profile-img">
    </div>
    <h2 style="  position: relative;
    top: 60px; left: -300px; color:#fff">{{ $user->name }}</h2>
    <!-- الأزرار -->
    @if(auth()->user()->id == $user->id)
    <div class="buttons">
        <a href="javascript:void(0)" class="btn btn-secondary" onclick="toggleForm()">Edit Profile</a>
        <a href="javascript:void(0)" class="btn btn-info" onclick="toggleMedicalHistoryTable()">Medical History</a>
    </div>
@endif
</div>






<!-- الحاوية التي تحتوي على الجدول أو الرسالة -->
<div id="medicalHistoryContainer" class="container" style="margin-top: 20px; display: none;">
    <!-- عرض الجدول الخاص بالتاريخ الطبي إذا كان هناك بيانات -->
    @if($medicalHistory)
        <div id="medicalHistoryTable" class="table-container">
            <table class="table table-bordered" style="background-color: #f9f9f9;">
                <thead>
                    <tr>
                        <th>Illnesses</th>
                        <th>Medications</th>
                        <th>Allergies</th>
                        <th>Surgeries</th>
                        <th>Notes</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $medicalHistory->illnesses }}</td>
                        <td>{{ $medicalHistory->medications }}</td>
                        <td>{{ $medicalHistory->allergies }}</td>
                        <td>{{ $medicalHistory->surgeries }}</td>
                        <td>{{ $medicalHistory->notes }}</td>
                        <td>
                            <!-- زر تعديل لإظهار الفورم أسفل الجدول -->
                            <button class="btn btn-secondary" onclick="toggleMedicalHistoryForm()">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <!-- عرض الرسالة إذا لم يكن هناك تاريخ طبي -->
        <p id="noMedicalHistoryMessage">No medical history available.</p>
    @endif

    <!-- الفورم الخاص بتعديل التاريخ الطبي (مخفي في البداية) -->
    @if($medicalHistory)
        <div id="medicalHistoryForm" class="post-form-container" style="display: none;">
            <button id="close-medical-history-form" style="position: absolute; top: 10px; right: 10px; background-color: #8375d0; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;" onclick="toggleMedicalHistoryForm()">X</button>

            <form action="{{ route('user.update.medicalHistory', $medicalHistory->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- تعديل الأمراض -->
                <div class="form-content d-flex align-items-start justify-content-between">
                    <div class="input-section" style="flex: 1;">
                        <label for="illnesses">Illnesses</label>
                        <textarea name="illnesses" id="illnesses" class="form-control post-input" required>{{ $medicalHistory->illnesses }}</textarea>
                    </div>
                </div>
                <br>
                <!-- تعديل الأدوية -->
                <div class="form-content d-flex align-items-start justify-content-between mt-3">
                    <div class="input-section" style="flex: 1;">
                        <label for="medications">Medications</label>
                        <textarea name="medications" id="medications" class="form-control post-input" required>{{ $medicalHistory->medications }}</textarea>
                    </div>
                </div>
                <br>
                <!-- تعديل التحسس -->
                <div class="form-content d-flex align-items-start justify-content-between mt-3">
                    <div class="input-section" style="flex: 1;">
                        <label for="allergies">Allergies</label>
                        <textarea name="allergies" id="allergies" class="form-control post-input" required>{{ $medicalHistory->allergies }}</textarea>
                    </div>
                </div>
                <br>
                <!-- تعديل العمليات الجراحية -->
                <div class="form-content d-flex align-items-start justify-content-between mt-3">
                    <div class="input-section" style="flex: 1;">
                        <label for="surgeries">Surgeries</label>
                        <textarea name="surgeries" id="surgeries" class="form-control post-input" required>{{ $medicalHistory->surgeries }}</textarea>
                    </div>
                </div>
                <br>
                <!-- تعديل الملاحظات -->
                <div class="form-content d-flex align-items-start justify-content-between mt-3">
                    <div class="input-section" style="flex: 1;">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" class="form-control post-input">{{ $medicalHistory->notes }}</textarea>
                    </div>
                </div>
                <br>
                <hr>
                <br>
                <!-- زر الحفظ -->
                <div class="form-group d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary add-btn">Save Changes</button>
                </div>
            </form>
        </div>
    @endif
</div>

<script>
    function toggleMedicalHistoryTable() {
        var container = document.getElementById('medicalHistoryContainer');

        // إظهار أو إخفاء الحاوية التي تحتوي على الجدول أو الرسالة
        if (container.style.display === "none" || container.style.display === "") {
            container.style.display = "block"; // عرض الحاوية
        } else {
            container.style.display = "none"; // إخفاء الحاوية
        }
    }

    function toggleMedicalHistoryForm() {
        var form = document.getElementById('medicalHistoryForm');
        var table = document.getElementById('medicalHistoryTable');

        // إخفاء الجدول وإظهار الفورم عند الضغط على "Edit"
        if (form.style.display === "none" || form.style.display === "") {
            form.style.display = "block";  // عرض الفورم
            if (table) {
                table.style.display = "none";  // إخفاء الجدول إذا كان موجودًا
            }
        } else {
            form.style.display = "none";  // إخفاء الفورم
            if (table) {
                table.style.display = "block"; // عرض الجدول إذا كان موجودًا
            }
        }
    }
</script>
















        <!-- الفورم الخاص بتعديل الملف الشخصي (مخفي في البداية) -->
<div id="editProfileForm" class="post-form-container" style="display: none; margin-top: 20px;">
    <button id="close-edit-profile-form" style="position: absolute; top: 10px; right: 10px; background-color:#8375d0; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;" onclick="toggleForm()">X</button>
    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- تعديل الاسم -->
        <div class="form-content d-flex align-items-start justify-content-between">
            <div class="input-section" style="flex: 1;">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control post-input" required>
            </div>
        </div>

        <!-- تعديل البريد الإلكتروني -->
        <div class="form-content d-flex align-items-start justify-content-between mt-3">
            <div class="input-section" style="flex: 1;">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control post-input" required>
            </div>
        </div>

        <!-- تعديل الصورة الشخصية -->
     <!-- تعديل الصورة الشخصية -->
<div class="form-actions d-flex justify-content-around align-items-center mt-3">
    <!-- عرض الصورة الحالية -->
    <div class="current-profile-picture">
        <img id="profile-picture-preview" src="{{ asset('images/' . $user->profile_picture) }}"
             alt="Current Profile Picture" style="border-radius: 50%; width: 100px; height: 100px; object-fit: cover;">
    </div>

    <!-- تغيير الصورة الشخصية -->
    <label for="profile_picture" class="btn btn-light"><i class="fas fa-image"></i> Change Profile Picture</label>
    <input type="file" name="profile_picture" id="profile_picture" class="form-control-file" style="display: none;" onchange="previewProfilePicture(event)">
</div>



        <!-- زر الحفظ -->
        <div class="form-group d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary add-btn">Save Changes</button>
        </div>
    </form>
</div>
<!-- الفورم الخاص بإضافة بوست (مخفي في البداية) -->
<div id="postForm" class="post-form-container">
    <form action="{{ route('user.store.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-content d-flex align-items-start justify-content-between">
            <!-- حقل الإدخال مع صورة المستخدم في الزاوية -->
            <div class="input-section">
                <textarea name="content" id="content" class="form-control post-input" placeholder="what would you like to share?" required></textarea>
            </div>
        </div>

        <!-- أيقونات التحكم بالصور -->
        <div class="form-actions d-flex justify-content-around align-items-center">
            <label for="image" class="btn btn-light"><i class="fas fa-image"></i> photo</label>
            <input type="file" name="image" id="image" class="form-control-file" style="display: none;" accept="image/*" onchange="previewNewImage(event)">
        </div>

        <!-- عرض الصورة المختارة مع زر الإلغاء -->
        <div class="image-preview-container mt-3" style="position: relative;">
            <img id="image-preview-new" src="#" alt="Image Preview" style="display: none; max-width: 100%; height: auto; border-radius: 10px;">
            <button id="remove-image-new" style="display: none; position: absolute; top: 10px; right: 10px; background-color: red; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;" onclick="removeNewImage(event)">X</button>
        </div>

        <!-- زر إضافة البوست -->
        <div class="form-group d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary add-btn">Add Post</button>
        </div>
    </form>

</div>

<hr>




<br><br>
<h2  style="margin-left:40px">Your Posts</h2>
@if($posts->count())
    <ul class="posts" style="width: 63%; list-style-type: none;">
        @foreach($posts as $post)
            <li class="post-item mb-4">

                <div class="post-header d-flex justify-content-between align-items-center">
                    <div>
                        <div class="post-user-info d-flex align-items-center">
                            <img src="{{ asset('images/' . $post->user->profile_picture) }}" alt="User Image" class="user-profile-img-small">
                            <strong style="margin-left: 10px;">{{ $post->user->name }}</strong>
                        </div>
                                            </div>

                    <!-- القائمة المنسدلة بدون بوتون -->
                    <div class="dropdown">
                        <i class="fas fa-ellipsis-h" style="color: #555; cursor: pointer;" onclick="toggleDropdown({{ $post->id }})"></i>
                        <ul class="dropdown-menu-custom" id="dropdown-{{ $post->id }}" style="display: none;">
                            <!-- تعديل المنشور -->
                            <li class="dropdown-item-custom">
                                <button type="button" class="edit-btn" onclick="toggleEditForm({{ $post->id }})">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </button>
                            </li>

                            <hr>

                            <!-- حذف المنشور -->
                            <li class="dropdown-item-custom">
                                <form action="{{ route('user.delete.post', $post->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا المنشور؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>

                            </li>
                        </ul>


                    </div>
                </div>
                <small>{{ $post->created_at->diffForHumans() }}</small>

                <p class="post-content">{{ $post->content }}</p>

                @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mt-2 post-image" alt="Post Image">
                @endif

                <br><br>

                <div class="post-actions d-flex justify-content-between align-items-center mt-2">
                    <!-- زر الإعجاب -->
                    <form action="{{ route('post.like', $post->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn" style="background: none; border: none;">
                            <i class="fas fa-heart like-icon"></i>
                        </button>
                    </form>
                    <span>{{ $post->reactions->count() }} Likes</span>

                    <!-- زر التعليقات -->
                    <button class="btn" style="background: none; border: none;" onclick="toggleComments({{ $post->id }})">
                        <i class="fas fa-comment comment-icon"></i>{{ $post->comments->count() }} Comments
                    </button>
                </div>

                <br> <!-- إضافة خط فاصل -->

                <!-- فورم تعديل المنشور -->
                <div id="edit-post-form-{{ $post->id }}" style="display: none;" class="edit-post-form mt-3">
                    <form action="{{ route('user.update.post', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-content d-flex align-items-start justify-content-between">
                            <!-- حقل الإدخال مع صورة المستخدم في الزاوية -->
                            <div class="input-section">
                                <textarea name="content" class="form-control post-input">{{ $post->content }}</textarea>
                            </div>
                        </div>

                        <!-- أيقونات التحكم بالصور -->
                        <div class="form-actions d-flex justify-content-around align-items-center mt-2">
                            <label for="image-{{ $post->id }}" class="btn btn-light"><i class="fas fa-image"></i> Change Photo</label>
                            <input type="file" name="image" id="image-{{ $post->id }}" class="form-control-file" style="display: none;" accept="image/*" onchange="previewImage(event, {{ $post->id }})">
                        </div>

                        <!-- المدخل المخفي لإزالة الصورة -->
                        <input type="hidden" name="remove_image" id="remove-image-input-{{ $post->id }}" value="false">

                        <!-- عرض الصورة المختارة مع زر الإلغاء -->
                        <div class="image-preview-container mt-3" style="position: relative;">
                            <img id="image-preview-{{ $post->id }}" src="{{ asset('storage/' . $post->image) }}" alt="Image Preview" style="display: {{ $post->image ? 'block' : 'none' }}; max-width: 100%; height: auto; border-radius: 10px;">
                            <button id="remove-image-{{ $post->id }}" style="display: {{ $post->image ? 'block' : 'none' }}; position: absolute; top: 10px; right: 10px; background-color: red; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;" onclick="removeImage(event, {{ $post->id }})">X</button>
                        </div>

                        <br> <!-- إضافة خط فاصل -->
                        <br>

                        <div class="form-group d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary add-btn">Update Post</button>
                            <!-- زر إلغاء -->
                            <button type="button" class="btn btn-secondary ml-2" onclick="toggleEditForm({{ $post->id }})">Cancel</button>
                        </div>
                    </form>
                </div>

                <br> <!-- إضافة خط فاصل بعد كل بوست -->

                <!-- قسم التعليقات وفورم إضافة التعليق -->
                <div id="comments-section-{{ $post->id }}" style="display: none;" class="comments-section mt-3">
                    <!-- عرض التعليقات -->
                    <div class="comments-container mt-3">
                        @if($post->comments->count())
                            @foreach($post->comments->take(4) as $comment)
                                <div class="custom-comment-container mb-2">
                                    <p>{{ $comment->content }}</p>
                                    <div class="post-user-info d-flex align-items-center">
                                        <img src="{{ asset('images/' . $post->user->profile_picture) }}" alt="User Image" class="user-profile-img-small">
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
    function toggleMedicalHistoryForm() {
    var form = document.getElementById('medicalHistoryForm');
    if (form.style.display === "none" || form.style.display === "") {
        form.style.display = "block"; // عرض الفورم
    } else {
        form.style.display = "none"; // إخفاء الفورم
    }
}

      function previewProfilePicture(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profile-picture-preview');
            output.src = reader.result;  // تغيير مصدر الصورة إلى الصورة الجديدة
        };
        reader.readAsDataURL(event.target.files[0]);  // قراءة الملف المختار وعرضه
    }
    function toggleForm() {
    var form = document.getElementById('editProfileForm');
    if (form.style.display === "none" || form.style.display === "") {
        form.style.display = "block"; // عرض الفورم
    } else {
        form.style.display = "none"; // إخفاء الفورم
    }
}

     function togglePostForm() {
        var postForm = document.getElementById('postForm');
        postForm.style.display = postForm.style.display === 'none' ? 'block' : 'none';
    }
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
    // Function لعرض وإخفاء قسم التعليقات وفورم إضافة تعليق
    function toggleComments(postId) {
        var commentsSection = document.getElementById('comments-section-' + postId);
        if (commentsSection.style.display === 'none' || commentsSection.style.display === '') {
            commentsSection.style.display = 'block';
        } else {
            commentsSection.style.display = 'none';
        }
    }

    // Function لعرض وإخفاء فورم تعديل المنشور
    function toggleEditForm(postId) {
        var editForm = document.getElementById('edit-post-form-' + postId);
        if (editForm.style.display === 'none' || editForm.style.display === '') {
            editForm.style.display = 'block';
        } else {
            editForm.style.display = 'none';
        }
    }

    // Function لعرض وإخفاء القائمة المنسدلة (dropdown)
    function toggleDropdown(postId) {
        var dropdownMenu = document.getElementById('dropdown-' + postId);
        if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
            dropdownMenu.style.display = 'block';
        } else {
            dropdownMenu.style.display = 'none';
        }
    }

    // معاينة الصورة الجديدة (لإضافة منشور جديد)
    function previewNewImage(event) {
        var imagePreview = document.getElementById('image-preview-new');
        var removeButton = document.getElementById('remove-image-new');
        var file = event.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // عرض الصورة
                removeButton.style.display = 'block'; // عرض زر الإزالة
            };
            reader.readAsDataURL(file);
        }
    }

    // إزالة الصورة المختارة (لإضافة منشور جديد)
    function removeNewImage(event) {
        event.preventDefault(); // منع إرسال النموذج عند الضغط على زر "X"
        var imageInput = document.getElementById('image');
        var imagePreview = document.getElementById('image-preview-new');
        var removeButton = document.getElementById('remove-image-new');

        imageInput.value = "";
        imagePreview.style.display = 'none';
        removeButton.style.display = 'none';
    }

    // معاينة الصورة لتعديل المنشور
    function previewImage(event, postId) {
        var imagePreview = document.getElementById('image-preview-' + postId);
        var removeButton = document.getElementById('remove-image-' + postId);
        var file = event.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // عرض الصورة
                removeButton.style.display = 'block'; // عرض زر الإزالة
            };
            reader.readAsDataURL(file);
        }
    }

    // إزالة الصورة المختارة لتعديل المنشور
    function removeImage(event, postId) {
        event.preventDefault(); // منع إرسال النموذج
        var imageInput = document.getElementById('image-' + postId);
        var imagePreview = document.getElementById('image-preview-' + postId);
        var removeButton = document.getElementById('remove-image-' + postId);
        var removeImageInput = document.getElementById('remove-image-input-' + postId);

        imageInput.value = "";
        imagePreview.style.display = 'none';
        removeButton.style.display = 'none';
        removeImageInput.value = "true";  // تحديد أنه يجب حذف الصورة
    }
</script>



@endsection
