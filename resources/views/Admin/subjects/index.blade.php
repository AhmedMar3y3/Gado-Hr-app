@extends('Admin.layout')

@section('styles')
<style>
    .subjects-container {
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
    
    .add-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        color: white;
        text-decoration: none;
    }
    
    /* Stats Cards */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        transition: all 0.3s ease;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    }
    
    .stat-card.active {
        border-color: rgba(16, 185, 129, 0.3);
    }
    
    .stat-card.inactive {
        border-color: rgba(239, 68, 68, 0.3);
    }
    
    .stat-card.university {
        border-color: rgba(56, 189, 248, 0.3);
    }
    
    .stat-card.secondary {
        border-color: rgba(139, 92, 246, 0.3);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        opacity: 0.8;
    }
    
    .stat-card.active .stat-icon {
        color: #10b981;
    }
    
    .stat-card.inactive .stat-icon {
        color: #ef4444;
    }
    
    .stat-card.university .stat-icon {
        color: #38bdf8;
    }
    
    .stat-card.secondary .stat-icon {
        color: #8b5cf6;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #fff;
        margin: 0 0 0.5rem 0;
    }
    
    .stat-label {
        color: #94a3b8;
        font-size: 1rem;
        margin: 0;
    }
    
    /* Filters Section */
    .filters-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    
    .filters-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .filter-group {
        display: flex;
        flex-direction: column;
    }
    
    .filter-label {
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .filter-input {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: #fff;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .filter-input:focus {
        background: rgba(255,255,255,0.08);
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.2rem rgba(56,189,248,0.25);
        color: #fff;
        outline: none;
    }
    
    .filter-input::placeholder {
        color: #64748b;
    }
    
    .filter-select {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: #fff;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .filter-select:focus {
        background: rgba(255,255,255,0.08);
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.2rem rgba(56,189,248,0.25);
        color: #fff;
        outline: none;
    }
    
    .filter-select option {
        background: #1E293B;
        color: #fff;
    }
    
    .filters-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .btn-filter {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);
        color: white;
    }
    
    .btn-clear {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-clear:hover {
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
        text-decoration: none;
    }
    
    /* Subjects Table */
    .subjects-table {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    
    .table {
        margin: 0;
        color: #fff;
    }
    
    .table thead th {
        background: rgba(255,255,255,0.05);
        border: none;
        color: #94a3b8;
        font-weight: 600;
        padding: 1.5rem 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table tbody tr {
        border-bottom: 1px solid rgba(255,255,255,0.05);
        transition: all 0.3s ease;
    }
    
    .table tbody tr:hover {
        background: rgba(255,255,255,0.02);
    }
    
    .table tbody tr:last-child {
        border-bottom: none;
    }
    
    .table tbody td {
        padding: 1.5rem 1rem;
        border: none;
        vertical-align: middle;
    }
    
    .subject-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .subject-image {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        object-fit: cover;
        background: rgba(255,255,255,0.1);
    }
    
    .subject-details h6 {
        color: #fff;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
    }
    
    .subject-details p {
        color: #94a3b8;
        margin: 0;
        font-size: 0.85rem;
    }
    
    .academic-level-badge {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.85rem;
        text-align: center;
    }
    
    .academic-level-badge.university {
        background: rgba(56,189,248,0.1);
        color: #38bdf8;
    }
    
    .academic-level-badge.secondary {
        background: rgba(139,92,246,0.1);
        color: #8b5cf6;
    }
    
    .subject-type-badge {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.85rem;
        text-align: center;
    }
    
    .subject-type-badge.scientific {
        background: rgba(239,68,68,0.1);
        color: #ef4444;
    }
    
    .subject-type-badge.literal {
        background: rgba(16,185,129,0.1);
        color: #10b981;
    }
    
    .subject-type-badge.both {
        background: rgba(245,158,11,0.1);
        color: #f59e0b;
    }
    
    .subject-type-badge.university {
        background: rgba(56,189,248,0.1);
        color: #38bdf8;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.85rem;
        text-align: center;
    }
    
    .status-badge.status-active {
        background: rgba(16,185,129,0.1);
        color: #10b981;
    }
    
    .status-badge.status-inactive {
        background: rgba(239,68,68,0.1);
        color: #ef4444;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .btn-view {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        color: white;
    }
    
    .btn-toggle {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .btn-toggle:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        color: white;
    }
    
    /* Alert Styles */
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
    }
    
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-left: 4px solid #10b981;
    }
    
    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border-left: 4px solid #ef4444;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #94a3b8;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .empty-state h4 {
        color: #fff;
        margin-bottom: 0.5rem;
    }
    
    /* Custom Pagination - Complete Override */
    .custom-pagination {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 0.5rem !important;
        margin-top: 2rem !important;
        list-style: none !important;
        padding: 0 !important;
        flex-wrap: wrap !important;
    }
    
    .custom-pagination .page-item {
        margin: 0 !important;
        padding: 0 !important;
        background: none !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    .custom-pagination .page-link {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        color: #94a3b8 !important;
        border-radius: 8px !important;
        padding: 0.75rem 1rem !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
        min-width: 45px !important;
        text-align: center !important;
        display: block !important;
        font-size: 0.9rem !important;
        font-weight: 500 !important;
        line-height: 1 !important;
        margin: 0 !important;
        box-shadow: none !important;
        outline: none !important;
    }
    
    .custom-pagination .page-link:hover {
        background: rgba(255,255,255,0.1) !important;
        border-color: rgba(255,255,255,0.2) !important;
        color: #fff !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
    }
    
    .custom-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        border-color: #10b981 !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;
    }
    
    .custom-pagination .page-item.disabled .page-link {
        background: rgba(255,255,255,0.02) !important;
        border-color: rgba(255,255,255,0.05) !important;
        color: #64748b !important;
        cursor: not-allowed !important;
        opacity: 0.5 !important;
    }
    
    .custom-pagination .page-item.disabled .page-link:hover {
        transform: none !important;
        background: rgba(255,255,255,0.02) !important;
        border-color: rgba(255,255,255,0.05) !important;
        color: #64748b !important;
    }
    
    .custom-pagination .page-link:focus {
        box-shadow: 0 0 0 0.2rem rgba(56, 189, 248, 0.25) !important;
        outline: none !important;
    }
    
    /* Hide default Laravel pagination */
    .pagination:not(.custom-pagination) {
        display: none !important;
    }
    
    /* Pagination container */
    .pagination-container {
        display: flex !important;
        justify-content: center !important;
        width: 100% !important;
        margin-top: 2rem !important;
    }
