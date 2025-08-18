@extends('Super.layout')

@section('styles')
    <style>
        body,
        .container {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%) !important;
        }

        .page-container {
            padding: 2rem 0;
        }

        .page-header {
            color: #fff;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            animation: slideIn 0.3s ease-out;
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
        }

        .alert-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #fff;
        }

        .btn-add-admin {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .btn-add-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .table-container {
            background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
        }

        .table {
            color: #fff;
            margin-bottom: 0;
        }

        .table thead th {
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            font-weight: 500;
            padding: 1rem;
        }

        .table tbody td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem;
            vertical-align: middle;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-action {
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-left: 0.5rem;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #fff;
            border: none;
        }

        .btn-delete:hover {
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .modal-content {
            background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
            border: none;
            border-radius: 15px;
            color: #fff;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            position: relative;
        }

        .modal-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.5), transparent);
        }

        .modal-title {
            color: #fff;
            font-weight: 600;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-title i {
            color: #3b82f6;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            position: relative;
        }

        .modal-footer::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.5), transparent);
        }

        .form-label {
            color: #94a3b8;
            font-weight: 500;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: #3b82f6;
            font-size: 0.9rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #fff;
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(148, 163, 184, 0.7);
        }

        .text-danger {
            color: #ef4444 !important;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .text-danger::before {
            content: '!';
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            background: #ef4444;
            color: #fff;
            border-radius: 50%;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .btn-modal {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-modal-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #fff;
        }

        .btn-modal-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-modal-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #94a3b8;
        }

        .btn-modal-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .form-floating {
            position: relative;
        }

        .form-floating .form-control {
            height: calc(3.5rem + 2px);
            padding: 1rem 0.75rem;
        }

        .form-floating label {
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            padding: 1rem 0.75rem;
            pointer-events: none;
            border: 1px solid transparent;
            transform-origin: 100% 0;
            transition: opacity .1s ease-in-out, transform .1s ease-in-out;
        }

        .form-floating .form-control:focus~label,
        .form-floating .form-control:not(:placeholder-shown)~label {
            opacity: .65;
            transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
        }

        .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .list-group-item {
            background: transparent;
            border-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 1rem 0;
        }

        .list-group-item strong {
            color: #94a3b8;
            margin-left: 0.5rem;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .page-container {
                padding: 1rem 0;
            }

            .page-header {
                font-size: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .table-container {
                padding: 1rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.75rem;
            }
        }
    </style>
@endsection

@section('main')
    <div class="page-container" dir="rtl">
        <h2 class="page-header">جميع مديري المناطق</h2>

        <!-- Success/Error Messages -->
        @if (Session::has('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ Session::get('error') }}
            </div>
        @endif

        <!-- Create Admin Button -->
        <button class="btn btn-add-admin" data-bs-toggle="modal" data-bs-target="#createAdminModal">
            <i class="fas fa-plus me-2"></i>
            إضافة مدير جديد
        </button>

        <!-- Admins Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>الإجراءات</th>
                        <th>الواتساب</th>
                        <th>المنطقة</th>
                        <th>البريد الإلكتروني</th>
                        <th>الاسم</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $admin)
                        <tr>
                            <td>
                                <button type="button" class="btn btn-action btn-view" data-bs-toggle="modal"
                                    data-bs-target="#editAdminModal-{{ $admin->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-action btn-password" data-bs-toggle="modal"
                                    data-bs-target="#changePasswordModal-{{ $admin->id }}">
                                    <i class="fas fa-key"></i>
                                </button>
                                <form action="{{ route('super.admins.destroy', $admin->id) }}" method="POST"
                                    onsubmit="return confirm('هل أنت متأكد؟');" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-action btn-delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @if($admin->whatsapp)
                                    <a href="https://wa.me/{{ $admin->whatsapp }}" target="_blank" class="btn btn-action"
                                        style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: #fff; border: none;">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                @endif
                            </td>
                            <td>{{ $admin->whatsapp ?? '-' }}</td>
                            <td>{{ $admin->area }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->id }}</td>
                        </tr>
                        <!-- Edit Admin Modal -->
                        <div class="modal fade" id="editAdminModal-{{ $admin->id }}" tabindex="-1"
                            aria-labelledby="editAdminModalLabel-{{ $admin->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('super.admins.update', $admin->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editAdminModalLabel-{{ $admin->id }}">
                                                <i class="fas fa-user-edit"></i>
                                                تعديل بيانات المسؤول
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Name -->
                                            <div class="mb-4">
                                                <label for="edit-name-{{ $admin->id }}" class="form-label">
                                                    <i class="fas fa-user"></i>
                                                    الاسم
                                                </label>
                                                <input type="text" name="name" id="edit-name-{{ $admin->id }}"
                                                    class="form-control" value="{{ old('name', $admin->name) }}" required>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <!-- Email -->
                                            <div class="mb-4">
                                                <label for="edit-email-{{ $admin->id }}" class="form-label">
                                                    <i class="fas fa-envelope"></i>
                                                    البريد الإلكتروني
                                                </label>
                                                <input type="email" name="email" id="edit-email-{{ $admin->id }}"
                                                    class="form-control" value="{{ old('email', $admin->email) }}" required>
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <!-- Area -->
                                            <div class="mb-4">
                                                <label for="edit-area-{{ $admin->id }}" class="form-label">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    المنطقة
                                                </label>
                                                <input type="text" name="area" id="edit-area-{{ $admin->id }}"
                                                    class="form-control" value="{{ old('area', $admin->area) }}" required>
                                                @error('area')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <!-- WhatsApp -->
                                            <div class="mb-4">
                                                <label for="edit-whatsapp-{{ $admin->id }}" class="form-label">
                                                    <i class="fab fa-whatsapp"></i>
                                                    رقم الواتساب
                                                </label>
                                                <input type="text" name="whatsapp" id="edit-whatsapp-{{ $admin->id }}"
                                                    class="form-control" value="{{ old('whatsapp', $admin->whatsapp) }}"
                                                    placeholder="مثال: 9665XXXXXXXX" required>
                                                @error('whatsapp')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-modal btn-modal-secondary"
                                                data-bs-dismiss="modal">إلغاء</button>
                                            <button type="submit" class="btn btn-modal btn-modal-primary">
                                                <i class="fas fa-save me-2"></i>
                                                حفظ التعديلات
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Change Password Modal -->
                        <div class="modal fade" id="changePasswordModal-{{ $admin->id }}" tabindex="-1"
                            aria-labelledby="changePasswordModalLabel-{{ $admin->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('super.admins.changePassword', $admin->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="changePasswordModalLabel-{{ $admin->id }}">
                                                <i class="fas fa-key"></i>
                                                تغيير كلمة المرور
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-4">
                                                <label for="new-password-{{ $admin->id }}" class="form-label">
                                                    <i class="fas fa-lock"></i>
                                                    كلمة المرور الجديدة
                                                </label>
                                                <input type="password" name="password" id="new-password-{{ $admin->id }}" class="form-control" placeholder="أدخل كلمة المرور الجديدة" required>
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-modal btn-modal-secondary" data-bs-dismiss="modal">إلغاء</button>
                                            <button type="submit" class="btn btn-modal btn-modal-primary">
                                                <i class="fas fa-save me-2"></i>
                                                حفظ كلمة المرور
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">لا توجد مسؤولين متاحين.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Create Admin Modal -->
        <div class="modal fade" id="createAdminModal" tabindex="-1" aria-labelledby="createAdminModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('super.admins.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createAdminModalLabel">
                                <i class="fas fa-user-shield"></i>
                                إضافة مسؤول جديد
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i>
                                    الاسم
                                </label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                    placeholder="أدخل اسم المسؤول" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    البريد الإلكتروني
                                </label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                                    placeholder="أدخل البريد الإلكتروني" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i>
                                    كلمة المرور
                                </label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="أدخل كلمة المرور" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Area -->
                            <div class="mb-4">
                                <label for="area" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    المنطقة
                                </label>
                                <input type="text" name="area" id="area" class="form-control" value="{{ old('area') }}"
                                    placeholder="أدخل المنطقة" required>
                                @error('area')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- WhatsApp -->
                            <div class="mb-4">
                                <label for="whatsapp" class="form-label">
                                    <i class="fab fa-whatsapp"></i>
                                    رقم الواتساب
                                </label>
                                <input type="text" name="whatsapp" id="whatsapp" class="form-control"
                                    value="{{ old('whatsapp') }}" placeholder="مثال: 9665XXXXXXXX" required>
                                @error('whatsapp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-modal btn-modal-secondary"
                                data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-modal btn-modal-primary">
                                <i class="fas fa-save me-2"></i>
                                حفظ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection