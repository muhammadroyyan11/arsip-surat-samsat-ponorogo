@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small text-uppercase fw-bold">Surat Masuk</div>
                        <div class="h2 mb-0 fw-bold">{{ \App\Models\SuratMasuk::count() }}</div>
                    </div>
                    <i class="fas fa-inbox fa-2x text-white-50"></i>
                </div>
            </div>
            <a href="{{ url('surat-masuks') }}" class="card-footer text-white clearfix small z-1 d-flex align-items-center justify-content-between text-decoration-none">
                <span class="float-left">View Details</span>
                <span class="float-right"><i class="fas fa-angle-right"></i></span>
            </a>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small text-uppercase fw-bold">Surat Keluar</div>
                        <div class="h2 mb-0 fw-bold">{{ \App\Models\SuratKeluar::count() }}</div>
                    </div>
                    <i class="fas fa-paper-plane fa-2x text-white-50"></i>
                </div>
            </div>
            <a href="{{ url('surat-keluars') }}" class="card-footer text-white clearfix small z-1 d-flex align-items-center justify-content-between text-decoration-none">
                <span class="float-left">View Details</span>
                <span class="float-right"><i class="fas fa-angle-right"></i></span>
            </a>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small text-uppercase fw-bold">Total Users</div>
                        <div class="h2 mb-0 fw-bold">{{ \App\Models\User::count() }}</div>
                    </div>
                    <i class="fas fa-users fa-2x text-white-50"></i>
                </div>
            </div>
            <a href="{{ url('users') }}" class="card-footer text-white clearfix small z-1 d-flex align-items-center justify-content-between text-decoration-none">
                <span class="float-left">View Details</span>
                <span class="float-right"><i class="fas fa-angle-right"></i></span>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header fw-bold">Welcome</div>
            <div class="card-body">
                Selamat Datang di Sistem Informasi Arsip Surat, <b>{{ auth()->user()->name }}</b>.
            </div>
        </div>
    </div>
</div>
@endsection
