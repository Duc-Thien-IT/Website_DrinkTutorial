<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>CRUD for NguyenLieu</title>
</head>
<body>

<div class="container" style="margin-top: 50px;">
    <h4 class="text-center">QUẢN LÝ NGUYÊN LIỆU</h4><br>

    <!-- Add NguyenLieu Form -->
    <h5>Thêm Mới Nguyên Liệu</h5>
    <div class="card card-default">
        <div class="card-body">
            <form id="addNguyenLieu" class="form-inline">
                <div class="form-group mb-2">
                    <label for="Ten" class="sr-only">Tên Nguyên Liệu</label>
                    <input id="Ten" type="text" class="form-control" name="Ten" placeholder="Tên Nguyên Liệu" required autofocus>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="DonViDo" class="sr-only">Đơn Vị Đo</label>
                    <input id="DonViDo" type="text" class="form-control" name="DonViDo" placeholder="Đơn Vị Đo" required>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="Anh" class="sr-only">Hình Ảnh URL</label>
                    <input id="Anh" type="text" class="form-control" name="Anh" placeholder="Hình Ảnh URL" required>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="Loai" class="sr-only">Loại</label>
                    <input id="Loai" type="text" class="form-control" name="Loai" placeholder="Loại Nguyên Liệu" required>
                </div>
                <button id="submitNguyenLieu" type="button" class="btn btn-primary mb-2">THÊM</button>
            </form>
        </div>
    </div>

    <br>

    <!-- NguyenLieu Table -->
    <h5>Danh Sách Nguyên Liệu</h5>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Tên Nguyên Liệu</th>
            <th>Đơn Vị Đo</th>
            <th>Loại</th>
            <th>Hình Ảnh</th>
            <th width="200" class="text-center">Hành Động</th>
        </tr>
        <tbody id="tbodyNguyenLieu">
        </tbody>
    </table>
</div>

