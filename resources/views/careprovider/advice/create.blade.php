@extends('layouts.careprovider.master')

@section('title', 'Manage Advice')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Manage Advice</h1>

    <!-- تعديل موضع زر Create Advice إلى اليسار -->
    <div style="margin-top: 30px; margin-left: 10px; display: flex; justify-content: flex-start;">
        <button id="addAdviceBtn" class="btn btn-primary" type="submit">
            <i class="fa-solid fa-plus" style="color: #fcfcfc; margin-right: 1vh;"></i>Create Advice
        </button>
    </div>

    <!-- فورم إضافة النصيحة (مخفي في البداية) -->
    <div id="addAdviceForm" class="form-box d-flex justify-content-center align-items-center" style="display: none; max-width: 500px; padding: 40px; border: 1px solid #ccc; border-radius: 8px; margin: 0 auto; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); text-align: left; position: relative;">
        <!-- زر إغلاق (X) -->
        <button id="closeAdviceForm" class="btn btn-danger" style="position: absolute; top: 10px; right: 10px; background-color: transparent; border: none;">
            <i class="fa-solid fa-xmark" style="color: #8375d0; font-size: 24px;"></i>
        </button>

        <!-- عرض رسالة نجاح إذا تم إضافة النصيحة بنجاح -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- عرض الأخطاء إن وجدت -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- فورم إضافة النصيحة -->
        <form action="{{ route('careprovider.advice.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="form-group mb-3">
                <label for="advice" class="form-label">Enter Advice</label>
                <input type="text" name="advice" id="advice" class="form-control" placeholder="Enter advice" value="{{ old('advice') }}" style="border-radius: 10px;">
            </div>
            <div style="text-align: center;">
                <button type="submit" class="btn btn-primary btn-lg">Add Advice</button>
            </div>
        </form>
    </div>

    <!-- عرض النصائح المضافة مسبقاً داخل بطاقات -->
    <div class="container" style="display: flex; flex-wrap: wrap; justify-content: flex-start;">
        @if($adviceList->isNotEmpty())
            @foreach($adviceList as $advice)
            <div style="border: 1px solid #ccc; border-radius: 8px; padding: 20px; margin: 10px; width: 320px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <h5 class="card-title">Advice</h5>
                <p class="card-text" id="advice-text-{{ $advice->id }}">
                    {{ $advice->content }}
                </p>

                <div style="display: flex; align-items: center; margin-top: 10px;">
                    <!-- زر تعديل النصيحة -->
                    <button class="edit-btn" data-id="{{ $advice->id }}" style="background: none; border: none; padding: 0; margin-right: 15px;">
                        <i class="fa-regular fa-pen-to-square" style="color: #8375d0; font-size: 20px;"></i>
                    </button>

                    <!-- زر حذف النصيحة -->
                    <form action="{{ route('careprovider.advice.delete', $advice->id) }}" method="POST" style="margin: 0; padding: 0;" onsubmit="return confirmDelete('{{ $advice->content }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; padding: 0;">
                            <i class="fa-regular fa-trash-can" style="color: #8375d0; font-size: 20px;"></i>
                        </button>
                    </form>
                </div>

                <!-- فورم التعديل (مخفي في البداية) -->
                <form id="edit-form-{{ $advice->id }}" action="{{ route('careprovider.advice.update', $advice->id) }}" method="POST" style="display:none;">
                    @csrf
                    @method('PUT')
                    <input type="text" name="advice" class="form-control" value="{{ $advice->content }}" style="border-radius: 8px; border: 1px solid #ccc; padding: 8px;">
                    <button type="submit" class="btn btn-success btn-sm mt-2" style="border-radius: 8px;">Save</button>
                    <button type="button" class="btn btn-secondary btn-sm mt-2 cancel-edit" data-id="{{ $advice->id }}" style="border-radius: 8px;">Cancel</button>
                </form>
            </div>
            @endforeach
        @else
            <p class="mt-4">You have not added any advice yet.</p>
        @endif
    </div>
</div>

<script>
    function confirmDelete(adviceContent) {
        return confirm('Are you sure you want to delete this advice: "' + adviceContent + '"?');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const addAdviceBtn = document.getElementById('addAdviceBtn');
        const addAdviceForm = document.getElementById('addAdviceForm');
        const closeAdviceForm = document.getElementById('closeAdviceForm');

        addAdviceBtn.addEventListener('click', function() {
            addAdviceForm.style.display = 'block';
            addAdviceBtn.style.display = 'none';
        });

        closeAdviceForm.addEventListener('click', function() {
            addAdviceForm.style.display = 'none';
            addAdviceBtn.style.display = 'block';
        });

        document.querySelectorAll('.edit-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const adviceId = this.getAttribute('data-id');
                document.getElementById('advice-text-' + adviceId).style.display = 'none';
                document.getElementById('edit-form-' + adviceId).style.display = 'block';
            });
        });

        document.querySelectorAll('.cancel-edit').forEach(function(button) {
            button.addEventListener('click', function() {
                const adviceId = this.getAttribute('data-id');
                document.getElementById('advice-text-' + adviceId).style.display = 'block';
                document.getElementById('edit-form-' + adviceId).style.display = 'none';
            });
        });
    });
</script>
@endsection
