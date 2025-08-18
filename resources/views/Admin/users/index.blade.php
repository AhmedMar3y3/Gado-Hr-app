@extends('Admin.layout')

@section('styles')
<style>
    .users-container {
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
    
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .stat-card.active {
        border-color: rgba(16, 185, 129, 0.3);
    }
    
    .stat-card.inactive {
        border-color: rgba(239, 68, 68, 0.3);
    }
    
    .stat-card.subscribed {
        border-color: rgba(56, 189, 248, 0.3);
    }
    
    .stat-card.verified {
        border-color: rgba(139, 92, 246, 0.3);
    }
    
    .stat-number {
        color: #fff;
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
    }
    
    .stat-label {
        color: #94a3b8;
        font-size: 0.9rem;
        margin: 0.5rem 0 0 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    
    .stat-card.active .stat-icon {
        color: #10b981;
    }
    
    .stat-card.inactive .stat-icon {
        color: #ef4444;
    }
    
    .stat-card.subscribed .stat-icon {
        color: #38bdf8;
    }
    
    .stat-card.verified .stat-icon {
        color: #8b5cf6;
    }
    
    .filters-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    
    .filters-title {
        color: #fff;
        font-size: 1.2rem;
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
    }
    
    .filter-group {
        display: flex;
        flex-direction: column;
    }
    
    .filter-label {
        color: #94a3b8;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        font-weight: 500;
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
    }
    
    .filter-select option {
        background: #1E293B;
        color: #fff;
    }
    
    .filters-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
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
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .btn-clear {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        color: #94a3b8;
        transition: all 0.3s ease;
        text-decoration: none;
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
    
    .users-table {
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
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.1);
    }
    
    .user-details {
        display: flex;
        flex-direction: column;
    }
    
    .user-name {
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
        margin: 0;
    }
    
    .user-phone {
        color: #94a3b8;
        font-size: 0.9rem;
        margin: 0;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-active {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .status-inactive {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
    
    .status-verified {
        background: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
        border: 1px solid rgba(139, 92, 246, 0.2);
    }
    
    .status-unverified {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }
    
    .subscription-badge {
        background: rgba(56, 189, 248, 0.1);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .subscription-count {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .academic-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .academic-level {
        color: #fff;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .academic-details {
        color: #94a3b8;
        font-size: 0.8rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
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
    
    .btn-toggle {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .btn-toggle:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
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
    
    /* Responsive */
    @media (max-width: 768px) {
        .filters-grid {
            grid-template-columns: 1fr;
        }
        
        .stats-cards {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .btn-view, .btn-toggle, .btn-delete {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('main')
<div class="users-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">إدارة المستخدمين</h1>
                <p class="page-subtitle">عرض وإدارة جميع مستخدمي التطبيق</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-cards">
        <div class="stat-card active">
            <i class="fa fa-users stat-icon"></i>
            <h3 class="stat-number">{{ $users->total() }}</h3>
            <p class="stat-label">إجمالي المستخدمين</p>
        </div>
        <div class="stat-card active">
            <i class="fa fa-check-circle stat-icon"></i>
            <h3 class="stat-number">{{ $users->where('is_active', true)->count() }}</h3>
            <p class="stat-label">المستخدمين النشطين</p>
        </div>
        <div class="stat-card subscribed">
            <i class="fa fa-star stat-icon"></i>
            <h3 class="stat-number">{{ $users->where('subscriptions_count', '>', 0)->count() }}</h3>
            <p class="stat-label">المشتركين</p>
        </div>
        <div class="stat-card verified">
            <i class="fa fa-shield-alt stat-icon"></i>
            <h3 class="stat-number">{{ $users->where('is_verified', true)->count() }}</h3>
            <p class="stat-label">المستخدمين المؤكدين</p>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <h3 class="filters-title">
            <i class="fa fa-filter"></i>
            فلاتر البحث
        </h3>
        
        <form method="GET" action="{{ route('admin.users.index') }}" id="filtersForm">
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">البحث</label>
                    <input type="text" name="search" class="filter-input" placeholder="الاسم أو رقم الهاتف" value="{{ request('search') }}">
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
                    <label class="filter-label">التأكيد</label>
                    <select name="verified" class="filter-select">
                        <option value="">جميع المستخدمين</option>
                        <option value="verified" {{ request('verified') === 'verified' ? 'selected' : '' }}>مؤكد</option>
                        <option value="unverified" {{ request('verified') === 'unverified' ? 'selected' : '' }}>غير مؤكد</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">الاشتراك</label>
                    <select name="subscription" class="filter-select">
                        <option value="">جميع المستخدمين</option>
                        <option value="subscribed" {{ request('subscription') === 'subscribed' ? 'selected' : '' }}>مشترك</option>
                        <option value="not_subscribed" {{ request('subscription') === 'not_subscribed' ? 'selected' : '' }}>غير مشترك</option>
                    </select>
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
                    <label class="filter-label">الجنس</label>
                    <select name="gender" class="filter-select">
                        <option value="">جميع الأجناس</option>
                        @foreach($filterOptions['genders'] as $gender)
                            <option value="{{ $gender->value }}" {{ request('gender') === $gender->value ? 'selected' : '' }}>
                                {{ $gender->getLocalizedName() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">إكمال الملف الشخصي</label>
                    <select name="profile_completed" class="filter-select">
                        <option value="">جميع المستخدمين</option>
                        <option value="completed" {{ request('profile_completed') === 'completed' ? 'selected' : '' }}>مكتمل</option>
                        <option value="incomplete" {{ request('profile_completed') === 'incomplete' ? 'selected' : '' }}>غير مكتمل</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">من تاريخ</label>
                    <input type="date" name="date_from" class="filter-input" value="{{ request('date_from') }}">
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">إلى تاريخ</label>
                    <input type="date" name="date_to" class="filter-input" value="{{ request('date_to') }}">
                </div>
            </div>
            
            <div class="filters-actions">
                <button type="submit" class="btn-filter">
                    <i class="fa fa-search"></i>
                    تطبيق الفلاتر
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn-clear">
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

    <!-- Users Table -->
    <div class="users-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>المستخدم</th>
                        <th>الحالة</th>
                        <th>الاشتراك</th>
                        <th>المعلومات الأكاديمية</th>
                        <th>تاريخ التسجيل</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="user-info">
                                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/images/dashboard/avatar.png') }}" 
                                     alt="User Avatar" class="user-avatar">
                                <div class="user-details">
                                    <h6 class="user-name">{{ $user->first_name }} {{ $user->last_name }}</h6>
                                    <p class="user-phone">{{ $user->phone }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $user->is_active ? 'نشط' : 'معطل' }}
                                </span>
                                <span class="status-badge {{ $user->is_verified ? 'status-verified' : 'status-unverified' }}">
                                    {{ $user->is_verified ? 'مؤكد' : 'غير مؤكد' }}
                                </span>
                            </div>
                        </td>
                        <td>
                            @if($user->active_subscriptions_count > 0)
                                <div class="subscription-badge">
                                    <i class="fa fa-star"></i>
                                    مشترك
                                    <span class="subscription-count">{{ $user->active_subscriptions_count }}</span>
                                </div>
                            @else
                                <span class="text-muted">غير مشترك</span>
                            @endif
                        </td>
                        <td>
                            <div class="academic-info">
                                <span class="academic-level">{{ $user->academic_level?->getLocalizedName() ?? 'غير محدد' }}</span>
                                @if($user->university)
                                    <span class="academic-details">{{ $user->university->name }}</span>
                                    @if($user->college)
                                        <span class="academic-details">{{ $user->college->name }}</span>
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td>{{ $user->created_at->format('Y/m/d') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn-view" title="عرض التفاصيل">
                                    <i class="fa fa-eye"></i>
                                    عرض
                                </a>
                                <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-toggle" title="{{ $user->is_active ? 'إيقاف' : 'تفعيل' }}">
                                        <i class="fa fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                        {{ $user->is_active ? 'إيقاف' : 'تفعيل' }}
                                    </button>
                                </form>
                                <button type="button" class="btn-delete" onclick="deleteUser({{ $user->id }})" title="حذف">
                                    <i class="fa fa-trash"></i>
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fa fa-users"></i>
                                <h4>لا يوجد مستخدمين</h4>
                                <p>لم يتم العثور على مستخدمين مطابقين للفلاتر المحددة</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom Pagination -->
    @if($users->hasPages())
    <div class="pagination-container">
        <ul class="custom-pagination">
            {{-- Previous Page Link --}}
            @if ($users->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">السابق</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">السابق</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                @if ($page == $users->currentPage())
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
            @if ($users->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">التالي</a>
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
function deleteUser(id) {
    if (confirm('هل أنت متأكد من حذف هذا المستخدم؟')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('admin.users.destroy', '') }}/${id}`;
        
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
