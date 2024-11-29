<?php include('includes/header.php'); ?>
<!-- Events management page -->
<div class="container mt-4">
    <div class="text-center mb-3">
        <h1>Events Management</h1>
    </div>
    <div class="row mb-3">
    <div class="col-12 col-md-8 mb-2 mb-md-0">
    <!-- <input type="button" name="add_events" id="add_events" value="Add Events"> -->
        <button class="btn btn-primary" id="add_events" style="width: 150px; height: 50px;">Add New Event</button>
    </div>
    <div class="col-12 col-md-4 d-flex justify-content-end">
        <div class="input-group w-100 w-md-auto">
            <input type="text" class="form-control" id="search" placeholder="Search Events" aria-label="Search">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>
    </div>
</div>
    <div class="table-responsive mb-5">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Events Title</th>
                    <th>Events Content</th>
                    <th>Attached File</th>
                    <th>Date</th>
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

<!-- Add data model -->
<div class="model">
    <div id="model-form">
        <h2>Add Events</h2>
        <table cellpaddig="10px"cellspacing="10px" width="100%" id="create_table">
        <form id="eventsForm" method="post" enctype="multipart/form-data">
        <tr>
            <td><span>Event Title</span></td>
            <td><input type='text' name='event_title' id='event_title' placeholder="Enter event title" required></td>
        </tr>
        <tr>
            <td><span>Event Content</span></td>
            <td><input type='text' name='event_content' id='event_content' placeholder="Enter event content" required></td>
        </tr>
        <tr>
            <td><span>Attach File</span></td>
            <td><input type='file' name='event_file' id='event_file' title="Add news file"></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type='submit' value='Add Event' align='center' id='save_events' style="margin-top: 20px; width:70% !important;"></td>
        </tr>
        </form>
        </table>
        <div id="event-error-message"  class="alert alert-danger d-none text-center" role="alert"></div>
        <div id="close-btn" class="close-btn">X</div>
    </div>
</div>

<div class="update_model">
    <div id="model-form" >
        <h2>Update Event Details</h2>
        <form id='eventsUpdateForm' enctype='multipart/form-data'>
            <table cellpaddig="10px"cellspacing="10px" width="100%" id="update_table">
            </table>
        </form>
        <div id="update-event-error-message"  class="alert alert-danger d-none text-center" role="alert"></div>
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
            url: "model/event_management.php",
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
    $(document).on("click", "#add_events", function(){
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
    $("#eventsForm").on("submit", function(event) {
        event.preventDefault();
        var event_title = $("#event_title").val();
        var event_content = $("#event_content").val();
        var eventFile = $("#event_file").val();
        var formData = new FormData(this);
        formData.append("operation", 'create-event');
        formData.append("eventFile", eventFile);
        if(event_title=="" || event_content=="") {
            $("#event-error-message").html("*Event title and content are required.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
            $("#success-message").hide().addClass('d-none');
        } else {
            $.ajax({
                url : "model/event_management.php",
                type : "POST",
                data : formData,
                contentType: false,
                processData: false,
                success : function(data){
                    if(data == 1){
                        $(".model").hide();
                        loadTable();
                        $("#eventsForm").trigger("reset");
                        $("#success-message").html("*Event Added Successfully.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#error-message").addClass('d-none');
                    } else {
                        $("#event-error-message").html(data).removeClass('d-none').slideDown().delay(5000).slideUp(function() {
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
                url : "model/event_management.php",
                type: "POST",
                data:{operation:'delete-data', id : id},
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
            url:"model/event_management.php",
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
    $("#eventsUpdateForm").on("submit", function(event) {
        event.preventDefault();
        var event_title = $("#update_event_title").val();
        var content = $("#update_event_content").val();
        var eventFile = $("#update_event_file").val();
        var formData = new FormData(this);
        formData.append("operation", 'update-data');
        formData.append("eventFile", eventFile);
        if(event_title=="" || content=="") {
            $("#update-event-error-message").html("*Event title and content are required.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                $(this).addClass('d-none');
            });
            $("#success-message").hide().addClass('d-none');
        } else {
            $.ajax({
                url : "model/event_management.php",
                type : "POST",
                data : formData,
                contentType: false,
                processData: false,
                success : function(data){
                    if(data == 1){
                        $(".update_model").hide();
                        loadTable();
                        $("#eventsUpdateForm").trigger("reset");
                        $("#success-message").html("*Event Updated Successfully.").removeClass('d-none').slideDown().delay(5000).slideUp(function() {
                            $(this).addClass('d-none');
                        });
                        $("#error-message").addClass('d-none');
                    } else {
                        $("#update-event-error-message").html(data).removeClass('d-none').slideDown().delay(5000).slideUp(function() {
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
            url:"model/event_management.php",
            type:"POST",
            data:{operation:'search-record', search : search_term},
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