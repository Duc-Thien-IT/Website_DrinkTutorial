<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>CRUD for DoUong</title>
    <style>
        #addDoUongForm {
            display: none;
        }
    </style>
</head>
<body>

<div class="container" style="margin-top: 50px;">
    <h4 class="text-center">QUẢN LÝ ĐỒ UỐNG</h4><br>

    <!-- Add DoUong Button -->
    <h5>Thêm Mới Đồ Uống</h5>
    <button id="showAddForm" class="btn btn-success mb-3">THÊM ĐỒ UỐNG</button>

    <!-- Add DoUong Form -->
    <div id="addDoUongForm" class="card card-default">
        <div class="card-body">
            <form id="addDoUong" class="form">
                <div class="form-group">
                    <label for="Name">Tên Đồ Uống</label>
                    <input id="Name" type="text" class="form-control" name="Name" placeholder="Tên Đồ Uống" required autofocus>
                </div>
                <div class="form-group">
                    <label for="MoTa">Mô Tả</label>
                    <input id="MoTa" type="text" class="form-control" name="MoTa" placeholder="Mô Tả" required>
                </div>
                <div class="form-group">
                    <label for="BuocPhaChe">Bước Pha Chế</label>
                    <input id="BuocPhaChe" type="text" class="form-control" name="BuocPhaChe" placeholder="Bước Pha Chế" required>
                </div>
                <div class="form-group">
                    <label for="Ngay">Ngày</label>
                    <input id="Ngay" type="text" class="form-control" name="Ngay" placeholder="Ngày" required>
                </div>
                <div class="form-group">
                    <label for="HinhAnh">Hình Ảnh</label>
                    <input id="HinhAnh" type="text" class="form-control" name="HinhAnh" placeholder="Hình Ảnh URL" required>
                </div>
                <div class="form-group">
                    <label for="Loai">Loại</label>
                    <input id="Loai" type="text" class="form-control" name="Loai" placeholder="Loại Đồ Uống" required>
                </div>
                <button id="submitDoUong" type="button" class="btn btn-primary">THÊM</button>
            </form>
        </div>
    </div>

    <br>

    <!-- DoUong Table -->
    <h5>Danh Sách Đồ Uống</h5>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Tên Đồ Uống</th>
            <th>Mô Tả</th>
            <th>Hình Ảnh</th>
            <th>Bước Pha Chế</th>
            <th>Ngày</th>
            <th>Loại</th>
            <th width="200" class="text-center">Hành Động</th>
        </tr>
        <tbody id="tbodyDoUong">
        </tbody>
    </table>
</div>

