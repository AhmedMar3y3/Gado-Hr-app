@extends('Super.layout')

@section('styles')
<style>
    .report-container {
        padding: 2rem 0;
    }
    .stats-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        height: 100%;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        margin-bottom: 1rem;
    }
    .stats-title {
        color: #94a3b8;
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    .stats-value {
        color: #fff;
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .stats-icon {
        font-size: 2.2rem;
        opacity: 0.8;
        margin-left: 1rem;
    }
    .store-info-card {
        background: #1E293B;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        color: #fff;
        display: flex;
        align-items: center;
    }
    .store-info-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-left: 1.5rem;
        border: 3px solid #38bdf8;
    }
    .top-products-table th, .top-products-table td {
        color: #fff;
        background: #1E293B;
    }
    .filter-row {
        margin-bottom: 2rem;
        background: #1E293B;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.10);
    }
    .loading-spinner {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
    }
</style>
@endsection

@section('main')
<div class="report-container" dir="rtl">
    <form id="reportForm" class="filter-row row align-items-end" method="POST" action="{{ route('super.reports.data') }}">
        @csrf
        <div class="col-md-4">
            <label for="store_id" class="form-label">المتجر</label>
            <select class="form-select" id="store_id" name="store_id" required>
                <option value="">اختر المتجر</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="from_date" class="form-label">من تاريخ</label>
            <input type="date" class="form-control" id="from_date" name="from_date">
        </div>
        <div class="col-md-3">
            <label for="to_date" class="form-label">إلى تاريخ</label>
            <input type="date" class="form-control" id="to_date" name="to_date">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100" id="filterBtn"><i class="fa fa-search"></i> عرض التقرير</button>
        </div>
    </form>
    <div id="report-content">
        <div class="text-center text-secondary mt-5">يرجى اختيار متجر لعرض التقرير</div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function renderReport(data) {
    let store = data.store;
    let html = '';
    html += `<div class='store-info-card mb-4'>
        <img src="${store.image ? store.image : '/public/assets/images/store-default.png'}" class="store-info-img" alt="صورة المتجر">
        <div>
            <h4>${store.name} <span class="badge bg-${store.is_active ? 'success' : 'danger'} ms-2">${store.is_active ? 'نشط' : 'غير نشط'}</span></h4>
            <div>التصنيف: <span class="badge bg-info">${store.category}</span></div>
            <div>التقييم: <span class="badge bg-warning text-dark">${store.rating ?? 0} (${store.number_of_ratings} تقييم)</span></div>
            <div>الحالة: <span class="badge bg-${store.is_open ? 'success' : 'danger'}">${store.is_open ? 'مفتوح' : 'مغلق'}</span></div>
        </div>
    </div>`;
    html += `<div class="row g-4 mb-4">
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">إجمالي الطلبات</div><div class="stats-value"><i class="fa fa-list stats-icon"></i> ${data.total_orders}</div></div></div>
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">الطلبات المكتملة</div><div class="stats-value"><i class="fa fa-check-circle stats-icon"></i> ${data.completed_orders}</div></div></div>
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">إجمالي الإيرادات</div><div class="stats-value"><i class="fa fa-money-bill-wave stats-icon"></i> ${data.total_revenue} ج.م</div></div></div>
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">متوسط قيمة الطلب</div><div class="stats-value"><i class="fa fa-chart-line stats-icon"></i> ${data.avg_order_value} ج.م</div></div></div>
    </div>`;
    html += `<div class="row g-4 mb-4">
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">طلبات قيد التحضير</div><div class="stats-value"><i class="fa fa-hourglass-half stats-icon"></i> ${data.preparing_orders}</div></div></div>
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">طلبات بانتظار مندوب</div><div class="stats-value"><i class="fa fa-clock stats-icon"></i> ${data.waiting_orders}</div></div></div>
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">طلبات قيد التوصيل</div><div class="stats-value"><i class="fa fa-shipping-fast stats-icon"></i> ${data.shipping_orders}</div></div></div>
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">العملاء الفريدون</div><div class="stats-value"><i class="fa fa-user-friends stats-icon"></i> ${data.unique_customers}</div></div></div>
    </div>`;
    html += `<div class="row g-4 mb-4">
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">الطلبات المدفوعة</div><div class="stats-value"><i class="fa fa-credit-card stats-icon"></i> ${data.paid_orders}</div></div></div>
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">الطلبات غير المدفوعة</div><div class="stats-value"><i class="fa fa-times-circle stats-icon"></i> ${data.unpaid_orders}</div></div></div>
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">إيرادات نقدية</div><div class="stats-value"><i class="fa fa-money-bill stats-icon"></i> ${data.revenue_cash} ج.م</div></div></div>
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">إيرادات أونلاين</div><div class="stats-value"><i class="fa fa-globe stats-icon"></i> ${data.revenue_online} ج.م</div></div></div>
    </div>`;
    html += `<div class="row g-4 mb-4">
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">عدد المنتجات المباعة</div><div class="stats-value"><i class="fa fa-boxes stats-icon"></i> ${data.total_products_sold}</div></div></div>
        <div class="col-md-3"><div class="stats-card"><div class="stats-title">عدد التقييمات</div><div class="stats-value"><i class="fa fa-star stats-icon"></i> ${data.number_of_reviews}</div></div></div>
    </div>`;
    // Enhanced Top products table
    html += `<div class="card chart-card mb-4">
        <div class="chart-header" style="color: #fff; background: #1E293B; padding: 1rem; border-radius: 12px;">
            <span class="chart-title"><i class="fa fa-crown"></i> أفضل المنتجات مبيعاً</span>
        </div>
        <div class="table-responsive">
            <table class="table top-products-table align-middle">
                <thead>
                    <tr>
                        <th style='width:50px'></th>
                        <th>المنتج</th>
                        <th>الكمية المباعة</th>
                    </tr>
                </thead>
                <tbody>`;
    if(data.top_products.length > 0) {
        data.top_products.forEach(function(prod, idx) {
            html += `<tr>
                <td class='text-center'>
                    <span class="badge bg-${idx === 0 ? 'warning text-darkhttp://otlobny.test/super/reports/data' : idx === 1 ? 'secondary' : 'info'}" style="font-size:1.2rem;"><i class="fa fa-trophy"></i></span>
                </td>
                <td><span class="fw-bold">${prod.name}</span></td>
                <td><span class="badge bg-success" style="font-size:1rem;">${prod.quantity}</span></td>
            </tr>`;
        });
    } else {
        html += `<tr><td colspan='3' class='text-center'>لا يوجد بيانات</td></tr>`;
    }
    html += `</tbody></table></div></div>`;
    return html;
}

document.getElementById('reportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    document.getElementById('report-content').innerHTML = '<div class="loading-spinner"><div class="spinner-border text-info" role="status"><span class="visually-hidden">جاري التحميل...</span></div></div>';
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': formData.get('_token')
        },
        body: formData
    })
    .then(async response => {
        try {
            const data = await response.json();
            document.getElementById('report-content').innerHTML = renderReport(data);
        } catch (e) {
            const text = await response.text();
            document.getElementById('report-content').innerHTML = '<pre>' + text + '</pre>';
        }
    })
    .catch(() => {
        document.getElementById('report-content').innerHTML = '<div class="text-center text-danger mt-5">حدث خطأ أثناء جلب البيانات</div>';
    });
});
</script>
@endsection