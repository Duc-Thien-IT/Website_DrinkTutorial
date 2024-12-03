<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>CRUD for LoaiDoUong</title>
</head>
<body>

<div class="container" style="margin-top: 50px;">
    <h4 class="text-center">QUẢN LÝ LOẠI ĐỒ UỐNG</h4><br>

    <!-- Add LoaiDoUong Form -->
    <h5>THÊM MỚI LOẠI ĐỒ UỐNG</h5>
    <div class="card card-default">
        <div class="card-body">
            <form id="addLoaiDoUong" class="form-inline">
                <div class="form-group mb-2">
                    <label for="TenLoaiDoUong" class="sr-only">Tên Loại Đồ Uống</label>
                    <input id="TenLoaiDoUong" type="text" class="form-control" name="TenLoaiDoUong" placeholder="Tên Loại Đồ Uống" required autofocus>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="HinhAnhDoUong" class="sr-only">Hình Ảnh</label>
                    <input id="HinhAnhDoUong" type="text" class="form-control" name="HinhAnhDoUong" placeholder="Hình Ảnh URL" required>
                </div>
                <button id="submitLoaiDoUong" type="button" class="btn btn-primary mb-2">Thêm</button>
            </form>
        </div>
    </div>

    <br>

    <!-- LoaiDoUong Table -->
    <h5>DANH SÁCH LOẠI ĐỒ UỐNG</h5>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Tên Loại Đồ Uống</th>
            <th>Hình Ảnh</th>
            <th width="200" class="text-center">Hành Động</th>
        </tr>
        <tbody id="tbodyDoUong">
        </tbody>
    </table>
</div>

<!-- Update Modal -->
<form action="" method="POST" class="users-update-record-model form-horizontal">
    <div id="update-modal-douong" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Cập Nhật Loại Đồ Uống</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="updateBodyDoUong">
                    <div class="form-group">
                        <label for="updateTenLoaiDoUong" class="col-md-12 col-form-label">Tên Loại Đồ Uống</label>
                        <input id="updateTenLoaiDoUong" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateHinhAnhDoUong" class="col-md-12 col-form-label">Hình Ảnh</label>
                        <input id="updateHinhAnhDoUong" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ĐÓNG</button>
                    <button type="button" class="btn btn-success updateLoaiDoUong">LƯU</button>
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
    import { getDatabase, ref, set, get, onValue, remove } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-database.js";
    const app = initializeApp(firebaseConfig);
    const database = getDatabase(app);

    // Function to fetch LoaiDoUong data
    function getDataDoUong() {
        const loaiDoUongRef = ref(database, 'LoaiDoUong/');
        onValue(loaiDoUongRef, (snapshot) => {
            const value = snapshot.val();
            const htmls = [];
            if (value) {
                Object.keys(value).forEach(key => {
                    htmls.push(`
                        <tr>
                            <td>${key}</td>
                            <td>${value[key].TenLoai}</td>
                            <td><img src="${value[key].HinhAnh}" alt="Hình Ảnh" width="100" /></td>
                            <td>
                                <button class="btn btn-info updateDataDoUong" data-toggle="modal" data-target="#update-modal-douong" data-id="${key}" data-ten="${value[key].TenLoai}" data-hinh="${value[key].HinhAnh}">CẬP NHẬT</button>
                                <button class="btn btn-danger removeDataDoUong" data-id="${key}">XÓA</button>
                            </td>
                        </tr>
                    `);
                });
                document.getElementById('tbodyDoUong').innerHTML = htmls.join('');
            }
        });
    }

    // Function to add new LoaiDoUong with auto-increment ID
    document.getElementById('submitLoaiDoUong').addEventListener('click', () => {
        const TenLoaiDoUong = document.getElementById('TenLoaiDoUong').value;
        const HinhAnhDoUong = document.getElementById('HinhAnhDoUong').value;

        if (TenLoaiDoUong && HinhAnhDoUong) {
            // Get the current maximum ID and increment it
            const loaiDoUongRef = ref(database, 'LoaiDoUong/');
            get(loaiDoUongRef).then((snapshot) => {
                const value = snapshot.val();
                let maxID = 0;

                if (value) {
                    // Find the maximum number from existing IDs
                    Object.keys(value).forEach(key => {
                        const idNumber = parseInt(key.replace('LDU', ''));
                        if (idNumber > maxID) {
                            maxID = idNumber;
                        }
                    });
                }

                const newID = 'LDU' + (maxID + 1); // Create a new ID by incrementing the largest existing ID
                const newLoaiDoUongRef = ref(database, 'LoaiDoUong/' + newID);
                set(newLoaiDoUongRef, {
                    TenLoai: TenLoaiDoUong,
                    HinhAnh: HinhAnhDoUong
                }).then(() => {
                    console.log('Thêm mới loại đồ uống thành công!');
                    getDataDoUong();
                    document.getElementById('addLoaiDoUong').reset();
                }).catch((error) => {
                    console.error('Lỗi khi thêm mới loại đồ uống: ', error);
                });
            });
        } else {
            alert("Please fill in all fields.");
        }
    });

    // Function to update LoaiDoUong
    let updateIDDoUong = null;
    document.body.addEventListener('click', (e) => {
        if (e.target.classList.contains('updateDataDoUong')) {
            updateIDDoUong = e.target.getAttribute('data-id');
            const TenLoai = e.target.getAttribute('data-ten');
            const HinhAnh = e.target.getAttribute('data-hinh');

            // Populate the modal with current data
            document.getElementById('updateTenLoaiDoUong').value = TenLoai;
            document.getElementById('updateHinhAnhDoUong').value = HinhAnh;
        }
    });

    // Function to handle updating LoaiDoUong
    document.querySelector('.updateLoaiDoUong').addEventListener('click', () => {
        const updatedTenLoaiDoUong = document.getElementById('updateTenLoaiDoUong').value;
        const updatedHinhAnhDoUong = document.getElementById('updateHinhAnhDoUong').value;

        if (updateIDDoUong && updatedTenLoaiDoUong && updatedHinhAnhDoUong) {
            const updateRef = ref(database, 'LoaiDoUong/' + updateIDDoUong);
            set(updateRef, {
                TenLoai: updatedTenLoaiDoUong,
                HinhAnh: updatedHinhAnhDoUong
            }).then(() => {
                console.log('Cập nhật thông tin thành công!');
                $('#update-modal-douong').modal('hide');
                getDataDoUong();
            }).catch((error) => {
                console.error('Có lỗi khi cập nhật loại đồ uống: ', error);
            });
        }
    });

    // Function to delete LoaiDoUong
    document.body.addEventListener('click', (e) => {
        if (e.target.classList.contains('removeDataDoUong')) {
            const loaiDoUongID = e.target.getAttribute('data-id');
            const loaiDoUongRef = ref(database, 'LoaiDoUong/' + loaiDoUongID);
            remove(loaiDoUongRef).then(() => {
                console.log('Loại đồ uống xóa thành công!');
                getDataDoUong();
            }).catch((error) => {
                console.error('Có lỗi khi xóa loại đồ uống! ', error);
            });
        }
    });

    // Fetch data when the page loads
    getDataDoUong();
</script>

<!-- Bootstrap JS & Dependencies -->
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
<?php /**PATH C:\Users\Admin\Documents\BaiTap\87_UngDungPhaCheDoUong\SOURCE\Website\Management_DrinkTutorialApp\laravel-with-firebase-auth\resources\views/loaidouong.blade.php ENDPATH**/ ?>