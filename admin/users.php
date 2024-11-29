<?php include('includes/header.php'); ?>
<!-- Admin user page -->
<div class="container mt-4">
    <div class="text-center mb-3">
        <h1>User Management</h1>
    </div>
    <div class="row mb-3">
    <div class="col-12 col-md-8 mb-2 mb-md-0">
        <button class="btn btn-primary" id="create_user" style="width: 150px; height: 50px;">Add New User</button>
    </div>
    <div class="col-12 col-md-4 d-flex justify-content-end">
        <div class="input-group w-100 w-md-auto">
            <input type="text" class="form-control" id="search" placeholder="Search Users" aria-label="Search">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>
    </div>
</div>
    <div class="table-responsive mb-5">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Create At</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody id="table-data">
                <!-- Data from the database will be shown here -->
            </tbody>
            <!-- Show error and success message -->
            <div id="error-message" class="alert alert-danger d-none text-center" role="alert"></div>
            <div id="success-message" class="alert alert-success d-none text-center" role="alert"></div>
        </table>
    </div>
</div>


<!-- Create user record model -->
<div class="model">
    <div id="model-form">
        <h2>Add New User</h2>
        <table cellpaddig="10px"cellspacing="10px" width="100%" id="create_table">
        <tr>
            <td><span>Username</span></td>
            <td><input type='text' name='username' autofocus id='username' placeholder="Enter username" required></td>
        </tr>
        <tr>
            <td><span>Name</span></td>
            <td><input type='text' name='name' id='name' placeholder="Enter name" required></td>
        </tr>
        <tr>
            <td><span>Email</span></td>
            <td><input type='email' name='email' id='email' placeholder="Enter email" required></td>
        </tr>
        <tr>
            <td><span>Mobile</span></td>
            <td><input type='text' name='phone' id='phone' placeholder="Enter phone number"></td>
        </tr>
        <tr>
            <td><span>Password</span></td>
            <td><input type='password' name='password' id='password' placeholder="Enter password" required></td>
        </tr>
        <tr>
            <td><span>Confirm Password</span></td>
            <td><input type='password' name='cpassword' id='cpassword' placeholder="Enter confirm password" required></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type='submit' value='Save' align='center' id='save_user_data' style="margin-top: 20px; width:70% !important;"></td>
        </tr>
        </table>
        <div id="create-user-error-message"  class="alert alert-danger d-none text-center" role="alert"></div>
        <div id="create-close-btn" class="close-btn">X</div>
    </div>
</div>

<div class="update_model">
    <div id="model-form" >
        <h2>Update Admin User</h2>
        <table cellpaddig="10px"cellspacing="10px" width="100%" id="update_table">
        </table>
        <div id="update-user-error-message"  class="alert alert-danger d-none text-center" role="alert"></div>
        <div id="update-close-btn" class="close-btn">X</div>
    </div>
</div>