<!-- Update Modal -->
<form action="" method="POST" class="users-update-record-model form-horizontal">
    <div id="update-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Cập Nhật Nguyên Liệu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="updateBody">
                    <div class="form-group">
                        <label for="updateTen" class="col-md-12 col-form-label">Tên Nguyên Liệu</label>
                        <input id="updateTen" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateDonViDo" class="col-md-12 col-form-label">Đơn Vị Đo</label>
                        <input id="updateDonViDo" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateAnh" class="col-md-12 col-form-label">Hình Ảnh</label>
                        <input id="updateAnh" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateLoai" class="col-md-12 col-form-label">Loại</label>
                        <input id="updateLoai" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ĐÓNG</button>
                    <button type="button" class="btn btn-success updateNguyenLieu">LƯU</button>
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

    // Function to fetch NguyenLieu data
    function getNguyenLieuData() {
        const nguyenLieuRef = ref(database, 'NguyenLieu/');
        onValue(nguyenLieuRef, (snapshot) => {
            const value = snapshot.val();
            const htmls = [];
            if (value) {
                Object.keys(value).forEach(key => {
                    htmls.push(`
                        <tr>
                            <td>${key}</td>
                            <td>${value[key].Ten}</td>
                            <td>${value[key].DonViDo}</td>
                            <td>${value[key].Loai}</td>
                            <td><img src="${value[key].Anh}" alt="Hình Ảnh" width="100" /></td>
                            <td>
                                <button class="btn btn-info updateData" data-toggle="modal" data-target="#update-modal" data-id="${key}" data-ten="${value[key].Ten}" data-donvi="${value[key].DonViDo}" data-loai="${value[key].Loai}" data-anh="${value[key].Anh}">CẬP NHẬT</button>
                                <button class="btn btn-danger removeData" data-id="${key}">XÓA</button>
                            </td>
                        </tr>
                    `);
                });
                document.getElementById('tbodyNguyenLieu').innerHTML = htmls.join('');
            }
        });
    }

    // Function to add new NguyenLieu
    document.getElementById('submitNguyenLieu').addEventListener('click', () => {
        const Ten = document.getElementById('Ten').value;
        const DonViDo = document.getElementById('DonViDo').value;
        const Anh = document.getElementById('Anh').value;
        const Loai = document.getElementById('Loai').value;

        if (Ten && DonViDo && Anh && Loai) {
            // Get the current maximum ID and increment it
            const nguyenLieuRef = ref(database, 'NguyenLieu/');
            get(nguyenLieuRef).then((snapshot) => {
                const value = snapshot.val();
                let maxID = 0;

                if (value) {
                    // Find the maximum number from existing IDs
                    Object.keys(value).forEach(key => {
                        const idNumber = parseInt(key.replace('NL', ''));
                        if (idNumber > maxID) {
                            maxID = idNumber;
                        }
                    });
                }

                const newID = 'NL' + (maxID + 1); // Create a new ID by incrementing the largest existing ID
                const newNguyenLieuRef = ref(database, 'NguyenLieu/' + newID);
                set(newNguyenLieuRef, {
                    Ten,
                    DonViDo,
                    Anh,
                    Loai
                }).then(() => {
                    console.log('Nguyên liệu được thêm mới thành công!');
                    getNguyenLieuData();
                    document.getElementById('addNguyenLieu').reset();
                }).catch((error) => {
                    console.error('Có lỗi khi thêm mới nguyên liệu: ', error);
                });
            });
        } else {
            alert("Please fill in all fields.");
        }
    });

    // Function to update NguyenLieu
    let updateID = null;
    document.body.addEventListener('click', (e) => {
        if (e.target.classList.contains('updateData')) {
            updateID = e.target.getAttribute('data-id');
            const Ten = e.target.getAttribute('data-ten');
            const DonViDo = e.target.getAttribute('data-donvi');
            const Loai = e.target.getAttribute('data-loai');
            const Anh = e.target.getAttribute('data-anh');

            // Populate the modal with current data
            document.getElementById('updateTen').value = Ten;
            document.getElementById('updateDonViDo').value = DonViDo;
            document.getElementById('updateLoai').value = Loai;
            document.getElementById('updateAnh').value = Anh;
        }
    });

    // Function to handle updating NguyenLieu
    document.querySelector('.updateNguyenLieu').addEventListener('click', () => {
        const updatedTen = document.getElementById('updateTen').value;
        const updatedDonViDo = document.getElementById('updateDonViDo').value;
        const updatedAnh = document.getElementById('updateAnh').value;
        const updatedLoai = document.getElementById('updateLoai').value;

        if (updatedTen && updatedDonViDo && updatedAnh && updatedLoai) {
            const nguyenLieuRef = ref(database, 'NguyenLieu/' + updateID);
            set(nguyenLieuRef, {
                Ten: updatedTen,
                DonViDo: updatedDonViDo,
                Anh: updatedAnh,
                Loai: updatedLoai
            }).then(() => {
                console.log('Nguyên liệu được cập nhật thành công!');
                $('#update-modal').modal('hide');
                getNguyenLieuData();
            }).catch((error) => {
                console.error('Có lỗi khi cập nhật nguyên liệu: ', error);
            });
        }
    });

    // Function to delete NguyenLieu
    document.body.addEventListener('click', (e) => {
        if (e.target.classList.contains('removeData')) {
            const nguyenLieuID = e.target.getAttribute('data-id');
            const nguyenLieuRef = ref(database, 'NguyenLieu/' + nguyenLieuID);
            remove(nguyenLieuRef).then(() => {
                console.log('Xóa thành công nguyên liệu!');
                getNguyenLieuData();
            }).catch((error) => {
                console.error('Có lỗi khi xóa nguyên liệu: ', error);
            });
        }
    });

    // Fetch data when the page loads
    getNguyenLieuData();
</script>

<!-- Bootstrap JS & Dependencies -->
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
<?php /**PATH C:\Users\Admin\Documents\BaiTap\87_UngDungPhaCheDoUong\SOURCE\Website\Management_DrinkTutorialApp\laravel-with-firebase-auth\resources\views/nguyenlieu.blade.php ENDPATH**/ ?>