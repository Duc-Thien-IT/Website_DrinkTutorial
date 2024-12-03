<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>CRUD for LoaiNguyenLieu</title>
</head>
<body>

<div class="container" style="margin-top: 50px;">
    <h4 class="text-center">QUẢN LÝ LOẠI NGUYÊN LIỆU</h4><br>

    <!-- Add LoaiNguyenLieu Form -->
    <h5>Thêm Mới Loại Nguyên Liệu</h5>
    <div class="card card-default">
        <div class="card-body">
            <form id="addLoaiNguyenLieu" class="form-inline">
                <div class="form-group mb-2">
                    <label for="TenLoai" class="sr-only">Tên Nguyên Liệu</label>
                    <input id="TenLoai" type="text" class="form-control" name="TenLoai" placeholder="Tên Nguyên Liệu" required autofocus>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="HinhAnh" class="sr-only">Hình Ảnh</label>
                    <input id="HinhAnh" type="text" class="form-control" name="HinhAnh" placeholder="Hình Ảnh URL" required>
                </div>
                <button id="submitLoaiNguyenLieu" type="button" class="btn btn-primary mb-2">THÊM</button>
            </form>
        </div>
    </div>

    <br>

    <!-- LoaiNguyenLieu Table -->
    <h5>Danh Sách Loại Nguyên Liệu</h5>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Tên Nguyên Liệu</th>
            <th>Hình Ảnh</th>
            <th width="200" class="text-center">Hành Động</th>
        </tr>
        <tbody id="tbody">
        </tbody>
    </table>
</div>

<!-- Update Modal -->
<form action="" method="POST" class="users-update-record-model form-horizontal">
    <div id="update-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Cập Nhật Loại Nguyên Liệu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="updateBody">
                    <div class="form-group">
                        <label for="updateTenLoai" class="col-md-12 col-form-label">Tên Nguyên Liệu</label>
                        <input id="updateTenLoai" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateHinhAnh" class="col-md-12 col-form-label">Hình Ảnh</label>
                        <input id="updateHinhAnh" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ĐÓNG</button>
                    <button type="button" class="btn btn-success updateLoaiNguyenLieu">LƯU</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Firebase Scripts -->
<script type="module">
    const firebaseConfig = {
        apiKey: "{{ config('services.firebase.api_key') }}",
        authDomain: "{{ config('services.firebase.auth_domain') }}",
        databaseURL: "{{ config('services.firebase.database_url') }}",
        projectId: "{{ config('services.firebase.project_id') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') }}",
        messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
        appId: "{{ config('services.firebase.app_id') }}",
        measurementId: "{{ config('services.firebase.measurement_id') }}",
    };

    // Initialize Firebase
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js";
    import { getDatabase, ref, set, get, onValue, remove } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-database.js";
    const app = initializeApp(firebaseConfig);
    const database = getDatabase(app);

    // Function to fetch LoaiNguyenLieu data
    function getData() {
        const loaiNguyenLieuRef = ref(database, 'LoaiNguyenLieu/');
        onValue(loaiNguyenLieuRef, (snapshot) => {
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
                                <button class="btn btn-info updateData" data-toggle="modal" data-target="#update-modal" data-id="${key}" data-ten="${value[key].TenLoai}" data-hinh="${value[key].HinhAnh}">CẬP NHẬT</button>
                                <button class="btn btn-danger removeData" data-id="${key}">XÓA</button>
                            </td>
                        </tr>
                    `);
                });
                document.getElementById('tbody').innerHTML = htmls.join('');
            }
        });
    }

    // Function to add new LoaiNguyenLieu with auto-increment ID
    document.getElementById('submitLoaiNguyenLieu').addEventListener('click', () => {
        const TenLoai = document.getElementById('TenLoai').value;
        const HinhAnh = document.getElementById('HinhAnh').value;

        if (TenLoai && HinhAnh) {
            // Get the current maximum ID and increment it
            const loaiNguyenLieuRef = ref(database, 'LoaiNguyenLieu/');
            get(loaiNguyenLieuRef).then((snapshot) => {
                const value = snapshot.val();
                let maxID = 0;

                if (value) {
                    // Find the maximum number from existing IDs
                    Object.keys(value).forEach(key => {
                        const idNumber = parseInt(key.replace('LNL', ''));
                        if (idNumber > maxID) {
                            maxID = idNumber;
                        }
                    });
                }

                const newID = 'LNL' + (maxID + 1); // Create a new ID by incrementing the largest existing ID
                const newLoaiNguyenLieuRef = ref(database, 'LoaiNguyenLieu/' + newID);
                set(newLoaiNguyenLieuRef, {
                    TenLoai: TenLoai,
                    HinhAnh: HinhAnh
                }).then(() => {
                    console.log('Loại nguyên liệu được thêm mới thành công!');
                    getData();
                    document.getElementById('addLoaiNguyenLieu').reset();
                }).catch((error) => {
                    console.error('Có lỗi khi thêm mới loại nguyên liệu: ', error);
                });
            });
        } else {
            alert("Please fill in all fields.");
        }
    });

    // Function to update LoaiNguyenLieu
    let updateID = null;
    document.body.addEventListener('click', (e) => {
        if (e.target.classList.contains('updateData')) {
            updateID = e.target.getAttribute('data-id');
            const TenLoai = e.target.getAttribute('data-ten');
            const HinhAnh = e.target.getAttribute('data-hinh');

            // Populate the modal with current data
            document.getElementById('updateTenLoai').value = TenLoai;
            document.getElementById('updateHinhAnh').value = HinhAnh;
        }
    });

    // Function to handle updating LoaiNguyenLieu
    document.querySelector('.updateLoaiNguyenLieu').addEventListener('click', () => {
        const updatedTenLoai = document.getElementById('updateTenLoai').value;
        const updatedHinhAnh = document.getElementById('updateHinhAnh').value;

        if (updatedTenLoai && updatedHinhAnh) {
            const loaiNguyenLieuRef = ref(database, 'LoaiNguyenLieu/' + updateID);
            set(loaiNguyenLieuRef, {
                TenLoai: updatedTenLoai,
                HinhAnh: updatedHinhAnh
            }).then(() => {
                console.log('Loại nguyên liệu được cập nhật thành công!');
                $('#update-modal').modal('hide');
                getData();
            }).catch((error) => {
                console.error('Có lỗi khi cập nhật loại nguyên liệu: ', error);
            });
        }
    });

    // Function to delete LoaiNguyenLieu
    document.body.addEventListener('click', (e) => {
        if (e.target.classList.contains('removeData')) {
            const loaiNguyenLieuID = e.target.getAttribute('data-id');
            const loaiNguyenLieuRef = ref(database, 'LoaiNguyenLieu/' + loaiNguyenLieuID);
            remove(loaiNguyenLieuRef).then(() => {
                console.log('Xóa thành công loại nguyên liệu!');
                getData();
            }).catch((error) => {
                console.error('Có lỗi khi xóa loại nguyên liệu: ', error);
            });
        }
    });

    // Fetch data when the page loads
    getData();
</script>

<!-- Bootstrap JS & Dependencies -->
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
