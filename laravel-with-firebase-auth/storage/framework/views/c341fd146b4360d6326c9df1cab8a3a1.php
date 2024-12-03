<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>CRUD for BaiViet</title>
</head>
<body>

<div class="container" style="margin-top: 50px;">
    <h4 class="text-center">QUẢN LÝ BÀI VIẾT</h4><br>

    <!-- Add BaiViet Form -->
    <h5>Thêm Mới Bài Viết</h5>
    <div class="card card-default">
        <div class="card-body">
            <button id="openAddModal" type="button" class="btn btn-primary">THÊM</button>
        </div>
    </div>

    <!-- BaiViet Table -->
    <h5>Danh Sách Bài Viết</h5>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Tiêu Đề</th>
            <th>Ngày Đăng</th>
            <th>Nội Dung</th>
            <th>Hình Ảnh</th>
            <th width="200" class="text-center">Hành Động</th>
        </tr>
        <tbody id="tbodyBaiViet">
        </tbody>
    </table>
</div>

<!-- Modal Add New BaiViet -->
<form action="" method="POST" class="users-update-record-model form-horizontal">
    <div id="add-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Thêm Mới Bài Viết</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="addBody">
                    <div class="form-group">
                        <label for="addTieuDe" class="col-md-12 col-form-label">Tiêu Đề</label>
                        <input id="addTieuDe" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="addNgayDang" class="col-md-12 col-form-label">Ngày Đăng</label>
                        <input id="addNgayDang" type="date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="addNoiDung" class="col-md-12 col-form-label">Nội Dung</label>
                        <textarea id="addNoiDung" class="form-control" required rows="5"></textarea>
                    </div>
                    <!-- Input for Image URLs (max 4) -->
                    <div class="form-group">
                        <label for="addImage1" class="col-md-12 col-form-label">Hình Ảnh 1 (URL)</label>
                        <input id="addImage1" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="addImage2" class="col-md-12 col-form-label">Hình Ảnh 2 (URL)</label>
                        <input id="addImage2" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="addImage3" class="col-md-12 col-form-label">Hình Ảnh 3 (URL)</label>
                        <input id="addImage3" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="addImage4" class="col-md-12 col-form-label">Hình Ảnh 4 (URL)</label>
                        <input id="addImage4" type="text" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ĐÓNG</button>
                    <button type="button" class="btn btn-success addBaiViet">THÊM</button>
                    <button type="button" class="btn btn-warning updateBaiViet">CẬP NHẬT</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Firebase Scripts -->
