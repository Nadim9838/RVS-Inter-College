<?php include('includes/header.php'); ?>
<!-- Gallery management page -->
<div class="container mt-4">
    <div class="text-center mb-3">
        <h1>Gallery Management</h1>
    </div>
    <div class="row mb-3">
    <div class="col-12 col-md-8 mb-2 mb-md-0">
        <button class="btn btn-primary" id="gallery_image" style="width: 150px; height: 50px;">Add New Image</button>
    </div>
    <div class="col-12 col-md-4 d-flex justify-content-end"> </div>
</div>
    <div class="table-responsive mb-5">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Gallery Images</th>
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

<!-- Add new gallery image model -->
<div class="model">
    <div id="model-form">
        <h2>Add Gallery Picture</h2>
        <table cellpaddig="10px"cellspacing="10px" width="100%" id="create_table">
        <form id="imageForm" method="post" enctype="multipart/form-data">
        <tr>
            <td><span>Gallery Image</span></td>
            <td style="float: right;"><input type='file' name='gallery_image' id='gallery_input' title="Choose gallery image" required></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type='submit' value='Add Gallery Image' align='center' id='save_gallery_image' style="margin-top: 20px; width:70% !important;"></td>
        </tr>
        </form>
        </table>
        <div id="gallery-error-message"  class="alert alert-danger d-none text-center" role="alert"></div>
        <div id="close-btn" class="close-btn">X</div>
    </div>
</div>

<div class="update_model">
    <div id="model-form" >
        <h2>Update Gallery Picture</h2>
        <form id="imageUpdateForm" method="post" enctype="multipart/form-data">
            <table cellpaddig="10px"cellspacing="10px" width="100%" id="update_table">
            </table>
        </form>
        <div id="update-gallery-error-message"  class="alert alert-danger d-none text-center" role="alert"></div>
        <div id="update-close-btn" class="close-btn">X</div>
    </div>
</div>

<!-- JavaScript Code -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    
    // Load gallery image records script
    function loadTable(page){
        $.ajax({
            url: "model/gallery_management.php",
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
    $(document).on("click", "#gallery_image", function(){
        $(".model").show();
    });
    // End script

    // Hide create model form script
    $("#close-btn").on("click", function(){
        $('.model').hide();
    })
    // End script

    $('#success-message').delay(3000).fadeOut();

    // Add new gallery image
    $("#imageForm").on("submit", function(event) {
        event.preventDefault();
        var imageExist = $("#gallery_input").val();
        var formData = new FormData(this);
        formData.append("operation", 'add-image');
        if(imageExist == "") {
            $("#gallery-error-message").html("*Please select image.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
            $("#success-message").hide().addClass('d-none');
        } else {
            $.ajax({
                url : "model/gallery_management.php",
                type : "POST",
                data : formData,
                contentType: false,
                processData: false,
                success : function(data){
                    if(data == 1){
                        $(".model").hide();
                        loadTable();
                        $("#imageForm").trigger("reset");
                        $("#success-message").html("*Image Added Successfully.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#error-message").addClass('d-none');
                    } else {
                        $("#gallery-error-message").html(data).removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#success-message").hide().addClass('d-none');
                    }
                }
            });
        }
    });
    // End script

    // Delete data script
    $(document).on("click", ".delete-btn", function() {
        if(confirm("Do you really want to delete this record?")) {
            var id = $(this).data("id");
            var element = this;
            $.ajax({
                url : "model/gallery_management.php",
                type: "POST",
                data:{operation:'delete-image', id : id},
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
            url:"model/gallery_management.php",
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
    
    // Save Updated form data
    $("#imageUpdateForm").on("submit", function(event) {
        event.preventDefault();
        var galleryImage = $("#update_image").val();
        var update_image_id = $("#update_image_id").val();
        var formData = new FormData(this);
        formData.append("operation", 'update-data');
        formData.append("galleryImage", galleryImage);
        if(galleryImage=="") {
            $("#update-gallery-error-message").html("*Please choose picture.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
            $("#success-message").hide().addClass('d-none');
        } else {
            $.ajax({
                url : "model/gallery_management.php",
                type : "POST",
                data : formData,
                contentType: false,
                processData: false,
                success : function(data){
                    if(data == 1){
                        $(".update_model").hide();
                        loadTable();
                        $("#courseUpdateForm").trigger("reset");
                        $("#success-message").html("*Gallery Image Updated Successfully.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#error-message").addClass('d-none');
                    } else {
                        $("#update-gallery-error-message").html(data).slideDown().removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#success-message").hide().addClass('d-none');
                    }
                }
            });
        }
    });
    // End script

});
</script>

<!-- Include footer section file -->
<?php include('includes/footer.php'); ?>
