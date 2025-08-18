@extends('Admin.layout')

@section('styles')
<style>
    .edit-subject-container {
        padding: 2rem 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    
    .page-title {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }
    
    .page-subtitle {
        color: #94a3b8;
        font-size: 1.1rem;
        margin: 0.5rem 0 0 0;
    }
    
    .back-btn {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .back-btn:hover {
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .form-container {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    
    .form-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .form-control {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: #fff;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .form-control:focus {
        background: rgba(255,255,255,0.08);
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.2rem rgba(56,189,248,0.25);
        color: #fff;
        outline: none;
    }
    
    .form-control::placeholder {
        color: #64748b;
    }
    
    .form-select {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: #fff;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .form-select:focus {
        background: rgba(255,255,255,0.08);
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.2rem rgba(56,189,248,0.25);
        color: #fff;
        outline: none;
    }
    
    .form-select option {
        background: #1E293B;
        color: #fff;
    }
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .form-check-input {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 4px;
        width: 1.2rem;
        height: 1.2rem;
        margin: 0;
    }
    
    .form-check-input:checked {
        background-color: #38bdf8;
        border-color: #38bdf8;
    }
    
    .form-check-label {
        color: #94a3b8;
        font-weight: 500;
        margin: 0;
    }
    
    .image-preview {
        width: 150px;
        height: 150px;
        border-radius: 10px;
        object-fit: cover;
        background: rgba(255,255,255,0.1);
        border: 2px dashed rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }
    
    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .current-image {
        margin-bottom: 1rem;
    }
    
    .current-image img {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.2);
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        min-width: 150px;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .btn-cancel {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        padding: 0.75rem 2rem;
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s ease;
        min-width: 150px;
        text-align: center;
    }
    
    .btn-cancel:hover {
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
    }
    
    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border-left: 4px solid #ef4444;
    }
    
    .field-group {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .field-group-title {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .field-group.university-fields {
        border-color: rgba(56,189,248,0.2);
    }
    
    .field-group.secondary-fields {
        border-color: rgba(139,92,246,0.2);
    }
    
    .field-group.university-fields .field-group-title {
        color: #38bdf8;
    }
    
    .field-group.secondary-fields .field-group-title {
        color: #8b5cf6;
    }
    
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -0.75rem;
    }
    
    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 0.75rem;
    }
    
    .col-md-12 {
        flex: 0 0 100%;
        max-width: 100%;
        padding: 0 0.75rem;
    }
    
    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-submit, .btn-cancel {
            width: 100%;
        }
    }
</style>
@endsection

@section('main')
<div class="edit-subject-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">تعديل المادة</h1>
                <p class="page-subtitle">تعديل معلومات المادة الدراسية</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('admin.subjects.index') }}" class="back-btn">
                    <i class="fa fa-arrow-right"></i>
                    العودة للمواد
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Container -->
    <div class="form-container">
        <h2 class="form-title">تعديل معلومات المادة</h2>
        
        <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST" enctype="multipart/form-data" id="subjectForm">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="field-group">
                <h3 class="field-group-title">
                    <i class="fa fa-info-circle"></i>
                    المعلومات الأساسية
                </h3>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">اسم المادة *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $subject->name) }}" 
                                   placeholder="أدخل اسم المادة" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="term" class="form-label">الفصل الدراسي *</label>
                            <select class="form-select @error('term') is-invalid @enderror" 
                                    id="term" name="term" required>
                                <option value="">اختر الفصل الدراسي</option>
                                @foreach($filterOptions['terms'] as $term)
                                    <option value="{{ $term->value }}" {{ old('term', $subject->term?->value) === $term->value ? 'selected' : '' }}>
                                        {{ $term->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="academic_level" class="form-label">المستوى الأكاديمي *</label>
                            <select class="form-select @error('academic_level') is-invalid @enderror" 
                                    id="academic_level" name="academic_level" required>
                                <option value="">اختر المستوى الأكاديمي</option>
                                @foreach($filterOptions['academic_levels'] as $level)
                                    <option value="{{ $level->value }}" {{ old('academic_level', $subject->academic_level?->value) === $level->value ? 'selected' : '' }}>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type" class="form-label">نوع المادة *</label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" name="type" required>
                                <option value="">اختر نوع المادة</option>
                                @foreach($filterOptions['subject_types'] as $type)
                                    <option value="{{ $type->value }}" {{ old('type', $subject->type?->value) === $type->value ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="image" class="form-label">صورة المادة</label>
                    @if($subject->image)
                        <div class="current-image">
                            <p class="text-muted mb-2">الصورة الحالية:</p>
                            <img src="{{ asset('storage/' . $subject->image) }}" alt="Current Image">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*">
                    <div class="image-preview" id="imagePreview">
                        <span>معاينة الصورة الجديدة</span>
                    </div>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', $subject->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        تفعيل المادة
                    </label>
                </div>
            </div>
            
            <!-- University Fields -->
            <div class="field-group university-fields" id="universityFields" style="display: none;">
                <h3 class="field-group-title">
                    <i class="fa fa-university"></i>
                    معلومات الجامعة
                </h3>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="college_type_id" class="form-label">نوع الكلية *</label>
                            <select class="form-select @error('college_type_id') is-invalid @enderror" 
                                    id="college_type_id" name="college_type_id">
                                <option value="">اختر نوع الكلية</option>
                                @foreach($filterOptions['college_types'] as $collegeType)
                                    <option value="{{ $collegeType->id }}" {{ old('college_type_id', $subject->college_type_id) == $collegeType->id ? 'selected' : '' }}>
                                        {{ $collegeType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="grade_level" class="form-label">مستوى السنة الدراسية *</label>
                            <select class="form-select @error('grade_level') is-invalid @enderror" 
                                    id="grade_level" name="grade_level">
                                <option value="">اختر مستوى السنة</option>
                                @for($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ old('grade_level', $subject->grade_level) == $i ? 'selected' : '' }}>
                                        السنة {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Secondary Fields -->
            <div class="field-group secondary-fields" id="secondaryFields" style="display: none;">
                <h3 class="field-group-title">
                    <i class="fa fa-graduation-cap"></i>
                    معلومات الثانوية
                </h3>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="secondary_type" class="form-label">نوع المدرسة الثانوية *</label>
                            <select class="form-select @error('secondary_type') is-invalid @enderror" 
                                    id="secondary_type" name="secondary_type">
                                <option value="">اختر نوع المدرسة</option>
                                @foreach($filterOptions['secondary_types'] as $type)
                                    <option value="{{ $type->value }}" {{ old('secondary_type', $subject->secondary_type?->value) === $type->value ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="secondary_grade" class="form-label">الصف الثانوي *</label>
                            <select class="form-select @error('secondary_grade') is-invalid @enderror" 
                                    id="secondary_grade" name="secondary_grade">
                                <option value="">اختر الصف</option>
                                @foreach($filterOptions['secondary_grades'] as $grade)
                                    <option value="{{ $grade->value }}" {{ old('secondary_grade', $subject->secondary_grade?->value) === $grade->value ? 'selected' : '' }}>
                                        {{ $grade->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="secondary_section" class="form-label">القسم</label>
                            <select class="form-select @error('secondary_section') is-invalid @enderror" 
                                    id="secondary_section" name="secondary_section">
                                <option value="">اختر القسم</option>
                                @foreach($filterOptions['secondary_sections'] as $section)
                                    <option value="{{ $section->value }}" {{ old('secondary_section', $subject->secondary_section?->value) === $section->value ? 'selected' : '' }}>
                                        {{ $section->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fa fa-save"></i>
                    حفظ التغييرات
                </button>
                <a href="{{ route('admin.subjects.index') }}" class="btn-cancel">
                    <i class="fa fa-times"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const academicLevelSelect = document.getElementById('academic_level');
    const universityFields = document.getElementById('universityFields');
    const secondaryFields = document.getElementById('secondaryFields');
    const secondaryGradeSelect = document.getElementById('secondary_grade');
    const secondarySectionSelect = document.getElementById('secondary_section');
    const typeSelect = document.getElementById('type');
    const typeField = typeSelect.parentElement;
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    
    // Handle academic level change
    academicLevelSelect.addEventListener('change', function() {
        const selectedValue = this.value;
        
        // Hide all field groups
        universityFields.style.display = 'none';
        secondaryFields.style.display = 'none';
        
        // Show relevant field group and handle type field visibility
        if (selectedValue === 'university') {
            universityFields.style.display = 'block';
            // Hide type field for university subjects
            typeField.style.display = 'none';
            typeSelect.required = false;
            typeSelect.value = '';
        } else if (selectedValue === 'secondary') {
            secondaryFields.style.display = 'block';
            // Show type field for secondary subjects (will be controlled by grade)
            typeField.style.display = 'block';
            typeSelect.required = true;
        } else {
            // Hide type field when no academic level is selected
            typeField.style.display = 'none';
            typeSelect.required = false;
            typeSelect.value = '';
        }
        
        // Clear fields when switching
        clearFields(selectedValue);
    });
    
    // Handle secondary grade change
    secondaryGradeSelect.addEventListener('change', function() {
        const selectedValue = this.value;
        
        if (selectedValue === 'second' || selectedValue === 'third') {
            secondarySectionSelect.required = true;
            secondarySectionSelect.parentElement.querySelector('.form-label').innerHTML = 'القسم *';
            // Show type field for second and third grades
            typeField.style.display = 'block';
            typeSelect.required = true;
        } else if (selectedValue === 'first') {
            secondarySectionSelect.required = false;
            secondarySectionSelect.parentElement.querySelector('.form-label').innerHTML = 'القسم';
            secondarySectionSelect.value = '';
            // Hide type field for first grade
            typeField.style.display = 'none';
            typeSelect.required = false;
            typeSelect.value = '';
        } else {
            secondarySectionSelect.required = false;
            secondarySectionSelect.parentElement.querySelector('.form-label').innerHTML = 'القسم';
            secondarySectionSelect.value = '';
            // Hide type field when no grade is selected
            typeField.style.display = 'none';
            typeSelect.required = false;
            typeSelect.value = '';
        }
    });
    
    // Handle image preview
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.innerHTML = '<span>معاينة الصورة الجديدة</span>';
        }
    });
    
    // Clear fields function
    function clearFields(academicLevel) {
        if (academicLevel === 'university') {
            // Clear secondary fields
            document.getElementById('secondary_type').value = '';
            document.getElementById('secondary_grade').value = '';
            document.getElementById('secondary_section').value = '';
        } else if (academicLevel === 'secondary') {
            // Clear university fields
            document.getElementById('college_type_id').value = '';
            document.getElementById('grade_level').value = '';
        }
    }
    
    // Initialize on page load
    if (academicLevelSelect.value) {
        academicLevelSelect.dispatchEvent(new Event('change'));
    }
    
    if (secondaryGradeSelect.value) {
        secondaryGradeSelect.dispatchEvent(new Event('change'));
    }
    
    // Set initial type field visibility
    if (academicLevelSelect.value === 'university') {
        typeField.style.display = 'none';
        typeSelect.required = false;
    } else if (academicLevelSelect.value === 'secondary' && secondaryGradeSelect.value === 'first') {
        typeField.style.display = 'none';
        typeSelect.required = false;
    }
});
</script>
@endsection
