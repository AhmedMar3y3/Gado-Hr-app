@extends('Admin.layout')

@section('styles')
<style>
    .settings-container {
        padding: 2rem 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        text-align: center;
    }
    
    .page-title {
        color: #fff;
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }
    
    .page-subtitle {
        color: #94a3b8;
        font-size: 1.1rem;
        margin: 0;
    }
    
    /* Alert Styles */
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        animation: slideIn 0.3s ease-out;
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
    
    /* Settings Cards */
    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }
    
    .settings-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }
    
    .settings-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    }
    
    .card-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        position: relative;
    }
    
    .card-header::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(56, 189, 248, 0.5), transparent);
    }
    
    .card-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
    }
    
    .card-title i {
        color: #38bdf8;
        font-size: 1.2rem;
    }
    
    .card-subtitle {
        color: #94a3b8;
        font-size: 0.9rem;
        margin: 0.5rem 0 0 0;
    }
    
    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }
    
    .form-label i {
        color: #38bdf8;
        font-size: 0.9rem;
        width: 16px;
    }
    
    .form-control {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        color: #fff;
        padding: 0.875rem 1rem;
        transition: all 0.3s ease;
        font-size: 1rem;
        width: 100%;
    }
    
    .form-control:focus {
        background: rgba(255,255,255,0.08);
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
        color: #fff;
        outline: none;
    }
    
    .form-control::placeholder {
        color: rgba(148, 163, 184, 0.7);
    }
    
    .form-text {
        color: #94a3b8;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .form-text i {
        color: #38bdf8;
    }
    
    /* Social Media Icons */
    .social-icon {
        width: 20px;
        height: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        margin-right: 0.5rem;
        font-size: 0.8rem;
    }
    
    .social-linkedin { background: #0077b5; color: white; }
    .social-facebook { background: #1877f2; color: white; }
    .social-instagram { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: white; }
    .social-google { background: #4285f4; color: white; }
    .social-x { background: #000; color: white; }
    .social-telegram { background: #0088cc; color: white; }
    .social-phone { background: #10b981; color: white; }
    
    /* Button Styles */
    .btn-save {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
        cursor: pointer;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .btn-save:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    /* Loading State */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }
    
    .spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
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
    
    /* Responsive */
    @media (max-width: 768px) {
        .settings-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .settings-card {
            padding: 1.5rem;
        }
        
        .card-title {
            font-size: 1.3rem;
        }
    }
    
    /* Validation Styles */
    .is-invalid {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25) !important;
    }
    
    .invalid-feedback {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .invalid-feedback i {
        color: #ef4444;
    }
</style>
@endsection

@section('main')
<div class="settings-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">إعدادات الموقع</h1>
        <p class="page-subtitle">إدارة روابط التواصل الاجتماعي ومعلومات الاتصال</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm">
        @csrf
        @method('PUT')
        
        <div class="settings-grid">
            <!-- Social Media Settings -->
            <div class="settings-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fab fa-share-alt"></i>
                        روابط التواصل الاجتماعي
                    </h3>
                    <p class="card-subtitle">إدارة روابط حسابات التواصل الاجتماعي الرسمية</p>
                </div>

                <div class="form-group">
                    <label for="linkedIn" class="form-label">
                        <i class="fab fa-linkedin"></i>
                        LinkedIn
                    </label>
                    <input type="url" 
                           class="form-control @error('linkedIn') is-invalid @enderror" 
                           id="linkedIn" 
                           name="linkedIn" 
                           value="{{ $data['linkedIn'] ?? '' }}" 
                           placeholder="https://linkedin.com/company/your-company"
                           required>
                    @error('linkedIn')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i>
                        رابط صفحة LinkedIn الرسمية للشركة
                    </div>
                </div>

                <div class="form-group">
                    <label for="facebook" class="form-label">
                        <i class="fab fa-facebook"></i>
                        Facebook
                    </label>
                    <input type="url" 
                           class="form-control @error('facebook') is-invalid @enderror" 
                           id="facebook" 
                           name="facebook" 
                           value="{{ $data['facebook'] ?? '' }}" 
                           placeholder="https://facebook.com/your-page"
                           required>
                    @error('facebook')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i>
                        رابط صفحة Facebook الرسمية
                    </div>
                </div>

                <div class="form-group">
                    <label for="instagram" class="form-label">
                        <i class="fab fa-instagram"></i>
                        Instagram
                    </label>
                    <input type="url" 
                           class="form-control @error('instagram') is-invalid @enderror" 
                           id="instagram" 
                           name="instagram" 
                           value="{{ $data['instagram'] ?? '' }}" 
                           placeholder="https://instagram.com/your-account"
                           required>
                    @error('instagram')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i>
                        رابط حساب Instagram الرسمي
                    </div>
                </div>

                <div class="form-group">
                    <label for="google" class="form-label">
                        <i class="fab fa-google"></i>
                        Google+
                    </label>
                    <input type="url" 
                           class="form-control @error('google') is-invalid @enderror" 
                           id="google" 
                           name="google" 
                           value="{{ $data['google'] ?? '' }}" 
                           placeholder="https://plus.google.com/your-page"
                           required>
                    @error('google')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i>
                        رابط صفحة Google+ الرسمية
                    </div>
                </div>

                <div class="form-group">
                    <label for="x" class="form-label">
                        <i class="fab fa-x-twitter"></i>
                        X (Twitter)
                    </label>
                    <input type="url" 
                           class="form-control @error('x') is-invalid @enderror" 
                           id="x" 
                           name="x" 
                           value="{{ $data['x'] ?? '' }}" 
                           placeholder="https://x.com/your-account"
                           required>
                    @error('x')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i>
                        رابط حساب X (Twitter) الرسمي
                    </div>
                </div>

                <div class="form-group">
                    <label for="telegram" class="form-label">
                        <i class="fab fa-telegram"></i>
                        Telegram
                    </label>
                    <input type="url" 
                           class="form-control @error('telegram') is-invalid @enderror" 
                           id="telegram" 
                           name="telegram" 
                           value="{{ $data['telegram'] ?? '' }}" 
                           placeholder="https://t.me/your-channel"
                           required>
                    @error('telegram')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i>
                        رابط قناة Telegram الرسمية
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="settings-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-phone"></i>
                        معلومات الاتصال
                    </h3>
                    <p class="card-subtitle">إدارة معلومات الاتصال الأساسية</p>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone-alt"></i>
                        رقم الهاتف
                    </label>
                    <input type="tel" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" 
                           name="phone" 
                           value="{{ $data['phone'] ?? '' }}" 
                           placeholder="+966501234567"
                           required>
                    @error('phone')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i>
                        رقم الهاتف الرسمي مع رمز الدولة
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="card-header" style="margin-top: 2rem;">
                    <h3 class="card-title">
                        <i class="fas fa-eye"></i>
                        معاينة الروابط
                    </h3>
                    <p class="card-subtitle">كيف ستظهر الروابط للمستخدمين</p>
                </div>

                <div class="social-preview">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fab fa-linkedin social-icon social-linkedin"></i>
                            LinkedIn
                        </label>
                        <div class="form-control" style="background: rgba(255,255,255,0.02); cursor: default;">
                            {{ $data['linkedIn'] ?? 'لم يتم تحديد الرابط' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fab fa-facebook social-icon social-facebook"></i>
                            Facebook
                        </label>
                        <div class="form-control" style="background: rgba(255,255,255,0.02); cursor: default;">
                            {{ $data['facebook'] ?? 'لم يتم تحديد الرابط' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fab fa-instagram social-icon social-instagram"></i>
                            Instagram
                        </label>
                        <div class="form-control" style="background: rgba(255,255,255,0.02); cursor: default;">
                            {{ $data['instagram'] ?? 'لم يتم تحديد الرابط' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fab fa-google social-icon social-google"></i>
                            Google+
                        </label>
                        <div class="form-control" style="background: rgba(255,255,255,0.02); cursor: default;">
                            {{ $data['google'] ?? 'لم يتم تحديد الرابط' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fab fa-x-twitter social-icon social-x"></i>
                            X (Twitter)
                        </label>
                        <div class="form-control" style="background: rgba(255,255,255,0.02); cursor: default;">
                            {{ $data['x'] ?? 'لم يتم تحديد الرابط' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fab fa-telegram social-icon social-telegram"></i>
                            Telegram
                        </label>
                        <div class="form-control" style="background: rgba(255,255,255,0.02); cursor: default;">
                            {{ $data['telegram'] ?? 'لم يتم تحديد الرابط' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-phone social-icon social-phone"></i>
                            رقم الهاتف
                        </label>
                        <div class="form-control" style="background: rgba(255,255,255,0.02); cursor: default;">
                            {{ $data['phone'] ?? 'لم يتم تحديد الرقم' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="text-center" style="margin-top: 2rem;">
            <button type="submit" class="btn-save" id="saveBtn">
                <i class="fas fa-save"></i>
                حفظ الإعدادات
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('settingsForm');
    const saveBtn = document.getElementById('saveBtn');
    
    // Form validation
    form.addEventListener('submit', function(e) {
        const inputs = form.querySelectorAll('input[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            return;
        }
        
        // Show loading state
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="spinner"></span> جاري الحفظ...';
        form.classList.add('loading');
    });
    
    // Real-time validation
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.hasAttribute('required') && this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
        
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            }
        });
    });
    
    // URL validation for social media links
    const urlInputs = form.querySelectorAll('input[type="url"]');
    urlInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value && !isValidUrl(this.value)) {
                this.classList.add('is-invalid');
                if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> يرجى إدخال رابط صحيح';
                    this.parentNode.appendChild(errorDiv);
                }
            } else {
                this.classList.remove('is-invalid');
                const errorDiv = this.parentNode.querySelector('.invalid-feedback');
                if (errorDiv) {
                    errorDiv.remove();
                }
            }
        });
    });
    
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
});
</script>
@endsection
