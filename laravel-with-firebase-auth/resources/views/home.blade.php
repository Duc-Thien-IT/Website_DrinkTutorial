<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
</head>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">List Management</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <br>
                    <button onclick="window.location.href='/customers'" class="btn btn-primary btn-block mb-3">
                        <i class="bi bi-person"></i> Quản Lý Khách Hàng
                    </button>
                    <button onclick="window.location.href='/loainguyenlieu'" class="btn btn-primary btn-block mb-3">
                        <i class="bi bi-box"></i> Quản Lý Loại Nguyên Liệu
                    </button>
                    <button onclick="window.location.href='/loaidouong'" class="btn btn-primary btn-block mb-3">
                        <i class="bi bi-cup-straw"></i> Quản Lý Loại Đồ Uống
                    </button>
                    <button onclick="window.location.href='/nguyenlieu'" class="btn btn-primary btn-block mb-3">
                        <i class="bi bi-basket"></i> Quản Lý Nguyên Liệu
                    </button>
                    <button onclick="window.location.href='/douong'" class="btn btn-primary btn-block mb-3">
                        <i class="bi bi-cup"></i> Quản Lý Đồ Uống
                    </button>
                    <button onclick="window.location.href='/baiviet'" class="btn btn-primary btn-block mb-3">
                        <i class="bi bi-file-earmark-text"></i> Quản Lý Bài Viết
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<style>
    .btn-block {
        font-size: 1.25rem;
        padding: 15px;
    }
    .btn-block:hover {
        background-color: #0056b3;
        color: white;
    }
</style>
