@extends('Admin.layout')

@section('styles')
<style>
    body, .container {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%) !important;
    }
    
    .dashboard-container {
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
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.35);
    }
    
    .stats-title {
        color: #94a3b8;
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    
    .stats-value {
        color: #fff;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stats-icon {
        font-size: 2.5rem;
        opacity: 0.8;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover .stats-icon {
        transform: scale(1.1);
        opacity: 1;
    }
    
    .icon-users { color: #38bdf8; }
    .icon-admins { color: #8b5cf6; }
    .icon-code { color: #10b981; }
    .icon-delegates { color: #f43f5e; }
    .icon-stores { color: #f59e0b; }
    .icon-orders { color: #ec4899; }
    
    .chart-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 2rem;
        border: none;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .chart-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }
    
    .chart-badge {
        background: rgba(56,189,248,0.1);
        color: #38bdf8;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem 0;
        }
        
        .stats-card {
            margin-bottom: 1rem;
        }
        
        .stats-value {
            font-size: 2rem;
        }
        
        .stats-icon {
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('main')
<div class="dashboard-container" dir="rtl">
    <div class="row g-4">
        <!-- Users Stats Card -->
        {{-- <div class="col-sm-4">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="stats-title">{{ __('admin.users') }}</h3>
                        <div class="stats-value">{{ $users }}</div>
                    </div>
                    <div class="stats-icon icon-users">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admins Stats Card -->
        <div class="col-sm-4">
            <a href="{{ route('super.admins.index') }}" style="text-decoration:none;">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="stats-title">{{ __('admin.admins') }}</h3>
                        <div class="stats-value">{{ $admins }}</div>
                    </div>
                    <div class="stats-icon icon-admins">
                        <i class="fa fa-user-shield"></i>
                    </div>
                </div>
            </div>
            </a>
        </div>

        <!-- Code Stats Card -->
        <div class="col-sm-4">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="stats-title">{{ __('admin.code') }}</h3>
                        <div class="stats-value">{{ $code }}</div>
                    </div>
                    <div class="stats-icon icon-code">
                        <i class="fa fa-key"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delegates Stats Card -->
        <div class="col-sm-4">
            <a href="{{ route('super.delegates.index') }}" style="text-decoration:none;">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="stats-title">{{ __('admin.delegates') }}</h3>
                        <div class="stats-value">{{ $delegates }}</div>
                    </div>
                    <div class="stats-icon icon-delegates">
                        <i class="fa fa-motorcycle"></i>
                    </div>
                </div>
            </div>
            </a>
        </div>

        <!-- Stores Stats Card -->
        <div class="col-sm-4">
            <a href="{{ route('super.stores.index') }}" style="text-decoration:none;">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="stats-title">{{ __('admin.stores') }}</h3>
                        <div class="stats-value">{{ $stores }}</div>
                    </div>
                    <div class="stats-icon icon-stores">
                        <i class="fa fa-store"></i>
                    </div>
                </div>
            </div>
            </a>
        </div>

        <!-- Orders Stats Card -->
        <div class="col-sm-4">
            <a href="{{ route('super.orders.index') }}" style="text-decoration:none;">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="stats-title">{{ __('admin.orders') }}</h3>
                        <div class="stats-value">{{ $orders }}</div>
                    </div>
                    <div class="stats-icon icon-orders">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
            </a>
        </div>

        <!-- Chart Section -->
        <div class="col-12">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">{{ __('admin.new_users') }}</h3>
                    <span class="chart-badge">{{ __('admin.last_week') }}</span>
                </div>
                <div id="newUsersChart"></div>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const last7Days = @json(array_keys($last7DaysUsers->toArray()));
                        const dailyUsers = @json(array_values($last7DaysUsers->toArray()));

                        new ApexCharts(document.querySelector("#newUsersChart"), {
                            series: [{ 
                                name: 'New Users', 
                                data: dailyUsers 
                            }],
                            chart: { 
                                height: 350, 
                                type: 'area', 
                                toolbar: { show: false },
                                fontFamily: 'inherit',
                                background: 'transparent'
                            },
                            markers: { 
                                size: 4,
                                colors: ['#4361ee'],
                                strokeColors: '#fff',
                                strokeWidth: 2,
                                hover: {
                                    size: 6
                                }
                            },
                            colors: ['#4361ee'],
                            fill: {
                                type: "gradient",
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.7,
                                    opacityTo: 0.3,
                                    stops: [0, 90, 100]
                                }
                            },
                            dataLabels: { enabled: false },
                            stroke: { 
                                curve: 'smooth', 
                                width: 3 
                            },
                            xaxis: { 
                                type: 'datetime', 
                                categories: last7Days,
                                labels: {
                                    style: {
                                        colors: '#94a3b8',
                                        fontSize: '12px'
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    formatter: function (val) { 
                                        return Math.round(val) + " مستخدم"; 
                                    },
                                    style: {
                                        colors: '#94a3b8',
                                        fontSize: '12px'
                                    }
                                },
                                min: 0,
                                forceNiceScale: true
                            },
                            grid: {
                                borderColor: 'rgba(255,255,255,0.1)',
                                strokeDashArray: 4,
                                xaxis: {
                                    lines: {
                                        show: true
                                    }
                                }
                            },
                            tooltip: {
                                x: { format: 'dd/MM/yy' },
                                theme: 'dark',
                                style: {
                                    fontSize: '12px',
                                    fontFamily: 'inherit'
                                }
                            }
                        }).render();
                    });
                </script>
            </div>
        </div> --}}
    </div>
</div>
@endsection
