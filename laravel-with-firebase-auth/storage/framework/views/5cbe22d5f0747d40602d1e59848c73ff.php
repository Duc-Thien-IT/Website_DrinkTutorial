<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
</head>



<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">List Management</div>

                <div class="card-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

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
<?php $__env->stopSection(); ?>


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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Documents\BaiTap\87_UngDungPhaCheDoUong\SOURCE\Website\Management_DrinkTutorialApp\laravel-with-firebase-auth\resources\views/home.blade.php ENDPATH**/ ?>