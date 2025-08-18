@extends('Admin.layout')

@section('styles')
<style>
    .user-details-container {
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
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }
    
    .back-btn:hover {
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .user-profile-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    
    .profile-header {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255,255,255,0.1);
    }
    
    .profile-info {
        flex: 1;
    }
    
    .profile-name {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }
    
    .profile-phone {
        color: #94a3b8;
        font-size: 1.1rem;
        margin: 0 0 1rem 0;
    }
    
    .profile-status {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
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
    
    .profile-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .btn-toggle {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
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
    
    .btn-toggle:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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
    
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .info-section {
        background: rgba(255,255,255,0.02);
        border-radius: 10px;
        padding: 1.5rem;
        border: 1px solid rgba(255,255,255,0.05);
    }
    
    .section-title {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .info-value {
        color: #fff;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .subscriptions-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    
    .subscriptions-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .subscriptions-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }
    
    .subscriptions-count {
        background: rgba(56, 189, 248, 0.1);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .subscriptions-table {
        background: rgba(255,255,255,0.02);
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.05);
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
        padding: 1rem;
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
        padding: 1rem;
        border: none;
        vertical-align: middle;
    }
    
    .subscription-type {
        background: rgba(139,92,246,0.1);
        color: #8b5cf6;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .subscription-status {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .subscription-active {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .subscription-inactive {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
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
    
    /* Responsive */
    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }
        
        .profile-actions {
            justify-content: center;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .subscriptions-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }
</style>
@endsection

@section('main')
<div class="user-details-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">تفاصيل المستخدم</h1>
                <p class="page-subtitle">عرض معلومات المستخدم والاشتراكات</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('admin.users.index') }}" class="back-btn">
                    <i class="fa fa-arrow-right"></i>
                    العودة للمستخدمين
                </a>
            </div>
        </div>
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

    <!-- User Profile Section -->
    <div class="user-profile-section">
        <div class="profile-header">
            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/images/dashboard/avatar.png') }}" 
                 alt="User Avatar" class="profile-avatar">
            <div class="profile-info">
                <h2 class="profile-name">{{ $user->first_name }} {{ $user->last_name }}</h2>
                <p class="profile-phone">{{ $user->phone }}</p>
                <div class="profile-status">
                    <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $user->is_active ? 'نشط' : 'معطل' }}
                    </span>
                    <span class="status-badge {{ $user->is_verified ? 'status-verified' : 'status-unverified' }}">
                        {{ $user->is_verified ? 'مؤكد' : 'غير مؤكد' }}
                    </span>
                    @if($user->is_academic_details_set)
                        <span class="status-badge status-active">الملف مكتمل</span>
                    @else
                        <span class="status-badge status-unverified">الملف غير مكتمل</span>
                    @endif
                </div>
            </div>
            <div class="profile-actions">
                <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-toggle">
                        <i class="fa fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                        {{ $user->is_active ? 'إيقاف' : 'تفعيل' }}
                    </button>
                </form>
                <button type="button" class="btn-delete" onclick="deleteUser({{ $user->id }})">
                    <i class="fa fa-trash"></i>
                    حذف المستخدم
                </button>
            </div>
        </div>

        <div class="info-grid">
            <!-- Personal Information -->
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fa fa-user"></i>
                    المعلومات الشخصية
                </h3>
                <div class="info-item">
                    <span class="info-label">الاسم الأول</span>
                    <span class="info-value">{{ $user->first_name ?? 'غير محدد' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">الاسم الأخير</span>
                    <span class="info-value">{{ $user->last_name ?? 'غير محدد' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">رقم الهاتف</span>
                    <span class="info-value">{{ $user->phone }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">الجنس</span>
                    <span class="info-value">{{ $user->gender?->getLocalizedName() ?? 'غير محدد' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">تاريخ التسجيل</span>
                    <span class="info-value">{{ $user->created_at->format('Y/m/d H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">آخر تحديث</span>
                    <span class="info-value">{{ $user->updated_at->format('Y/m/d H:i') }}</span>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fa fa-graduation-cap"></i>
                    المعلومات الأكاديمية
                </h3>
                <div class="info-item">
                    <span class="info-label">المستوى الأكاديمي</span>
                    <span class="info-value">{{ $user->academic_level?->getLocalizedName() ?? 'غير محدد' }}</span>
                </div>
                @if($user->university)
                <div class="info-item">
                    <span class="info-label">الجامعة</span>
                    <span class="info-value">{{ $user->university->name }}</span>
                </div>
                @endif
                @if($user->college)
                <div class="info-item">
                    <span class="info-label">الكلية</span>
                    <span class="info-value">{{ $user->college->name }}</span>
                </div>
                @endif
                @if($user->grade)
                <div class="info-item">
                    <span class="info-label">المرحلة</span>
                    <span class="info-value">{{ $user->grade->name }}</span>
                </div>
                @endif
                @if($user->secondary_type)
                <div class="info-item">
                    <span class="info-label">نوع المدرسة الثانوية</span>
                    <span class="info-value">{{ $user->secondary_type?->getLocalizedName() ?? 'غير محدد' }}</span>
                </div>
                @endif
                @if($user->secondary_grade)
                <div class="info-item">
                    <span class="info-label">الصف الثانوي</span>
                    <span class="info-value">{{ $user->secondary_grade?->getLocalizedName() ?? 'غير محدد' }}</span>
                </div>
                @endif
                @if($user->secondary_section)
                <div class="info-item">
                    <span class="info-label">القسم</span>
                    <span class="info-value">{{ $user->secondary_section?->getLocalizedName() ?? 'غير محدد' }}</span>
                </div>
                @endif
                @if($user->scientific_branch)
                <div class="info-item">
                    <span class="info-label">التخصص العلمي</span>
                    <span class="info-value">{{ $user->scientific_branch?->getLocalizedName() ?? 'غير محدد' }}</span>
                </div>
                @endif
            </div>

            <!-- Account Information -->
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fa fa-shield-alt"></i>
                    معلومات الحساب
                </h3>
                <div class="info-item">
                    <span class="info-label">حالة الحساب</span>
                    <span class="info-value">{{ $user->is_active ? 'نشط' : 'معطل' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">تأكيد الحساب</span>
                    <span class="info-value">{{ $user->is_verified ? 'مؤكد' : 'غير مؤكد' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">إكمال الملف الشخصي</span>
                    <span class="info-value">{{ $user->is_academic_details_set ? 'مكتمل' : 'غير مكتمل' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">عدد الاشتراكات</span>
                    <span class="info-value">{{ $user->subscriptions_count }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">الاشتراكات النشطة</span>
                    <span class="info-value">{{ $user->active_subscriptions_count }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">المفضلة</span>
                    <span class="info-value">{{ $user->favourites()->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscriptions Section -->
    <div class="subscriptions-section">
        <div class="subscriptions-header">
            <h3 class="subscriptions-title">الاشتراكات</h3>
            <span class="subscriptions-count">{{ $user->subscriptions_count }} اشتراك</span>
        </div>

        @if($user->subscriptions->count() > 0)
        <div class="subscriptions-table">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>نوع الاشتراك</th>
                            <th>العنوان</th>
                            <th>الحالة</th>
                            <th>تاريخ الاشتراك</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->subscriptions as $subscription)
                        <tr>
                            <td>
                                <span class="subscription-type">{{ $subscription->subscription_type }}</span>
                            </td>
                            <td>
                                @if($subscription->course)
                                    {{ $subscription->course->title }}
                                @elseif($subscription->book)
                                    {{ $subscription->book->title }}
                                @else
                                    غير محدد
                                @endif
                            </td>
                            <td>
                                <span class="subscription-status {{ $subscription->is_active ? 'subscription-active' : 'subscription-inactive' }}">
                                    {{ $subscription->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td>{{ $subscription->created_at->format('Y/m/d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="empty-state">
            <i class="fa fa-star"></i>
            <h4>لا توجد اشتراكات</h4>
            <p>هذا المستخدم ليس لديه أي اشتراكات حالياً</p>
        </div>
        @endif
    </div>
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
