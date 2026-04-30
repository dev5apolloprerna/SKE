@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Dashboard</h4>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm dashboard-card sparkle-card navy-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-1">Active Categories</p>
                                        <h2>{{ $categoryCount }}</h2>
                                    </div>
                                    <div class="dashboard-icon">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm dashboard-card sparkle-card gold-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-1">Subcategories</p>
                                        <h2>{{ $subcategoryCount }}</h2>
                                    </div>
                                    <div class="dashboard-icon">
                                        <i class="fas fa-list"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{--<div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.subcategories.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm dashboard-card sparkle-card gold-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-1">Active Subcategories</p>
                                        <h2>{{ $subcategoryCount }}</h2>
                                    </div>
                                    <div class="dashboard-icon">
                                        <i class="fas fa-list"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> --}}

                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm dashboard-card sparkle-card green-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-1">Active Products</p>
                                        <h2>{{ $productCount }}</h2>
                                    </div>
                                    <div class="dashboard-icon">
                                        <i class="fas fa-box"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm dashboard-card sparkle-card purple-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-1">Featured Products</p>
                                        <h2>{{ $featuredProductCount }}</h2>
                                    </div>
                                    <div class="dashboard-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm dashboard-card sparkle-card blue-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-1">Product Images</p>
                                        <h2>{{ $productImageCount }}</h2>
                                    </div>
                                    <div class="dashboard-icon">
                                        <i class="fas fa-images"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6">
                    
                    <a href="{{ route('admin.gallery-images.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm dashboard-card sparkle-card purple-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-1">Gallery Images</p>
                                        <h2>{{ $galleryImageCount }}</h2>
                                    </div>
                                    <div class="dashboard-icon">
                                        <i class="fas fa-images"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.inquiries.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm dashboard-card sparkle-card red-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-1">New Inquiries</p>
                                        <h2>{{ $newInquiryCount }}</h2>
                                    </div>
                                    <div class="dashboard-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.inquiries.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm dashboard-card sparkle-card dark-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-1">Total Inquiries</p>
                                        <h2>{{ $totalInquiryCount }}</h2>
                                    </div>
                                    <div class="dashboard-icon">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<style>
    .dashboard-card {
        border: none;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 24px;
        color: #ffffff;
        position: relative;
        transition: all 0.25s ease-in-out;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.18) !important;
    }

    .dashboard-card p {
        font-size: 15px;
        font-weight: 600;
        color: rgba(255,255,255,0.9);
    }

    .dashboard-card h2 {
        font-size: 34px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0;
    }

    .dashboard-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(255,255,255,0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #ffffff;
    }

    .sparkle-card::before {
        content: "";
        position: absolute;
        top: -40px;
        right: -40px;
        width: 130px;
        height: 130px;
        background: rgba(255,255,255,0.18);
        border-radius: 50%;
    }

    .sparkle-card::after {
        content: "";
        position: absolute;
        bottom: -35px;
        left: -35px;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.12);
        border-radius: 50%;
    }

    .navy-card {
        background: linear-gradient(135deg, #0b1f3a, #153e75);
    }

    .gold-card {
        background: linear-gradient(135deg, #9a6a00, #d9a520);
    }

    .green-card {
        background: linear-gradient(135deg, #0f5132, #198754);
    }

    .purple-card {
        background: linear-gradient(135deg, #4b1d78, #7b2cbf);
    }

    .blue-card {
        background: linear-gradient(135deg, #084298, #0d6efd);
    }

    .red-card {
        background: linear-gradient(135deg, #842029, #dc3545);
    }

    .dark-card {
        background: linear-gradient(135deg, #212529, #495057);
    }
</style>
@endsection