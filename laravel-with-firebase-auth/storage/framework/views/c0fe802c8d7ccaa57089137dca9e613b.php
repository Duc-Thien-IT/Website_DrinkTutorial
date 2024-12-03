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
    <h4 class="text-center">Laravel RealTime CRUD Using Google Firebase</h4><br>

    <!-- Add Customer Form -->
    <h5># Add Customer</h5>
    <div class="card card-default">
        <div class="card-body">
            <form id="addCustomer" class="form-inline" method="POST" action="">
                <div class="form-group mb-2">
                    <label for="name" class="sr-only">Name</label>
                    <input id="name" type="text" class="form-control" name="name" placeholder="Name" required autofocus>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" type="email" class="form-control" name="email" placeholder="Email" required autofocus>
                </div>
                <input id="uid" name="uid" type="hidden" value="<?php echo e(\Session::get('uid')); ?>" class="form-control ">
                <button id="submitCustomer" type="button" class="btn btn-primary mb-2">Submit</button>
            </form>
        </div>
    </div>

    <br>

    <!-- Customers Table -->
    <h5># Customers</h5>
    <table class="table table-bordered">
        <tr>
            <th>UID</th>
            <th>Name</th>
            <th>Email</th>
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
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success updateCustomer">Update</button>
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
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light deleteRecord">Delete</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Firebase Scripts -->
<script type="module">
    // Firebase configuration from Laravel
    const firebaseConfig = {
        apiKey: "<?php echo e(config('services.firebase.api_key')); ?>",
        authDomain: "<?php echo e(config('services.firebase.auth_domain')); ?>",
        databaseURL: "<?php echo e(config('services.firebase.database_url')); ?>",
        projectId: "<?php echo e(config('services.firebase.project_id')); ?>",
        storageBucket: "<?php echo e(config('services.firebase.storage_bucket')); ?>",
        messagingSenderId: "<?php echo e(config('services.firebase.messaging_sender_id')); ?>",
        appId: "<?php echo e(config('services.firebase.app_id')); ?>",
        measurementId: "<?php echo e(config('services.firebase.measurement_id')); ?>"
    };

    // Initialize Firebase
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js";
    import { getDatabase, ref, set, get, onValue } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-database.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-analytics.js";

    const app = initializeApp(firebaseConfig);
    const database = getDatabase(app);
    const analytics = getAnalytics(app);

    // Function to fetch customer data
    function getData() {
        const customersRef = ref(database, 'customers/');
        onValue(customersRef, (snapshot) => {
            const value = snapshot.val();
            const htmls = [];
            if (value) {
                Object.keys(value).forEach(key => {
                    htmls.push(`
                        <tr>
                            <td>${value[key].uid}</td>
                            <td>${value[key].name}</td>
                            <td>${value[key].email}</td>
                            <td>
                                <button data-toggle="modal" data-target="#update-modal" class="btn btn-info updateData" data-id="${key}">Update</button>
                                <button data-toggle="modal" data-target="#remove-modal" class="btn btn-danger removeData" data-id="${key}">Delete</button>
                            </td>
                        </tr>
                    `);
                });
                document.getElementById('tbody').innerHTML = htmls.join('');
            }
        });
    }

    // Function to add new customer
    document.getElementById('submitCustomer').addEventListener('click', () => {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const uid = document.getElementById('uid').value;

        if (name && email) {
            const newCustomerRef = ref(database, 'customers/' + uid);
            set(newCustomerRef, {
                uid: uid,
                name: name,
                email: email
            }).then(() => {
                console.log('Customer added successfully!');
                getData();
                document.getElementById('addCustomer').reset();
            }).catch((error) => {
                console.error('Error adding customer: ', error);
            });
        } else {
            alert("Please fill in all fields.");
        }
    });

    // Function to update customer
    let updateID = null;
    document.body.addEventListener('click', (e) => {
        if (e.target && e.target.classList.contains('updateData')) {
            updateID = e.target.getAttribute('data-id');
            const customerRef = ref(database, 'customers/' + updateID);
            get(customerRef).then((snapshot) => {
                const data = snapshot.val();
                document.getElementById('updateBody').innerHTML = `
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">Name</label>
                        <input id="updateName" type="text" class="form-control" value="${data.name}" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-12 col-form-label">Email</label>
                        <input id="updateEmail" type="email" class="form-control" value="${data.email}" required>
                    </div>
                `;
            });
        }
    });

    // Update customer
    document.querySelector('.updateCustomer').addEventListener('click', () => {
        const updatedName = document.getElementById('updateName').value;
        const updatedEmail = document.getElementById('updateEmail').value;

        if (updatedName && updatedEmail) {
            const customerRef = ref(database, 'customers/' + updateID);
            set(customerRef, {
                uid: updateID,
                name: updatedName,
                email: updatedEmail
            }).then(() => {
                console.log('Customer updated successfully!');
                $('#update-modal').modal('hide');
                getData();
            }).catch((error) => {
                console.error('Error updating customer: ', error);
            });
        }
    });

    // Delete customer
    document.body.addEventListener('click', (e) => {
        if (e.target && e.target.classList.contains('removeData')) {
            const customerID = e.target.getAttribute('data-id');
            document.querySelector('.deleteRecord').setAttribute('data-id', customerID);
        }
    });

    // Confirm delete
    document.querySelector('.deleteRecord').addEventListener('click', () => {
        const customerID = document.querySelector('.deleteRecord').getAttribute('data-id');
        const customerRef = ref(database, 'customers/' + customerID);
        set(customerRef, null).then(() => {
            console.log('Customer deleted successfully!');
            $('#remove-modal').modal('hide');
            getData();
        }).catch((error) => {
            console.error('Error deleting customer: ', error);
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
<?php /**PATH C:\Users\Admin\Documents\GitHub\Management_DrinkTutorialApp\laravel-with-firebase-auth\resources\views/customers.blade.php ENDPATH**/ ?>