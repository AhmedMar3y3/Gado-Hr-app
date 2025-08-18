@extends('Admin.layout')

@section('styles')
<style>
    .banners-container {
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
    
    /* Banners Table */
    .banners-table {
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
    
    .banner-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .banner-image {
        width: 80px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
        background: rgba(255,255,255,0.1);
        border: 2px solid rgba(255,255,255,0.1);
    }
    
    .banner-details h6 {
        color: #fff;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
    }
    
    .banner-details p {
        color: #94a3b8;
        margin: 0;
        font-size: 0.85rem;
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
    
    /* Modal Styles */
    .modal-content {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 15px;
    }
    
    .modal-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 1.5rem;
    }
    
    .modal-title {
        color: #fff;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .modal-body {
        padding: 1.5rem;
        color: #fff;
    }
    
    .modal-footer {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding: 1.5rem;
    }
    
    .btn-close {
        filter: invert(1);
    }
    
    .form-label {
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-control {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: #fff;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
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
    
    /* Image Upload Styles */
    .image-upload-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 1rem 0;
    }
    
    .image-upload-square {
        width: 200px;
        height: 150px;
        border: 2px dashed rgba(255,255,255,0.3);
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .image-upload-square:hover {
        border-color: #38bdf8;
        background: rgba(56, 189, 248, 0.1);
    }
    
    .image-upload-square img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .image-upload-square .upload-icon {
        font-size: 2rem;
        color: #94a3b8;
        transition: all 0.3s ease;
    }
    
    .image-upload-square:hover .upload-icon {
        color: #38bdf8;
    }
    
    .image-upload-square .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(239, 68, 68, 0.9);
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .image-upload-square .remove-btn:hover {
        background: rgba(239, 68, 68, 1);
        transform: scale(1.1);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .banner-info {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection

@section('main')
<div class="banners-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">إدارة البانرات</h1>
                <p class="page-subtitle">إدارة البانرات الإعلانية للموقع</p>
            </div>
            <div class="col-md-6 text-md-end">
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#createBannerModal">
                    <i class="fa fa-plus"></i>
                    إضافة بانر جديد
                </button>
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

    <!-- Banners Table -->
    <div class="banners-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>البانر</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr>
                        <td>
                            <div class="banner-info">
                                <div class="banner-details">
                                    <h6>{{ $banner->title }}</h6>
                                    <p>ID: {{ $banner->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $banner->created_at->format('Y/m/d H:i') }}</td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" class="btn-view" data-bs-toggle="modal" data-bs-target="#showBannerModal{{ $banner->id }}" title="عرض التفاصيل">
                                    <i class="fa fa-eye"></i>
                                    عرض
                                </button>
                                <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editBannerModal{{ $banner->id }}" title="تعديل">
                                    <i class="fa fa-edit"></i>
                                    تعديل
                                </button>
                                <button type="button" class="btn-delete" onclick="deleteBanner({{ $banner->id }})" title="حذف">
                                    <i class="fa fa-trash"></i>
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Show Banner Modal -->
                    <div class="modal fade" id="showBannerModal{{ $banner->id }}" tabindex="-1" aria-labelledby="showBannerModalLabel{{ $banner->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showBannerModalLabel{{ $banner->id }}">
                                        <i class="fa fa-image"></i>
                                        تفاصيل البانر
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            <img src="{{ asset('/images/banner/' . basename($banner->image)) }}" alt="Image" style="width: 200px;" class="img-fluid rounded" style="max-width: 100%; max-height: 300px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="fa fa-tag"></i>
                                                    العنوان
                                                </label>
                                                <p class="text-white">{{ $banner->title }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="fa fa-calendar"></i>
                                                    تاريخ الإنشاء
                                                </label>
                                                <p class="text-white">{{ $banner->created_at->format('Y/m/d H:i') }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="fa fa-clock"></i>
                                                    آخر تحديث
                                                </label>
                                                <p class="text-white">{{ $banner->updated_at->format('Y/m/d H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Banner Modal -->
                    <div class="modal fade" id="editBannerModal{{ $banner->id }}" tabindex="-1" aria-labelledby="editBannerModalLabel{{ $banner->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editBannerModalLabel{{ $banner->id }}">
                                            <i class="fa fa-edit"></i>
                                            تعديل البانر
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="editBannerTitle{{ $banner->id }}" class="form-label">
                                                <i class="fa fa-tag"></i>
                                                العنوان
                                            </label>
                                            <input type="text" name="title" class="form-control" id="editBannerTitle{{ $banner->id }}" value="{{ $banner->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <i class="fa fa-image"></i>
                                                الصورة
                                            </label>
                                            <div class="image-upload-container">
                                                <div id="imageContainerEdit{{ $banner->id }}" class="image-upload-square" onclick="document.getElementById('imageEdit{{ $banner->id }}').click()">
                                                    @if($banner->image)
                                                <img src="{{ asset('/images/banner/' . basename($banner->image)) }}" alt="Image" style="width: 200px;">
                                                        <button type="button" class="remove-btn" onclick="removeImage('imageContainerEdit{{ $banner->id }}', 'imageEdit{{ $banner->id }}')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    @else
                                                        <i class="fa fa-cloud-upload-alt upload-icon"></i>
                                                    @endif
                                                </div>
                                            </div>
                                            <input type="file" id="imageEdit{{ $banner->id }}" name="image" class="form-control d-none" accept="image/*" onchange="previewImage(this, 'imageContainerEdit{{ $banner->id }}')">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="fa fa-images"></i>
                                <h4>لا توجد بانرات</h4>
                                <p>لم يتم إضافة أي بانرات بعد</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Banner Modal -->
<div class="modal fade" id="createBannerModal" tabindex="-1" aria-labelledby="createBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createBannerModalLabel">
                        <i class="fa fa-plus"></i>
                        إضافة بانر جديد
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bannerTitle" class="form-label">
                            <i class="fa fa-tag"></i>
                            العنوان
                        </label>
                        <input type="text" name="title" class="form-control" id="bannerTitle" placeholder="أدخل عنوان البانر" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fa fa-image"></i>
                            الصورة
                        </label>
                        <div class="image-upload-container">
                            <div id="imageContainerCreate" class="image-upload-square" onclick="document.getElementById('imageCreate').click()">
                                <i class="fa fa-cloud-upload-alt upload-icon"></i>
                            </div>
                        </div>
                        <input type="file" id="imageCreate" name="image" class="form-control d-none" accept="image/*" required onchange="previewImage(this, 'imageContainerCreate')">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function deleteBanner(id) {
    if (confirm('هل أنت متأكد من حذف هذا البانر؟')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('admin.banners.destroy', '') }}/${id}`;
        
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

function previewImage(input, containerId) {
    const container = document.getElementById(containerId);
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            container.innerHTML = `
                <img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                <button type="button" class="remove-btn" onclick="removeImage('${containerId}', '${input.id}')">
                    <i class="fa fa-times"></i>
                </button>
            `;
        };
        reader.readAsDataURL(file);
    }
}

function removeImage(containerId, inputId) {
    const container = document.getElementById(containerId);
    const input = document.getElementById(inputId);
    
    container.innerHTML = '<i class="fa fa-cloud-upload-alt upload-icon"></i>';
    input.value = '';
}
</script>
@endsection