<!-- Update Modal -->
<form action="" method="POST" class="users-update-record-model form-horizontal">
    <div id="update-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Cập Nhật Đồ Uống</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="updateBody">
                    <div class="form-group">
                        <label for="updateName" class="col-md-12 col-form-label">Tên Đồ Uống</label>
                        <input id="updateName" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateMoTa" class="col-md-12 col-form-label">Mô Tả</label>
                        <input id="updateMoTa" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateBuocPhaChe" class="col-md-12 col-form-label">Bước Pha Chế</label>
                        <input id="updateBuocPhaChe" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateNgay" class="col-md-12 col-form-label">Ngày</label>
                        <input id="updateNgay" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateHinhAnh" class="col-md-12 col-form-label">Hình Ảnh</label>
                        <input id="updateHinhAnh" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateLoai" class="col-md-12 col-form-label">Loại</label>
                        <input id="updateLoai" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ĐÓNG</button>
                    <button type="button" class="btn btn-success updateDoUong">LƯU</button>
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

    // Function to fetch DoUong data
    function getDoUongData() {
        const doUongRef = ref(database, 'DoUong/');
        onValue(doUongRef, (snapshot) => {
            const value = snapshot.val();
            const htmls = [];
            if (value) {
                Object.keys(value).forEach(key => {
                    // Cắt bớt Mô Tả và Bước Pha Chế sau 100 ký tự (hoặc từ)
                    const truncatedMoTa = truncateText(value[key].MoTa, 100);
                    const truncatedBuocPhaChe = truncateText(value[key].BuocPhaChe, 100);

                    htmls.push(`
                        <tr>
                            <td>${key}</td>
                            <td>${value[key].Name}</td>
                            <td>${truncatedMoTa}</td>
                            <td><img src="${value[key].HinhAnh}" alt="Hình Ảnh" width="100" /></td>
                            <td>${truncatedBuocPhaChe}</td>
                            <td>${value[key].Ngay}</td>
                            <td>${value[key].Loai}</td>
                            <td>
                                <button class="btn btn-info updateData" data-toggle="modal" data-target="#update-modal" data-id="${key}" data-name="${value[key].Name}" data-mota="${value[key].MoTa}" data-buoc="${value[key].BuocPhaChe}" data-ngay="${value[key].Ngay}" data-anh="${value[key].HinhAnh}" data-loai="${value[key].Loai}">Sửa</button>
                                <button class="btn btn-danger removeData" data-id="${key}">Xóa</button>
                            </td>
                        </tr>
                    `);
                });
                document.getElementById('tbodyDoUong').innerHTML = htmls.join('');
            } else {
                document.getElementById('tbodyDoUong').innerHTML = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
            }
        });
    }

    // Function to truncate text
    function truncateText(text, maxLength) {
        if (text.length > maxLength) {
            return text.substring(0, maxLength) + '...';
        } else {
            return text;
        }
    }

    // Function to reset the form
    function resetForm() {
        document.getElementById('addDoUong').reset();
    }

    // Fetch DoUong data on page load
    document.addEventListener('DOMContentLoaded', getDoUongData);

    // Show Add DoUong form when clicking on the button
    document.getElementById('showAddForm').addEventListener('click', () => {
        document.getElementById('addDoUongForm').style.display = 'block';
        document.getElementById('showAddForm').style.display = 'none';
    });

    // Function to get next ID
    async function getNextID() {
        const doUongRef = ref(database, 'DoUong/');
        const snapshot = await get(doUongRef);
        const value = snapshot.val();
        let maxID = 0;

        if (value) {
            Object.keys(value).forEach(key => {
                const num = parseInt(key.replace('DoUong', ''), 10);
                if (num > maxID) {
                    maxID = num;
                }
            });
        }

        return 'DoUong' + (maxID + 1);
    }

    // Add new DoUong
    document.getElementById('submitDoUong').addEventListener('click', async () => {
        const Name = document.getElementById('Name').value;
        const MoTa = document.getElementById('MoTa').value;
        const BuocPhaChe = document.getElementById('BuocPhaChe').value;
        const Ngay = document.getElementById('Ngay').value;
        const HinhAnh = document.getElementById('HinhAnh').value;
        const Loai = document.getElementById('Loai').value;
        const newID = await getNextID();
        const doUongRef = ref(database, 'DoUong/' + newID);
        set(doUongRef, {
            Name: Name,
            MoTa: MoTa,
            BuocPhaChe: BuocPhaChe,
            Ngay: Ngay,
            HinhAnh: HinhAnh,
            Loai: Loai,
        }).then(() => {
            alert('Thêm Đồ Uống thành công!');
            resetForm();
            document.getElementById('addDoUongForm').style.display = 'none';
            document.getElementById('showAddForm').style.display = 'block';
        }).catch((error) => {
            console.error(error);
        });
    });

    // Remove DoUong
    document.getElementById('tbodyDoUong').addEventListener('click', (e) => {
        if (e.target.classList.contains('removeData')) {
            const id = e.target.getAttribute('data-id');
            if (confirm('Bạn có chắc muốn xóa không?')) {
                const doUongRef = ref(database, 'DoUong/' + id);
                remove(doUongRef).then(() => {
                    alert('Xóa Đồ Uống thành công!');
                }).catch((error) => {
                    console.error(error);
                });
            }
        }
    });

    // Populate update modal with existing data
    document.getElementById('tbodyDoUong').addEventListener('click', (e) => {
        if (e.target.classList.contains('updateData')) {
            const id = e.target.getAttribute('data-id');
            const name = e.target.getAttribute('data-name');
            const mota = e.target.getAttribute('data-mota');
            const buoc = e.target.getAttribute('data-buoc');
            const ngay = e.target.getAttribute('data-ngay');
            const anh = e.target.getAttribute('data-anh');
            const loai = e.target.getAttribute('data-loai');
            document.getElementById('updateName').value = name;
            document.getElementById('updateMoTa').value = mota;
            document.getElementById('updateBuocPhaChe').value = buoc;
            document.getElementById('updateNgay').value = ngay;
            document.getElementById('updateHinhAnh').value = anh;
            document.getElementById('updateLoai').value = loai;
            document.querySelector('.updateDoUong').setAttribute('data-id', id);
        }
    });

    // Update DoUong
    document.querySelector('.updateDoUong').addEventListener('click', () => {
        const id = document.querySelector('.updateDoUong').getAttribute('data-id');
        const Name = document.getElementById('updateName').value;
        const MoTa = document.getElementById('updateMoTa').value;
        const BuocPhaChe = document.getElementById('updateBuocPhaChe').value;
        const Ngay = document.getElementById('updateNgay').value;
        const HinhAnh = document.getElementById('updateHinhAnh').value;
        const Loai = document.getElementById('updateLoai').value;
        const doUongRef = ref(database, 'DoUong/' + id);
        set(doUongRef, {
            Name: Name,
            MoTa: MoTa,
            BuocPhaChe: BuocPhaChe,
            Ngay: Ngay,
            HinhAnh: HinhAnh,
            Loai: Loai,
        }).then(() => {
            alert('Cập Nhật Đồ Uống thành công!');
            document.getElementById('update-modal').modal('hide');
        }).catch((error) => {
            console.error(error);
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\Admin\Documents\BaiTap\87_UngDungPhaCheDoUong\SOURCE\Website\Management_DrinkTutorialApp\laravel-with-firebase-auth\resources\views/douong.blade.php ENDPATH**/ ?>