<!-- JavaScript Code -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    
    // Load user records script
    function loadTable(page){
        $.ajax({
            url: "model/user_management.php",
            type: "POST",
            data: {operation:'load-data', page: page},
            success: function(data) {
                $("#table-data").html(data);
            }
        });
    }
    loadTable(1);
    // End script

    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadTable(page);
    });
    
    // Show create user model form script
    $(document).on("click", "#create_user", function(){
        $(".model").show();
    });
    // End script

    // Hide create user model form script
    $("#create-close-btn").on("click", function(){
        $('.model').hide();
    })
    // End script

    $('#success-message').delay(3000).fadeOut();

    // Insert new admin user record script
    $(document).on("click", "#save_user_data", function(e) {
        e.preventDefault();
        var uname = $("#username").val();
        var name = $("#name").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var password = $("#password").val();
        var cpassword = $("#cpassword").val();
        // to validate email regular expression
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        // to validate phone number
        var phoneRegex = /^\d{10}$/; 
        if(uname=="" || name=="" || email=="" || phone=="" || password=="" || cpassword=="") {
            $("#create-user-error-message").html("*All fields are required.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
        } else if(password !== cpassword) {
            $("#create-user-error-message").html("*Password and confirm password must be same.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
        } else if (!emailRegex.test(email)) {
            $("#create-user-error-message").html("*Please enter valid email.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
        } else if(!phoneRegex.test(phone)) {
            $("#create-user-error-message").html("*Please enter 10 digit phone number.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
        } else {
            $.ajax({
                url : "model/user_management.php",
                type : "POST",
                data : {operation:'create-user', uname:uname, name:name, email:email, password:password, phone:phone},
                success : function(data){
                    if(data == 1){
                        $(".model").hide();
                        loadTable();
                        $("#addForm").trigger("reset");
                        $("#success-message").html("*Data Inserted Successfully.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#error-message").addClass('d-none');
                    } else {
                        $("#create-user-error-message").html("*Username already exist.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#success-message").hide().addClass('d-none');
                    }
                }
            });
        }
    });
    // End script

    // Delete user record script
    $(document).on("click", ".delete-btn", function() {
        if(confirm("Do you really want to delete this record?")) {
            var userId = $(this).data("id");
            var element = this;
            $.ajax({
                url : "model/user_management.php",
                type: "POST",
                data:{operation:'delete-user', id : userId},
                success : function(data){
                    if(data==1){
                        $(element).closest("tr").fadeOut();
                        $("#success-message").html("*Data Deleted Successfully.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#error-message").addClass('d-none');
                    } else {
                        $("#error-message").html("*Can't Delete Record.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#success-message").hide().addClass('d-none');
                    }
                }

            });
        }
    });
    // End script

    // Show update user model form script
    $(document).on("click", ".edit-btn", function(){
        $(".update_model").show();
        var userId = $(this).data("id");
        $.ajax({
            url:"model/user_management.php",
            type : "POST",
            data : {operation:'load-update-user', id:userId},
            success: function(data) {
                $(".update_model #model-form table").html(data);
            }
        });
    });
    // End script

    // Hide update user model box
    $("#update-close-btn").on("click", function(){
        $('.update_model').hide();
    })
    // End to hide update user model box

    // Save Update form data
    $(document).on("click", "#update_user_data", function(){
        var userId = $("#user_id").val();
        var uname = $("#update_uname").val();
        var name = $("#update_name").val();
        var email = $("#update_email").val();
        var phone = $("#update_phone").val();
        var password = $("#update_password").val();
        // to validate email regular expression
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        // to validate phone number
        var phoneRegex = /^\d{10}$/; 
        if(uname=="" || name=="" || email=="" || phone=="" || password=="") {
            $("#update-user-error-message").html("*All fields are required.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
            $("#success-message").hide().addClass('d-none');
        } else if (!emailRegex.test(email)) {
            $("#update-user-error-message").html("*Please enter valid email.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
            $("#success-message").hide().addClass('d-none');
        } else if(!phoneRegex.test(phone)) {
            $("#update-user-error-message").html("*Please enter 10 digit phone number.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
            $("#success-message").hide().addClass('d-none');
        } else {
            $.ajax({
                url : "model/user_management.php",
                type : "POST",
                data : {operation:'update-user', id:userId, uname:uname, name:name, email:email, phone:phone, password:password},
                success : function(data){
                    if(data == 1){
                        $(".update_model").hide();
                        loadTable();
                        $("#success-message").html("*Data Updated Successfully.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#error-message").addClass('d-none');
                    } else {
                        $("#update-user-error-message").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#success-message").hide().addClass('d-none');
                    }
                }
            });
        }
    });
    // End script

    // Live Search script
    $("#search").on("keyup", function(){
        var search_term = $(this).val();
        $.ajax({
            url:"model/user_management.php",
            type:"POST",
            data:{operation:'search-user', search : search_term},
            success: function(data){
                $("#table-data").html(data);
            }
        });
    })
    // End script
});
</script>

<!-- Include footer section file -->
<?php include('includes/footer.php'); ?>