</style>
@endsection

@section('main')
<div class="subjects-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">المواد الدراسية</h1>
                <p class="page-subtitle">إدارة المواد الدراسية للجامعات والثانوية</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('admin.subjects.create') }}" class="add-btn">
                    <i class="fa fa-plus"></i>
                    إضافة مادة جديدة
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-cards">
        <div class="stat-card active">
            <i class="fa fa-book stat-icon"></i>
            <h3 class="stat-number">{{ $statistics['totalSubjects'] }}</h3>
            <p class="stat-label">إجمالي المواد</p>
        </div>
        <div class="stat-card active">
            <i class="fa fa-check-circle stat-icon"></i>
            <h3 class="stat-number">{{ $statistics['activeSubjects'] }}</h3>
            <p class="stat-label">المواد النشطة</p>
        </div>
        <div class="stat-card university">
            <i class="fa fa-university stat-icon"></i>
            <h3 class="stat-number">{{ $statistics['universitySubjects'] }}</h3>
            <p class="stat-label">المواد الجامعية</p>
        </div>
        <div class="stat-card secondary">
            <i class="fa fa-graduation-cap stat-icon"></i>
            <h3 class="stat-number">{{ $statistics['secondarySubjects'] }}</h3>
            <p class="stat-label">المواد الثانوية</p>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <h3 class="filters-title">
            <i class="fa fa-filter"></i>
            فلاتر البحث
        </h3>
        
        <form method="GET" action="{{ route('admin.subjects.index') }}" id="filtersForm">
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">البحث</label>
                    <input type="text" name="search" class="filter-input" placeholder="اسم المادة" value="{{ request('search') }}">
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">المستوى الأكاديمي</label>
                    <select name="academic_level" class="filter-select">
                        <option value="">جميع المستويات</option>
                                                 @foreach($filterOptions['academic_levels'] as $level)
                             <option value="{{ $level->value }}" {{ request('academic_level') === $level->value ? 'selected' : '' }}>
                                 {{ $level->getLocalizedName() }}
                             </option>
                         @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">الحالة</label>
                    <select name="status" class="filter-select">
                        <option value="">جميع الحالات</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>معطل</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">الفصل الدراسي</label>
                    <select name="term" class="filter-select">
                        <option value="">جميع الفصول</option>
                                                 @foreach($filterOptions['terms'] as $term)
                             <option value="{{ $term->value }}" {{ request('term') === $term->value ? 'selected' : '' }}>
                                 {{ $term->getLocalizedName() }}
                             </option>
                         @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">نوع المادة</label>
                    <select name="type" class="filter-select">
                        <option value="">جميع الأنواع</option>
                                                 @foreach($filterOptions['subject_types'] as $type)
                             <option value="{{ $type->value }}" {{ request('type') === $type->value ? 'selected' : '' }}>
                                 {{ $type->getLocalizedName() }}
                             </option>
                         @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">نوع الكلية</label>
                    <select name="college_type_id" class="filter-select">
                        <option value="">جميع أنواع الكليات</option>
                        @foreach($filterOptions['college_types'] as $collegeType)
                            <option value="{{ $collegeType->id }}" {{ request('college_type_id') == $collegeType->id ? 'selected' : '' }}>
                                {{ $collegeType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">مستوى السنة</label>
                    <select name="grade_level" class="filter-select">
                        <option value="">جميع المستويات</option>
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ request('grade_level') == $i ? 'selected' : '' }}>
                                السنة {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">نوع المدرسة الثانوية</label>
                    <select name="secondary_type" class="filter-select">
                        <option value="">جميع الأنواع</option>
                                                 @foreach($filterOptions['secondary_types'] as $type)
                             <option value="{{ $type->value }}" {{ request('secondary_type') === $type->value ? 'selected' : '' }}>
                                 {{ $type->getLocalizedName() }}
                             </option>
                         @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">الصف الثانوي</label>
                    <select name="secondary_grade" class="filter-select">
                        <option value="">جميع الصفوف</option>
                                                 @foreach($filterOptions['secondary_grades'] as $grade)
                             <option value="{{ $grade->value }}" {{ request('secondary_grade') === $grade->value ? 'selected' : '' }}>
                                 {{ $grade->getLocalizedName() }}
                             </option>
                         @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">القسم</label>
                    <select name="secondary_section" class="filter-select">
                        <option value="">جميع الأقسام</option>
                                                 @foreach($filterOptions['secondary_sections'] as $section)
                             <option value="{{ $section->value }}" {{ request('secondary_section') === $section->value ? 'selected' : '' }}>
                                 {{ $section->getLocalizedName() }}
                             </option>
                         @endforeach
                    </select>
                </div>
            </div>
            
            <div class="filters-actions">
                <button type="submit" class="btn-filter">
                    <i class="fa fa-search"></i>
                    تطبيق الفلاتر
                </button>
                <a href="{{ route('admin.subjects.index') }}" class="btn-clear">
                    <i class="fa fa-times"></i>
                    مسح الفلاتر
                </a>
            </div>
        </form>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Subjects Table -->
    <div class="subjects-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>المادة</th>
                        <th>المستوى الأكاديمي</th>
                        <th>نوع المادة</th>
                        <th>الفصل الدراسي</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                    <tr>
                        <td>
                            <div class="subject-info">
                                <img src="{{ $subject->image ? asset('storage/' . $subject->image) : asset('defaults/subject.png') }}" 
                                    alt="Subject Image" class="subject-image">
                                <div class="subject-details">
                                    <h6>{{ $subject->name }}</h6>
                                    <p>
                                        @if($subject->academic_level === App\Enums\AcademicLevel::UNIVERSITY)
                                            @if($subject->collegeType)
                                                {{ $subject->collegeType->name }} - السنة {{ $subject->grade_level }}
                                            @else
                                                جامعة - السنة {{ $subject->grade_level }}
                                            @endif
                                        @else
                                            @if($subject->secondary_type && $subject->secondary_grade)
                                                {{ $subject->secondary_type->getLocalizedName() }} - {{ $subject->secondary_grade->getLocalizedName() }}
                                                @if($subject->secondary_section)
                                                    - {{ $subject->secondary_section->getLocalizedName() }}
                                                @endif
                                            @else
                                                جامعة
                                            @endif
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="academic-level-badge {{ $subject->academic_level }}">
                                {{ $subject->academic_level?->getLocalizedName() ?? 'غير محدد' }}
                            </span>
                        </td>
                        <td>
                            @if($subject->academic_level === App\Enums\AcademicLevel::UNIVERSITY)
                                <span class="subject-type-badge university">
                                    جامعة
                                </span>
                            @else
                                                                 <span class="subject-type-badge {{ $subject->type }}">
                                     {{ $subject->type?->getLocalizedName() ?? 'جامعة' }}
                                 </span>
                            @endif
                        </td>
                        <td>{{ $subject->term?->getLocalizedName() ?? 'غير محدد' }}</td>
                        <td>
                            <span class="status-badge {{ $subject->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $subject->is_active ? 'نشط' : 'معطل' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                                                 <button type="button" class="btn-view" data-bs-toggle="modal" data-bs-target="#showSubjectModal{{ $subject->id }}" title="عرض التفاصيل">
                                     <i class="fa fa-eye"></i>
                                     عرض
                                 </button>
                                <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn-edit" title="تعديل">
                                    <i class="fa fa-edit"></i>
                                    تعديل
                                </a>
                                <form action="{{ route('admin.subjects.toggle-status', $subject->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-toggle" title="{{ $subject->is_active ? 'إيقاف' : 'تفعيل' }}">
                                        <i class="fa fa-{{ $subject->is_active ? 'pause' : 'play' }}"></i>
                                        {{ $subject->is_active ? 'إيقاف' : 'تفعيل' }}
                                    </button>
                                </form>
                                <button type="button" class="btn-delete" onclick="deleteSubject({{ $subject->id }})" title="حذف">
                                    <i class="fa fa-trash"></i>
                                    حذف
                                </button>
                            </div>
                                                 </td>
                     </tr>

                     <!-- Show Subject Modal -->
                     <div class="modal fade" id="showSubjectModal{{ $subject->id }}" tabindex="-1" aria-labelledby="showSubjectModalLabel{{ $subject->id }}" aria-hidden="true">
                         <div class="modal-dialog modal-lg">
                             <div class="modal-content">
                                 <div class="modal-header">
                                     <h5 class="modal-title" id="showSubjectModalLabel{{ $subject->id }}">تفاصيل المادة</h5>
                                     <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                 </div>
                                                                   <div class="modal-body">
                                      <div class="row">
                                          <div class="col-md-4 text-center">
                                              <img src="{{ $subject->image ? asset('storage/' . $subject->image) : asset('defaults/subject.png') }}" 
                                                   alt="Subject Image" class="img-fluid rounded" style="max-width: 200px;">
                                          </div>
                                          <div class="col-md-8">
                                              <h4 class="text-white mb-3">{{ $subject->name }}</h4>
                                              
                                              @if($subject->academic_level === App\Enums\AcademicLevel::UNIVERSITY)
                                                  <!-- University Subject Details -->
                                                  <div class="row">
                                                      <div class="col-md-6">
                                                          <p><strong class="text-info">المستوى الأكاديمي:</strong> {{ $subject->academic_level?->getLocalizedName() ?? 'غير محدد' }}</p>
                                                          <p><strong class="text-info">نوع الكلية:</strong> {{ $subject->collegeType?->name ?? 'غير محدد' }}</p>
                                                          <p><strong class="text-info">مستوى السنة:</strong> {{ $subject->grade_level }}</p>
                                                          <p><strong class="text-info">الفصل الدراسي:</strong> {{ $subject->term?->getLocalizedName() ?? 'غير محدد' }}</p>
                                                      </div>
                                                      <div class="col-md-6">
                                                          <p><strong class="text-info">الحالة:</strong> {{ $subject->is_active ? 'نشط' : 'معطل' }}</p>
                                                          <p><strong class="text-info">تاريخ الإنشاء:</strong> {{ $subject->created_at->format('Y-m-d') }}</p>
                                                      </div>
                                                  </div>
                                              @else
                                                  <!-- Secondary Subject Details -->
                                                  <div class="row">
                                                                                                             <div class="col-md-6">
                                                           <p><strong class="text-info">المستوى الأكاديمي:</strong> {{ $subject->academic_level?->getLocalizedName() ?? 'غير محدد' }}</p>
                                                           <p><strong class="text-info">نوع المدرسة:</strong> {{ $subject->secondary_type?->getLocalizedName() ?? 'غير محدد' }}</p>
                                                           <p><strong class="text-info">الصف:</strong> {{ $subject->secondary_grade?->getLocalizedName() ?? 'غير محدد' }}</p>
                                                           @if($subject->secondary_section)
                                                               <p><strong class="text-info">القسم:</strong> {{ $subject->secondary_section->getLocalizedName() }}</p>
                                                           @endif
                                                           <p><strong class="text-info">نوع المادة:</strong> {{ $subject->type?->getLocalizedName() ?? 'غير محدد' }}</p>
                                                       </div>
                                                       <div class="col-md-6">
                                                           <p><strong class="text-info">الفصل الدراسي:</strong> {{ $subject->term?->getLocalizedName() ?? 'غير محدد' }}</p>
                                                          <p><strong class="text-info">الحالة:</strong> {{ $subject->is_active ? 'نشط' : 'معطل' }}</p>
                                                          <p><strong class="text-info">تاريخ الإنشاء:</strong> {{ $subject->created_at->format('Y-m-d') }}</p>
                                                      </div>
                                                  </div>
                                              @endif
                                          </div>
                                      </div>
                                  </div>
                                 <div class="modal-footer">
                                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                 </div>
                             </div>
                         </div>
                     </div>

                     @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fa fa-book"></i>
                                <h4>لا توجد مواد</h4>
                                <p>لم يتم العثور على مواد مطابقة للفلاتر المحددة</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom Pagination -->
    @if($subjects->hasPages())
    <div class="pagination-container">
        <ul class="custom-pagination">
            {{-- Previous Page Link --}}
            @if ($subjects->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">السابق</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $subjects->previousPageUrl() }}" rel="prev">السابق</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($subjects->getUrlRange(1, $subjects->lastPage()) as $page => $url)
                @if ($page == $subjects->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($subjects->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $subjects->nextPageUrl() }}" rel="next">التالي</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">التالي</span>
                </li>
            @endif
        </ul>
    </div>
    @endif
</div>


@endsection

 @section('scripts')
 <script>
 function deleteSubject(id) {
     if (confirm('هل أنت متأكد من حذف هذه المادة؟')) {
         const form = document.createElement('form');
         form.method = 'POST';
         form.action = `{{ route('admin.subjects.destroy', '') }}/${id}`;
         
         const csrfToken = document.createElement('input');
         csrfToken.type = 'hidden';
         csrfToken.name = '_token';
         csrfToken.value = '{{ csrf_token() }}';
         
         const methodField = document.createElement('input');
         methodField.type = 'hidden';
         methodField.name = '_method';
         methodField.value = 'DELETE';
         
         form.appendChild(csrfToken);
         form.appendChild(methodField);
         document.body.appendChild(form);
         form.submit();
     }
 }
 </script>
 @endsection
