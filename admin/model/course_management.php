<?php
include '../database.php';
if(isset($_POST['operation'])) {
    $operation = $_POST['operation'];

    // Load records 
    if($operation == 'load-data') {
        if(isset($_POST['page'])) {
            $page = $_POST['page'];
        } else {
            $page = 1;
        }
        
        $limit = 10;
        $offset = ($page-1)*$limit;
        $sql = "SELECT * FROM courses ORDER BY id ASC LIMIT {$offset},{$limit}";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $output.="<tr>
                            <td align='center'>{$row['course_name']}</td>
                            <td align='center'>{$row['course_description']}</td>
                            <td align='center'><img src='".$row['course_image']."' alt='Course Image'  style=' height:100px; width:100px'></td>
                            <td align='center'><button class='edit-btn btn btn-warning' data-id='{$row['id']}' title='Update Course'><i class='fa fa-edit'></button></td>
                            <td align='center'><button class='delete-btn btn btn-danger' data-id='{$row['id']}' title='Delete Course'><i class='fa fa-trash-o'></button></td>
                        </tr>";                              
            }
            // Start pagination script
            $sql1 = "SELECT * FROM courses";
            $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
            if(mysqli_num_rows($result1) > 0) {
                $total_records = mysqli_num_rows($result1);
                $total_pages = ceil($total_records / $limit);
                $output .= "<tr p-5><td colspan=5><ul class='pagination admin-pagination'>";
                if($page > 1) {
                    $output.="<li><a class='page-link' href='#' data-page=".($page-1).">Prev</a></li>";
                }
                for($i=1; $i<=$total_pages; $i++) {
                    if($page == $i) {
                        $active = "active";
                    } else {
                        $active = "";
                    }
                    $output.="<li class='{$active}'><a class='page-link' href='#' data-page={$i}>{$i}</a></li>";
                }
                if($total_pages > $page) {
                    $output.="<li><a class='page-link' href='#' data-page=".($page+1).">Next</a></li>";
                }
                $output.="</ul></td></tr>";
            }
        } else {
            $output.="<td colspan='4'>No Record Found</td>";
        }
        echo $output;
            
    }
    // End to load records 
    
    // insert new data
    if($operation == 'create-course') {
        $course_name        = $_POST['course_name'];
        $courseImage        = $_POST['course_image'];
        $course_description = $_POST['course_description'];
        // Initialize image-related variables
        if($courseImage != "") {
            $targetDir = "course-images/";
            $targetFile = $targetDir . basename($_FILES["course_image"]["name"]);
            $fileError = 0;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $fileError = "";

            // Check if image file is a real image or fake image
            $check = getimagesize($_FILES["course_image"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                return;
            }

            // Check file size must be less then 5 MB
            if ($_FILES["course_image"]["size"] > (1024*1024*5)) {
                echo "Sorry, your file is too large (file must be less than 5MB).";
                return;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                return;
            }

            if (move_uploaded_file($_FILES["course_image"]["tmp_name"], $targetFile)) {
                $sql ="INSERT INTO courses (course_name, course_description, course_image) VALUES ('{$course_name}', '{$course_description}', '{$targetFile}')";
                if(mysqli_query($conn, $sql)) {
                    echo 1;
                } else {
                    echo "Sorry, course can't add.";
                }
            }
        } else {
            $sql ="INSERT INTO courses (course_name, course_description) VALUES ('{$course_name}', '{$course_description}')";
            if(mysqli_query($conn, $sql)) {
                echo 1;
            } else {
                echo "Sorry, course can't add.";
            }
        }
    }
    // End script
    
    // Delete course
    if($operation == 'delete-course') {
        $id  = $_POST['id'];
        $selectImage = "SELECT course_image FROM courses WHERE id={$id}";
        $imageExist = mysqli_query($conn, $selectImage);
        if(mysqli_num_rows($imageExist) > 0) {
            $imagePath =  mysqli_fetch_assoc($imageExist);
            if($imagePath['course_image'] != "course-images/default_course_image.png") {
                unlink($imagePath['course_image']);
            }
        }
        $sql = "DELETE FROM courses WHERE id={$id}";
        if(mysqli_query($conn, $sql)) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // End script

    // Load update form record
    if($operation =='load-update-data') {
        $id = $_POST['id'];
        $sql = "SELECT * FROM courses WHERE id={$id}";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        if(mysqli_num_rows($result) > 0) {
            $output = '';
            while($row = mysqli_fetch_assoc($result)) {
                $output.="
                    <tr>
                        <td><span>Course Name</span></td>
                        <td><input type='text' name='course_name' id='update_course_name' value='{$row["course_name"]}'>
                            <input type='text'name='course_id'  id='course_id' hidden value='{$row["id"]}'>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Course Description</span></td>
                        <td><input type='text' name='course_description' id='update_course_description' value='{$row["course_description"]}'></td>
                    </tr>
                    <tr>
                        <td><span>Course Image</span></td>
                        <td><input type='file' name='update_course_image' id='update_course_image' value='{$row["course_image"]}'></td>
                    </tr>            
                    
                    <tr>
                        <td colspan='2' align='center'><input type='submit' value='Update' id='update_course'  style='margin-top: 20px; width:70% !important;'></td>
                    </tr>";
            }
            mysqli_close($conn);
            echo $output;
        } else {
            echo "<h2>No Record Found</h2>";
        }
    }
    // End script

    // Update course data
    if($operation == 'update-data') {
        $courseId           = $_POST['course_id'];
        $course_name        = $_POST['course_name'];
        $course_description = $_POST['course_description'];
        $courseImage        = $_POST['course_image'];

        // Initialize image-related variables
        if($courseImage != "") {
            $targetDir = "course-images/";
            $targetFile = $targetDir . basename($_FILES["update_course_image"]["name"]);
            $fileError = 0;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $fileError = "";

            // Check if image file is a real image or fake image
            $check = getimagesize($_FILES["update_course_image"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                return;
            }

            // Check file size must be less then 5 MB
            if ($_FILES["update_course_image"]["size"] > 500000) {
                echo "Sorry, your file is too large (file must be less than 5MB).";
                return;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                return;
            }
            // Delete image from folder
            $selectImage = "SELECT course_image FROM courses WHERE id={$courseId}";
            $imageExist = mysqli_query($conn, $selectImage);
            if(mysqli_num_rows($imageExist) > 0) {
                $imagePath =  mysqli_fetch_assoc($imageExist);
                if($imagePath['course_image'] != "course-images/default_course_image.png") {
                    unlink($imagePath['course_image']);
                }
            }

            if (move_uploaded_file($_FILES["update_course_image"]["tmp_name"], $targetFile)) {
                $sql ="UPDATE courses SET course_name='{$course_name}', course_description='{$course_description}', course_image='{$targetFile}' WHERE id={$courseId}";
                if(mysqli_query($conn, $sql)) {
                    echo 1;
                } else {
                    echo "Sorry, course can't update.";
                }
            }
        } else {
            $sql ="UPDATE courses SET course_name='{$course_name}', course_description='{$course_description}' WHERE id={$courseId}";
            if(mysqli_query($conn, $sql)) {
                echo 1;
            } else {
                echo "Sorry, course can't update.";
            }
        }
    }

    // End script
    
    // Search records
    if($operation == 'search-course') {
        $search_value = $_POST["search"];

        $sql = "SELECT * FROM courses WHERE course_name LIKE '%{$search_value}%' OR course_description LIKE '%{$search_value}%'";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $output.="<tr>
                            <td align='center'>{$row['course_name']}</td>
                            <td align='center'>{$row['course_description']}</td>
                            <td align='center'><img src='".$row['course_image']."' alt='Course Image'  style=' height:100px; width:100px'></td>
                            <td align='center'><button class='edit-btn btn btn-warning' data-id='{$row['id']}' title='Update Course'><i class='fa fa-edit'></button></td>
                            <td align='center'><button class='delete-btn btn btn-danger' data-id='{$row['id']}' title='Delete Course'><i class='fa fa-trash-o'></button></td>
                        </tr>";
            }
            mysqli_close($conn);
            echo $output;
        } else {
            echo "<td colspan='4'>No Record Found</td>";
        }
    }
    // End script

}
    
?>