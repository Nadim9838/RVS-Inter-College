<?php include('includes/header.php'); ?>
<!-- Course management page -->
<div class="container mt-4">
    <div class="text-center mb-3">
        <h1>Course Management</h1>
    </div>
    <div class="row mb-3">
    <div class="col-12 col-md-8 mb-2 mb-md-0">
        <button class="btn btn-primary" id="add_course" style="width: 150px; height: 50px;">Add New Course</button>
    </div>
    <div class="col-12 col-md-4 d-flex justify-content-end">
        <div class="input-group w-100 w-md-auto">
            <input type="text" class="form-control" id="search" placeholder="Search Courses" aria-label="Search">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>
    </div>
</div>
    <div class="table-responsive mb-5">
        <table class="table table-bordered table-striped text-center">
            <thead>
                        <tr>
                            <th>Course Name</th>
                            <th>Course Descriptions</th>
                            <th>Course Image</th>
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

<!-- Add new course model -->
<div class="model">
    <div id="model-form">
        <h2>Add New Course</h2>
        <table cellpaddig="10px"cellspacing="10px" width="100%" id="create_table">
        <form id="courseForm" method="post" enctype="multipart/form-data">
        <tr>
            <td><span>Course Name</span></td>
            <td><input type='text' name='course_name' id='course_name' placeholder="Enter course name" required></td>
        </tr>
        <tr>
            <td><span>Course Description</span></td>
            <td><input type='text' name='course_description' id='course_description' placeholder="Enter course description" required></td>
        </tr>
        <tr>
            <td><span>Course Image</span></td>
            <td><input type='file' name='course_image' id='course_image' title="Choose course image" ></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type='submit' value='Add Course' align='center' id='save_course' style="margin-top: 20px; width:70% !important;"></td>
        </tr>
        </form>
        </table>
        <div id="course-error-message" class="alert alert-danger d-none text-center" role="alert"></div>
        <div id="close-btn" class="close-btn">X</div>
    </div>
</div>

<div class="update_model">
    <div id="model-form" >
        <h2>Update Course Details</h2>
        <form id='courseUpdateForm' enctype='multipart/form-data'>
            <table cellpaddig="10px"cellspacing="10px" width="100%" id="update_table">
            </table>
        </form>
        <div id="update-course-error-message" class="alert alert-danger d-none text-center" role="alert"></div>
        <div id="update-close-btn" class="close-btn">X</div>
    </div>
</div>

<!-- JavaScript Code -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    
    // Load course records script
    function loadTable(page){
        $.ajax({
            url: "model/course_management.php",
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
    
    // Show create course model form script
    $(document).on("click", "#add_course", function(){
        $(".model").show();
    });
    // End script

    // Hide create course model form script
    $("#close-btn").on("click", function(){
        $('.model').hide();
    })
    // End script

    $('#success-message').delay(5000).fadeOut();

    // Add new course script
    $("#courseForm").on("submit", function(event) {
        event.preventDefault();
        var course_name = $("#course_name").val();
        var course_description = $("#course_description").val();
        var courseImage = $("#course_image").val();
        var formData = new FormData(this);
        formData.append("operation", 'create-course');
        formData.append("course_image", courseImage);
        if(course_name=="" || course_description=="") {
            $("#course-error-message").html("*Course name and description are required.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
            $("#success-message").hide().addClass('d-none');
        } else {
            $.ajax({
                url : "model/course_management.php",
                type : "POST",
                data : formData,
                contentType: false,
                processData: false,
                success : function(data){
                    if(data == 1){
                        $(".model").hide();
                        loadTable();
                        $("#courseForm").trigger("reset");
                        $("#success-message").html("*Course Added Successfully.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#error-message").addClass('d-none');
                    } else {
                        // alert(data);
                        $("#course-error-message").html(data).removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });

                        $("#success-message").addClass('d-none');
                    }
                }
            });
        }
    });
    // End script

    // Delete course script
    $(document).on("click", ".delete-btn", function() {
        if(confirm("Do you really want to delete this record?")) {
            var id = $(this).data("id");
            var element = this;
            $.ajax({
                url : "model/course_management.php",
                type: "POST",
                data:{operation:'delete-course', id : id},
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
                        $("#success-message").addClass('d-none');
                    }
                }

            });
        }
    });
    // End script

    // Show update course in model form script
    $(document).on("click", ".edit-btn", function(){
        $(".update_model").show();
        var id = $(this).data("id");
        $.ajax({
            url:"model/course_management.php",
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
    // End to update model box

    // Save Update form data
    $("#courseUpdateForm").on("submit", function(event) {
        event.preventDefault();
        var course_name = $("#update_course_name").val();
        var course_description = $("#update_course_description").val();
        var courseImage = $("#update_course_image").val();
        var formData = new FormData(this);
        formData.append("operation", 'update-data');
        formData.append("course_image", courseImage);
        if(course_name=="" || course_description=="") {
            $("#update-course-error-message").html("*Course name and description are required.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
            $("#success-message").addClass('d-none');
        } else {
            $.ajax({
                url : "model/course_management.php",
                type : "POST",
                data : formData,
                contentType: false,
                processData: false,
                success : function(data){
                    if(data == 1){
                        $(".update_model").hide();
                        loadTable();
                        $("#courseUpdateForm").trigger("reset");
                        $("#success-message").html("*Course Updated Successfully.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#error-message").addClass('d-none');
                    } else {
                        $("#update-course-error-message").html(data).removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#success-message").addClass('d-none');
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
            url:"model/course_management.php",
            type:"POST",
            data:{operation:'search-course', search : search_term},
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
