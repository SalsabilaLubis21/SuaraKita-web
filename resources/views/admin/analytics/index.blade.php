@extends('layouts.app')

@section('title', 'Analytics Dashboard - Admin')

@section('content')
<!-- Admin Analytics Hero Section -->
<div class="admin-analytics-hero position-relative overflow-hidden mb-4">
    <div class="admin-hero-overlay"></div>
    <div class="container py-4 position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="admin-badge mb-3 fade-in">
                    <span class="admin-view-badge">Admin Panel</span>
                </div>
                <h1 class="display-5 fw-bold text-white mb-3 admin-title-hero">
                    Analytics Dashboard
                </h1>
                <p class="text-white-50 mb-0 subtitle-hero">
                    Track and analyze article performance metrics
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="admin-analytics-container bg-white shadow-sm rounded-4 p-4 p-md-5 mb-4">
                <!-- Admin Controls -->
                <div class="admin-controls mb-4 d-flex justify-content-between align-items-center">
                    <h2 class="section-title mb-0">Article View Statistics</h2>
                    <a href="{{ route('admin.dashboard') }}" class="admin-back-btn">
                        <i class="fas fa-arrow-left me-2"></i>
                        <span>Back to Dashboard</span>
                    </a>
                </div>
                
                @if($articles->count())
                <div class="table-responsive">
                    <table class="table table-hover analytics-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>View Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr class="article-row fade-in">
                                <td>{{ $article->id }}</td>
                                <td>{{ $article->title }}</td>
                                <td>
                                    <div class="view-count-badge">{{ $article->view_count }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 pagination-container">
                    {{ $articles->links() }}
                </div>
                @else
                <div class="empty-state text-center py-5">
                    <div class="empty-icon mb-3">📊</div>
                    <h3>No Articles Found</h3>
                    <p class="text-muted">There are no articles with view statistics at this time.</p>
                </div>
                @endif

                <!-- Charts Section -->
                <div class="charts-section mt-5">
                    <div class="chart-card mb-5 fade-in">
                        <h2 class="section-title mb-4">Monthly View Counts</h2>
                        <div class="chart-container">
                            <canvas id="monthlyChart" height="300"></canvas>
                        </div>
                    </div>

                    <div class="chart-card fade-in">
                        <h2 class="section-title mb-4">Yearly View Counts</h2>
                        <div class="chart-container">
                            <canvas id="yearlyChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="{{ asset('css/admin-analytics.css') }}" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthlyData = @json($monthlyViews);
    const yearlyData = @json($yearlyViews);

    const monthlyLabels = monthlyData.map(item => {
        const monthName = new Date(item.year, item.month - 1).toLocaleString('default', { month: 'long' });
        return monthName + ' ' + item.year;
    });
    const monthlyCounts = monthlyData.map(item => item.total_views);

    const yearlyLabels = yearlyData.map(item => item.year);
    const yearlyCounts = yearlyData.map(item => item.total_views);

    const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(ctxMonthly, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Monthly View Counts',
                data: monthlyCounts,
                backgroundColor: 'rgba(124, 58, 237, 0.6)',
                borderColor: 'rgba(124, 58, 237, 1)',
                borderWidth: 1,
                borderRadius: 6,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(76, 29, 149, 0.8)',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });

    const ctxYearly = document.getElementById('yearlyChart').getContext('2d');
    const yearlyChart = new Chart(ctxYearly, {
        type: 'bar',
        data: {
            labels: yearlyLabels,
            datasets: [{
                label: 'Yearly View Counts',
                data: yearlyCounts,
                backgroundColor: 'rgba(79, 70, 229, 0.6)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 1,
                borderRadius: 6,
                maxBarThickness: 60
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(76, 29, 149, 0.8)',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });
</script>
@endsection
