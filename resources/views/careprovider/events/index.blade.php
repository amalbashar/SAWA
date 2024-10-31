@extends('layouts.careprovider.master')

@section('content')
    <div style="position: relative;">
        <h1>My Events</h1>

        <!-- زر إضافة حدث جديد -->
        <div style="margin-top: 30px; margin-left: 200px" id="add-event-button-container">
            <button type="submit" class="btn btn-primary" onclick="showForm('add-event-form')">
                <i class="fa-solid fa-plus" style="color: #fff; margin-right: 1vh;"></i> Add New Event
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- التحقق من وجود فعاليات -->
        @if($events->isEmpty())
            <p>No events available at the moment.</p>
        @else
            <!-- جدول عرض الفعاليات -->
            <table class="events-table" style="margin-top: 30px;">
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
                            <td>{{ \Carbon\Carbon::parse($event->date)->format('d-m-Y') }}</td>
                            <td>{{ $event->location }}</td>
                            <td>{{ $event->capacity }}</td>
                            <td>
                          <!-- أيقونة تعديل الحدث -->
<i class="fa-solid fa-pen-to-square" style="color: #8375d0; font-size: 18px; cursor: pointer;" onclick="showForm('edit-event-form-{{ $event->id }}')" title="Edit Event"></i> |

<!-- أيقونة حذف الحدث -->
<i class="fa-solid fa-trash" style="color: #8375d0; font-size: 18px; cursor: pointer;" onclick="if(confirm('Are you sure you want to delete this event?')) { document.getElementById('delete-form-{{ $event->id }}').submit(); }" title="Delete Event"></i>

<!-- النموذج الخاص بالحذف مخفي -->
<form id="delete-form-{{ $event->id }}" action="{{ route('careprovider.events.destroy', $event->id) }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- الفورم المخفي لإضافة حدث جديد -->
        <div id="add-event-form" style="display:none; margin-top: 30px;">
            <div style="text-align: right;">
                <button onclick="hideForm('add-event-form')" style="background: none; border: none; font-size: 24px;">&times;</button>
            </div>
            <div class="container mt-5">
                <h1 class="text-center mb-4">Add New Event</h1>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-box" style="max-width: 500px; padding: 80px; border: 1px solid #ccc; border-radius: 8px;">
                            <form action="{{ route('careprovider.events.store') }}" method="POST" enctype="multipart/form-data" class="form">
                                @csrf
                                <!-- الحقول الخاصة بإضافة حدث جديد -->
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
                                    <label for="image" class="form-label">Event Image</label>
                                    <input type="file" name="image" id="image" class="form-control" style="width: 100%;" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea name="short_description" id="short_description" class="form-control" style="width: 100%; height: 100px;" required></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="hide_percentage" class="form-label">Hide Event When Interested Users Exceed (% of Capacity)</label>
                                    <input type="number" name="hide_percentage" id="hide_percentage" class="form-control" style="width: 100%;" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Event</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الفورم المخفي لتعديل الحدث -->
        @foreach($events as $event)
            <div id="edit-event-form-{{ $event->id }}" style="display:none; margin-top: 30px;">
                <div style="text-align: right;">
                    <button onclick="hideForm('edit-event-form-{{ $event->id }}')" style="background: none; border: none; font-size: 24px;">&times;</button>
                </div>
                <div class="container mt-5">
                    <h1 class="text-center mb-4">Edit Event</h1>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="form-box" style="max-width: 500px; padding: 80px; border: 1px solid #ccc; border-radius: 8px;">
                                <form action="{{ route('careprovider.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="form">
                                    @csrf
                                    @method('PUT')

                                    <!-- حقول التعديل -->
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
                                        <input type="file" name="image" id="image" class="form-control" style="width: 100%;">
                                        <small>Current Image: {{ $event->image }}</small>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="short_description" class="form-label">Short Description</label>
                                        <textarea name="short_description" id="short_description" class="form-control" style="width: 100%; height: 100px;" required>{{ $event->short_description }}</textarea>
                                    </div>
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
        @endforeach
    </div>

    <!-- JavaScript لإدارة إظهار وإخفاء الفورم -->
    <script>
        function showForm(formId) {
            document.getElementById(formId).style.display = 'block';
            document.getElementById('add-event-button-container').style.display = 'none';
        }

        function hideForm(formId) {
            document.getElementById(formId).style.display = 'none';
            document.getElementById('add-event-button-container').style.display = 'block';
        }
    </script>
@endsection
