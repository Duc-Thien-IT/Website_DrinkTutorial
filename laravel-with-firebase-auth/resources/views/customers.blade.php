<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <title>Laravel RealTime CRUD Using Google Firebase</title>
</head>
<body>

<div class="container" style="margin-top: 50px;">
    <h4 class="text-center">Quản Lý Người Dùng</h4><br>

    <!-- Add Customer Form -->
    <h5>Thêm Mới Người Dùng</h5>
    <div class="card card-default">
        <div class="card-body">
            <form id="addUser" class="form-inline" method="POST" action="">
                <div class="form-group mb-2">
                    <label for="hoTen" class="sr-only">Họ Tên</label>
                    <input id="hoTen" type="text" class="form-control" name="hoTen" placeholder="Họ Tên" required autofocus>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="matKhau" class="sr-only">Mật Khẩu</label>
                    <input id="matKhau" type="password" class="form-control" name="matKhau" placeholder="Mật Khẩu" required>
                </div>
                <input id="uid" name="uid" type="hidden" value="{{ \Session::get('uid') }}" class="form-control ">
                <button id="submitUser" type="button" class="btn btn-primary mb-2">Thêm</button>
            </form>
        </div>
    </div>

    <br>

    <!-- Users Table -->
    <h5>Danh Sách Người Dùng</h5>
    <table class="table table-bordered">
        <tr>
            <th>UID</th>
            <th>Họ Tên</th>
            <th>Email</th>
            <th>Mật Khẩu</th>
            <th width="180" class="text-center">Action</th>
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
                    <h4 class="modal-title" id="custom-width-modalLabel">Update</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body" id="updateBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success updateUser">Lưu</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Delete Modal -->
<form action="" method="POST" class="users-remove-record-model">
    <div id="remove-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Delete</h4>
                    <button type="button" class="close remove-data-from-delete-form" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>Do you want to delete this record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light deleteRecord">Xóa</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Firebase Scripts -->
<script type="module">
    // Firebase configuration from Laravel
    const firebaseConfig = {
        apiKey: "{{ config('services.firebase.api_key') }}",
        authDomain: "{{ config('services.firebase.auth_domain') }}",
        databaseURL: "{{ config('services.firebase.database_url') }}",
        projectId: "{{ config('services.firebase.project_id') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') }}",
        messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
        appId: "{{ config('services.firebase.app_id') }}",
        measurementId: "{{ config('services.firebase.measurement_id') }}"
    };

    // Initialize Firebase
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js";
    import { getDatabase, ref, set, get, onValue } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-database.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-analytics.js";

    const app = initializeApp(firebaseConfig);
    const database = getDatabase(app);
    const analytics = getAnalytics(app);

    // Function to fetch user data
    function getData() {
        const usersRef = ref(database, 'NguoiDung/');
        onValue(usersRef, (snapshot) => {
            const value = snapshot.val();
            const htmls = [];
            if (value) {
                Object.keys(value).forEach(key => {
                    htmls.push(`
                        <tr>
                            <td>${key}</td>
                            <td>${value[key].hoTen}</td>
                            <td>${value[key].email}</td>
                            <td>${value[key].matKhau}</td>
                            <td>
                                <button data-toggle="modal" data-target="#update-modal" class="btn btn-info updateData" data-id="${key}">Cập Nhật</button>
                                <button data-toggle="modal" data-target="#remove-modal" class="btn btn-danger removeData" data-id="${key}">Xóa</button>
                            </td>
                        </tr>
                    `);
                });
                document.getElementById('tbody').innerHTML = htmls.join('');
            }
        });
    }

    // Function to add new user
    document.getElementById('submitUser').addEventListener('click', () => {
        const hoTen = document.getElementById('hoTen').value;
        const email = document.getElementById('email').value;
        const matKhau = document.getElementById('matKhau').value;
        const uid = document.getElementById('uid').value || Date.now().toString();

        if (hoTen && email && matKhau) {
            const newUserRef = ref(database, 'NguoiDung/' + uid);
            set(newUserRef, {
                hoTen: hoTen,
                email: email,
                matKhau: matKhau
            }).then(() => {
                console.log('User added successfully!');
                getData();
                document.getElementById('addUser').reset();
            }).catch((error) => {
                console.error('Error adding user: ', error);
            });
        } else {
            alert("Please fill in all fields.");
        }
    });

    // Function to update user
    let updateID = null;
    document.body.addEventListener('click', (e) => {
        if (e.target && e.target.classList.contains('updateData')) {
            updateID = e.target.getAttribute('data-id');
            const userRef = ref(database, 'NguoiDung/' + updateID);
            get(userRef).then((snapshot) => {
                const data = snapshot.val();
                document.getElementById('updateBody').innerHTML = `
                    <div class="form-group">
                        <label for="hoTen" class="col-md-12 col-form-label">Họ Tên</label>
                        <input id="updateHoTen" type="text" class="form-control" value="${data.hoTen}" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-12 col-form-label">Email</label>
                        <input id="updateEmail" type="email" class="form-control" value="${data.email}" required>
                    </div>
                    <div class="form-group">
                        <label for="matKhau" class="col-md-12 col-form-label">Mật Khẩu</label>
                        <input id="updateMatKhau" type="text" class="form-control" value="${data.matKhau}" required>
                    </div>
                `;
            });
        }
    });

    // Update user
    document.querySelector('.updateUser').addEventListener('click', () => {
        const updatedHoTen = document.getElementById('updateHoTen').value;
        const updatedEmail = document.getElementById('updateEmail').value;
        const updatedMatKhau = document.getElementById('updateMatKhau').value;

        if (updatedHoTen && updatedEmail && updatedMatKhau) {
            const userRef = ref(database, 'NguoiDung/' + updateID);
            set(userRef, {
                hoTen: updatedHoTen,
                email: updatedEmail,
                matKhau: updatedMatKhau
            }).then(() => {
                console.log('User updated successfully!');
                $('#update-modal').modal('hide');
                getData();
            }).catch((error) => {
                console.error('Error updating user: ', error);
            });
        }
    });

    // Delete user
    document.body.addEventListener('click', (e) => {
        if (e.target && e.target.classList.contains('removeData')) {
            const userID = e.target.getAttribute('data-id');
            document.querySelector('.deleteRecord').setAttribute('data-id', userID);
        }
    });

    // Confirm delete
    document.querySelector('.deleteRecord').addEventListener('click', () => {
        const userID = document.querySelector('.deleteRecord').getAttribute('data-id');
        const userRef = ref(database, 'NguoiDung/' + userID);
        set(userRef, null).then(() => {
            console.log('User deleted successfully!');
            $('#remove-modal').modal('hide');
            getData();
        }).catch((error) => {
            console.error('Error deleting user: ', error);
        });
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
