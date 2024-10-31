@extends('layouts.careprovider.master')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Event</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-box" style="max-width: 500px; padding: 80px; border: 1px solid #ccc; border-radius: 8px;">
                    <form action="{{ route('careprovider.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="form"> <!-- تعديل enctype لرفع الصورة -->
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" style="width: 100%;" value="{{ $event->title }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" style="width: 100%; height: 150px;" required>{{ $event->description }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control" style="width: 100%;" value="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" class="form-control" style="width: 100%;" value="{{ $event->location }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="capacity" class="form-label">Capacity</label>
                            <input type="number" name="capacity" id="capacity" class="form-control" style="width: 100%;" value="{{ $event->capacity }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Event Image</label>
                            <input type="file" name="image" id="image" class="form-control" style="width: 100%;"> <!-- تعديل حقل الصورة لرفع صورة جديدة -->
                            <small>Current Image: {{ $event->image }}</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea name="short_description" id="short_description" class="form-control" style="width: 100%; height: 100px;" required>{{ $event->short_description }}</textarea>
                        </div>

                        <!-- إضافة حقل النسبة المئوية لإخفاء الحدث -->
                        <div class="form-group mb-3">
                            <label for="hide_percentage" class="form-label">Hide Event When Interested Users Exceed (% of Capacity)</label>
                            <input type="number" name="hide_percentage" id="hide_percentage" class="form-control" style="width: 100%;" value="{{ $event->hide_percentage }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- ------------
 --}}
{{--
 @extends('layouts.careprovider.master')

@section('content')
    <div style="position: relative;">
        <h1>My Events</h1>

        <!-- زر لفتح فورم الإضافة -->
        <div style="margin-top: 30px; margin-left: 200px" id="add-event-button-container">
            <button type="submit" class="btn btn-primary" onclick="showAddForm()">
                <i class="fa-solid fa-plus" style="color: #fcfcfc; margin-right: 1vh;"></i> Add New Event
            </button>
        </div>

        @if($events->isEmpty())
            <p>No events are available at the moment.</p>
        @else
            <table class="events-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->date }}</td>
                            <td>{{ $event->location }}</td>
                            <td>{{ $event->capacity }}</td>
                            <td>
                                <!-- زر لتعديل الحدث -->
                                <a href="javascript:void(0);" onclick="showEditForm({{ $event->id }}, '{{ $event->title }}', '{{ $event->description }}', '{{ $event->date }}', '{{ $event->location }}', '{{ $event->capacity }}', '{{ $event->short_description }}', '{{ $event->hide_percentage }}')">
                                    <i class="fa-solid fa-pen-to-square" style="color: #8375d0;"></i>
                                </a> |
                                <form action="{{ route('careprovider.events.destroy', $event->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:none; border:none; padding:0; margin:0;">
                                        <i class="fa-solid fa-trash" style="color: #8375d0;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- نموذج الإضافة المخفي -->
        <div id="add-event-form" style="display:none; margin-top: 30px;">
            <div style="text-align: right;">
                <button onclick="hideForm('add-event-form')" style="background: none; border: none; font-size: 24px;">&times;</button>
            </div>
            <div class="container mt-5">
                <h1 class="text-center mb-4">Add New Event</h1>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-box" style="max-width: 500px; padding: 80px; border: 1px solid #ccc; border-radius: 8px;">
                            <form action="{{ route('careprovider.events.store') }}" method="POST" class="form">
                                @csrf
                                <!-- الحقول الخاصة بنموذج الإضافة -->
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" id="title" class="form-control" style="width: 100%;" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" style="width: 100%; height: 150px;" required></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" name="date" id="date" class="form-control" style="width: 100%;" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" name="location" id="location" class="form-control" style="width: 100%;" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="number" name="capacity" id="capacity" class="form-control" style="width: 100%;" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" name="image" id="image" class="form-control" style="width: 100%;" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea name="short_description" id="short_description" class="form-control" style="width: 100%; height: 100px;" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Event</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- نموذج التعديل المخفي -->
        <div id="edit-event-form" style="display:none; margin-top: 30px;">
            <div style="text-align: right;">
                <button onclick="hideForm('edit-event-form')" style="background: none; border: none; font-size: 24px;">&times;</button>
            </div>
            <div class="container mt-5">
                <h1 class="text-center mb-4">Edit Event</h1>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-box" style="max-width: 500px; padding: 80px; border: 1px solid #ccc; border-radius: 8px;">
                            <form id="edit-form" action="" method="POST" class="form"> <!-- سنقوم بتحديث action في جافا سكريبت -->
                                @csrf
                                @method('PUT')
                                <!-- الحقول الخاصة بنموذج التعديل -->
                                <div class="form-group mb-3">
                                    <label for="edit-title" class="form-label">Title</label>
                                    <input type="text" name="title" id="edit-title" class="form-control" style="width: 100%;" required>
                                </div>
                                <<div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" style="width: 100%; height: 150px;" required>{{ $event->description }}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" name="date" id="date" class="form-control" style="width: 100%;" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" name="location" id="location" class="form-control" style="width: 100%;" value="{{ $event->location }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="number" name="capacity" id="capacity" class="form-control" style="width: 100%;" value="{{ $event->capacity }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Event Image</label>
                                    <input type="file" name="image" id="image" class="form-control" style="width: 100%;"> <!-- تعديل حقل الصورة لرفع صورة جديدة -->
                                    <small>Current Image: {{ $event->image }}</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea name="short_description" id="short_description" class="form-control" style="width: 100%; height: 100px;" required>{{ $event->short_description }}</textarea>
                                </div>

                                <!-- إضافة حقل النسبة المئوية لإخفاء الحدث -->
                                <div class="form-group mb-3">
                                    <label for="hide_percentage" class="form-label">Hide Event When Interested Users Exceed (% of Capacity)</label>
                                    <input type="number" name="hide_percentage" id="hide_percentage" class="form-control" style="width: 100%;" value="{{ $event->hide_percentage }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Event</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // دالة لإظهار نموذج الإضافة
        function showAddForm() {
            document.getElementById('add-event-form').style.display = 'block';
            document.getElementById('edit-event-form').style.display = 'none'; // إخفاء نموذج التعديل إذا كان مفتوحاً
            document.getElementById('add-event-button-container').style.display = 'none'; // إخفاء زر الإضافة
        }

        // دالة لإظهار نموذج التعديل
        function showEditForm(id, title, description, date, location, capacity, short_description, hide_percentage) {
            // تحديث action الخاص بنموذج التعديل
            document.getElementById('edit-form').action = '/careprovider/events/' + id;

            // ملء القيم في الحقول
            document.getElementById('edit-title').value = title;
            // ملء باقي الحقول...

            document.getElementById('edit-event-form').style.display = 'block';
            document.getElementById('add-event-form').style.display = 'none'; // إخفاء نموذج الإضافة
            document.getElementById('add-event-button-container').style.display = 'none'; // إخفاء زر الإضافة
        }

        // دالة لإخفاء النماذج
        function hideForm(formId) {
            document.getElementById(formId).style.display = 'none';
            document.getElementById('add-event-button-container').style.display = 'block'; // إظهار زر الإضافة مجدداً
        }
    </script>
@endsection --}}
