<?php include('includes/header.php'); ?>
<!-- Department management page -->
<div class="container mt-4">
    <div class="text-center mb-3">
        <h1>Department Management</h1>
    </div>
    <div class="row mb-3">
    <div class="col-12 col-md-8 mb-2 mb-md-0">
        <button class="btn btn-primary" id="add_faculty" style="width: 150px; height: 50px;">Add New Faculty</button>
    </div>
    <div class="col-12 col-md-4 d-flex justify-content-end">
        <div class="input-group w-100 w-md-auto">
            <input type="text" class="form-control" id="search" placeholder="Search Faculty" aria-label="Search">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>
    </div>
</div>
    <div class="table-responsive mb-5">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Faculty Name</th>
                    <th>Post</th>
                    <th>Faculty Image</th>
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

<!-- Add new faculty model -->
<div class="model">
    <div id="model-form">
        <h2>Add New Faculty</h2>
        <table cellpaddig="10px"cellspacing="10px" width="100%" id="create_table">
        <form id="facultyForm" method="post" enctype="multipart/form-data">
        <tr>
            <td><span>Department</span></td>
            <td><input type='text' name='department' id='department' placeholder="Enter department" required></td>
        </tr>
        <tr>
            <td><span>Faculty Name</span></td>
            <td><input type='text' name='faculty_name' id='faculty_name' placeholder="Enter faculty name" required></td>
        </tr>
        <tr>
            <td><span>Post</span></td>
            <td><input type='text' name='faculty_post' id='faculty_post' placeholder="Enter faculty post" required></td>
        </tr>
        <tr>
            <td><span>Faculty Image</span></td>
            <td><input type='file' name='faculty_image' id='faculty_image' title="Add faculty  image" alt="No image found"></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type='submit' value='Add Faculty' align='center' id='save_faculty' style="margin-top: 20px; width:70% !important;"></td>
        </tr>
        </form>
        </table>
        <div id="faculty-error-message"  class="alert alert-danger d-none text-center" role="alert"></div>
        <div id="close-btn" class="close-btn">X</div>
    </div>
</div>

<div class="update_model">
    <div id="model-form" >
        <h2>Update Faculty Details</h2>
        <form id='facultyUpdateForm' enctype='multipart/form-data'>
            <table cellpaddig="10px"cellspacing="10px" width="100%" id="update_table">
            </table>
        </form>
        <div id="update-faculty-error-message"  class="alert alert-danger d-none text-center" role="alert"></div>
        <div id="update-close-btn" class="close-btn">X</div>
    </div>
</div>

<!-- JavaScript Code -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    
    // Load records script
    function loadTable(page){
        $.ajax({
            url: "model/department_management.php",
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
    
    // Show create model form script
    $(document).on("click", "#add_faculty", function(){
        $(".model").show();
    });
    // End script

    // Hide create model form script
    $("#close-btn").on("click", function(){
        $('.model').hide();
    })
    // End script

    $('#success-message').delay(3000).fadeOut();

    // Add new faculty script
    $("#facultyForm").on("submit", function(event) {
        event.preventDefault();
        var faculty_name = $("#faculty_name").val();
        var department = $("#department").val();
        var facultyImage = $("#faculty_image").val();
        var formData = new FormData(this);
        formData.append("operation", 'create-faculty');
        formData.append("facultyImage", facultyImage);
        if(faculty_name=="" || department=="") {
            $("#faculty-error-message").html("*Faculty name and department are required.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
            $("#success-message").hide().addClass('d-none');
        } else {
            $.ajax({
                url : "model/department_management.php",
                type : "POST",
                data : formData,
                contentType: false,
                processData: false,
                success : function(data){
                    if(data == 1){
                        $(".model").hide();
                        loadTable();
                        $("#facultyForm").trigger("reset");
                        $("#success-message").html("*New Faculty Added Successfully.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#error-message").addClass('d-none');
                    } else {
                        $("#faculty-error-message").html(data).removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#success-message").hide().addClass('d-none');
                    }
                }
            });
        }
    });
    // End script

    // Delete faculty script
    $(document).on("click", ".delete-btn", function() {
        if(confirm("Do you really want to delete this record?")) {
            var id = $(this).data("id");
            var element = this;
            $.ajax({
                url : "model/department_management.php",
                type: "POST",
                data:{operation:'delete-faculty', id : id},
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

    // Show update model form script
    $(document).on("click", ".edit-btn", function(){
        $(".update_model").show();
        var id = $(this).data("id");
        $.ajax({
            url:"model/department_management.php",
            type : "POST",
            data : {operation:'load-update-data', id:id},
            success: function(data) {
                $(".update_model #model-form table").html(data);
            }
        });
    });
    // End script

    // Hide update model box
    $("#update-close-btn").on("click", function(){
        $('.update_model').hide();
    })
    // End to hide update model box

    // Save Update form data
    $("#facultyUpdateForm").on("submit", function(event) {
        event.preventDefault();
        var faculty_name = $("#update_faculty_name").val();
        var department = $("#update_department").val();
        var facultyImage = $("#update_faculty_image").val();
        var formData = new FormData(this);
        formData.append("operation", 'update-data');
        formData.append("facultyImage", facultyImage);
        if(faculty_name=="" || department=="") {
            $("#update-faculty-error-message").html("*Faculty name and department are required.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
            $("#success-message").hide().addClass('d-none');
        } else {
            $.ajax({
                url : "model/department_management.php",
                type : "POST",
                data : formData,
                contentType: false,
                processData: false,
                success : function(data){
                    if(data == 1){
                        $(".update_model").hide();
                        loadTable();
                        $("#facultyUpdateForm").trigger("reset");
                        $("#success-message").html("*Faculty Data Updated Successfully.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#error-message").addClass('d-none');
                    } else {
                        $("#update-faculty-error-message").html(data).removeClass('d-none').slideDown().delay(5000).slideUp(function() {
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
            url:"model/department_management.php",
            type:"POST",
            data:{operation:'search-faculty', search : search_term},
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