<script type="module">
    const firebaseConfig = {
        apiKey: "<?php echo e(config('services.firebase.api_key')); ?>",
        authDomain: "<?php echo e(config('services.firebase.auth_domain')); ?>",
        databaseURL: "<?php echo e(config('services.firebase.database_url')); ?>",
        projectId: "<?php echo e(config('services.firebase.project_id')); ?>",
        storageBucket: "<?php echo e(config('services.firebase.storage_bucket')); ?>",
        messagingSenderId: "<?php echo e(config('services.firebase.messaging_sender_id')); ?>",
        appId: "<?php echo e(config('services.firebase.app_id')); ?>",
        measurementId: "<?php echo e(config('services.firebase.measurement_id')); ?>",
    };

    // Initialize Firebase
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js";
    import { getDatabase, ref, set, get, onValue, remove, update } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-database.js";

    const app = initializeApp(firebaseConfig);
    const database = getDatabase(app);

    // Function to fetch BaiViet data
    function getBaiVietData() {
        const baiVietRef = ref(database, 'BaiViet/');
        onValue(baiVietRef, (snapshot) => {
            const value = snapshot.val();
            const htmls = [];
            if (value) {
                Object.keys(value).forEach(key => {
                    // Cắt ngắn nội dung nếu dài hơn 200 ký tự
                    let noiDung = value[key].NoiDung;
                    if (noiDung.length > 200) {
                        noiDung = noiDung.substring(0, 200) + '...';
                    }

                    // Xử lý hình ảnh từ object HinhAnh
                    let imagesHtml = '';
                    for (let i = 1; i <= 4; i++) {
                        if (value[key].HinhAnh[`Anh${i}`]) {
                            imagesHtml += `<img src="${value[key].HinhAnh[`Anh${i}`]}" alt="Hình ảnh ${i}" width="100"><br>`;
                        }
                    }

                    htmls.push(`
                        <tr>
                            <td>${key}</td>
                            <td>${value[key].TieuDe}</td>
                            <td>${value[key].NgayDang}</td>
                            <td>${noiDung}</td>
                            <td>${imagesHtml}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-edit" data-id="${key}">Sửa</button>
                                <button class="btn btn-danger btn-delete" data-id="${key}">Xóa</button>
                            </td>
                        </tr>
                    `);
                });
            }
            document.getElementById('tbodyBaiViet').innerHTML = htmls.join('');
        });
    }
    getBaiVietData();

    // Mở modal để thêm bài viết
    document.getElementById('openAddModal').addEventListener('click', () => {
        // Reset các trường trong modal
        document.getElementById('addTieuDe').value = '';
        document.getElementById('addNgayDang').value = '';
        document.getElementById('addNoiDung').value = '';
        document.getElementById('addImage1').value = '';
        document.getElementById('addImage2').value = '';
        document.getElementById('addImage3').value = '';
        document.getElementById('addImage4').value = '';

        // Hiển thị modal để thêm bài viết
        $('#add-modal').modal('show');
        document.querySelector('.updateBaiViet').style.display = 'none';
        document.querySelector('.addBaiViet').style.display = 'inline-block';
    });

    // Xử lý thêm bài viết mới
    document.querySelector('.addBaiViet').addEventListener('click', () => {
        const TieuDe = document.getElementById('addTieuDe').value;
        const NgayDang = document.getElementById('addNgayDang').value;
        const NoiDung = document.getElementById('addNoiDung').value;
        const HinhAnh = {
            Anh1: document.getElementById('addImage1').value || null,
            Anh2: document.getElementById('addImage2').value || null,
            Anh3: document.getElementById('addImage3').value || null,
            Anh4: document.getElementById('addImage4').value || null,
        };

        const baiVietId = ref(database, 'BaiViet/').push().key;

        set(ref(database, `BaiViet/${baiVietId}`), {
            TieuDe,
            NgayDang,
            NoiDung,
            HinhAnh,
        }).then(() => {
            getBaiVietData();
            $('#add-modal').modal('hide');
        }).catch((error) => {
            console.error('Lỗi khi lưu bài viết: ', error);
        });
    });

    // Xử lý sửa bài viết
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('btn-edit')) {
            const baiVietId = e.target.getAttribute('data-id');
            const baiVietRef = ref(database, `BaiViet/${baiVietId}`);
            get(baiVietRef).then((snapshot) => {
                const data = snapshot.val();
                document.getElementById('addTieuDe').value = data.TieuDe;
                document.getElementById('addNgayDang').value = data.NgayDang;
                document.getElementById('addNoiDung').value = data.NoiDung;
                document.getElementById('addImage1').value = data.HinhAnh.Anh1 || '';
                document.getElementById('addImage2').value = data.HinhAnh.Anh2 || '';
                document.getElementById('addImage3').value = data.HinhAnh.Anh3 || '';
                document.getElementById('addImage4').value = data.HinhAnh.Anh4 || '';

                // Hiển thị nút sửa và ẩn nút thêm
                $('#add-modal').modal('show');
                document.querySelector('.addBaiViet').style.display = 'none';
                document.querySelector('.updateBaiViet').style.display = 'inline-block';

                // Cập nhật dữ liệu bài viết
                document.querySelector('.updateBaiViet').onclick = function () {
                    update(ref(database, `BaiViet/${baiVietId}`), {
                        TieuDe: document.getElementById('addTieuDe').value,
                        NgayDang: document.getElementById('addNgayDang').value,
                        NoiDung: document.getElementById('addNoiDung').value,
                        HinhAnh: {
                            Anh1: document.getElementById('addImage1').value || null,
                            Anh2: document.getElementById('addImage2').value || null,
                            Anh3: document.getElementById('addImage3').value || null,
                            Anh4: document.getElementById('addImage4').value || null,
                        }
                    }).then(() => {
                        getBaiVietData();
                        $('#add-modal').modal('hide');
                    }).catch((error) => {
                        console.error('Lỗi khi cập nhật bài viết: ', error);
                    });
                };
            });
        }
    });

    // Xử lý xóa bài viết
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('btn-delete')) {
            const baiVietId = e.target.getAttribute('data-id');
            if (confirm('Bạn có chắc chắn muốn xóa bài viết này?')) {
                remove(ref(database, `BaiViet/${baiVietId}`)).then(() => {
                    getBaiVietData();
                }).catch((error) => {
                    console.error('Lỗi khi xóa bài viết: ', error);
                });
            }
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
<?php /**PATH C:\Users\Admin\Documents\BaiTap\87_UngDungPhaCheDoUong\SOURCE\Website\Management_DrinkTutorialApp\laravel-with-firebase-auth\resources\views/baiviet.blade.php ENDPATH**/ ?>