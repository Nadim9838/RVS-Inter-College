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
        $sql = "SELECT * FROM department ORDER BY id ASC LIMIT {$offset},{$limit}";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $output.="<tr style='background: transparent'>
                            <td align='center'>{$row['department']}</td>
                            <td align='center'>{$row['faculty_name']}</td>
                            <td align='center'>{$row['post']}</td>
                            <td align='center'><img src='faculty-image/".$row['faculty_image']."' alt='No image found'  style=' height:100px; width:100px'></td>
                            <td align='center'><button class='edit-btn btn btn-warning' data-id='{$row['id']}' title='Update Faculty'><i class='fa fa-edit'></button></td>
                            <td align='center'><button class='delete-btn btn btn-danger' data-id='{$row['id']}' title='Delete Faculty'><i class='fa fa-trash-o'></button></td>
                        </tr>";
            }
            // Start pagination script
            $sql1 = "SELECT * FROM department";
            $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
            if(mysqli_num_rows($result1) > 0) {
                $total_records = mysqli_num_rows($result1);
                $total_pages = ceil($total_records / $limit);
                $output .= "<tr p-5><td colspan=6><ul class='pagination admin-pagination'>";
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
            $output.="<td colspan='5'>No Record Found</td>";
        }
        echo $output;
            
    }
    // End to load records 
    
    // insert new data
    if($operation == 'create-faculty') {
        $faculty_name = $_POST['faculty_name'];
        $faculty_post = $_POST['faculty_post'];
        $department   = $_POST['department'];
        $facultyImage = $_POST['facultyImage'];
        // Initialize image-related variables
        if($facultyImage != "") {
            $targetDir = "../faculty-images/";
            $targetFile = $targetDir . basename($_FILES["faculty_image"]["name"]);
            $fileError = 0;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $fileError = "";

            // Check if image file is a real image or fake image
            $check = getimagesize($_FILES["faculty_image"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                return;
            }

            // Check file size must be less then 5 MB
            if ($_FILES["faculty_image"]["size"] > (1024*1024*5)) {
                echo "Sorry, your file is too large (file must be less than 5MB).";
                return;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                return;
            }

            if (move_uploaded_file($_FILES["faculty_image"]["tmp_name"], $targetFile)) {
                $sql ="INSERT INTO department (faculty_name, post, department, faculty_image) VALUES ('{$faculty_name}', '{$faculty_post}', '{$department}', '{$targetFile}')";
                if(mysqli_query($conn, $sql)) {
                    echo 1;
                } else {
                    echo "Sorry, course can't add.";
                }
            }
        } else {
            $sql ="INSERT INTO department (faculty_name, post, department) VALUES ('{$faculty_name}', '{$faculty_post}', '{$department}')";
            if(mysqli_query($conn, $sql)) {
                echo 1;
            } else {
                echo "Sorry, course can't add.";
            }
        }
    }
    // End script
    
    // Delete course
    if($operation == 'delete-faculty') {
        $id  = $_POST['id'];
        $selectImage = "SELECT faculty_image FROM department WHERE id={$id}";
        $imageExist = mysqli_query($conn, $selectImage);
        if(mysqli_num_rows($imageExist) > 0) {
            $imagePath =  mysqli_fetch_assoc($imageExist);
            if(file_exists($imagePath['faculty_image'])) {
                unlink($imagePath['faculty_image']);
            }
        }
        $sql = "DELETE FROM department WHERE id={$id}";
        if(mysqli_query($conn, $sql)) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // End delete record script

    // Load update form record
    if($operation =='load-update-data') {
        $id = $_POST['id'];
        $sql = "SELECT * FROM department WHERE id={$id}";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        if(mysqli_num_rows($result) > 0) {
            $output = '';
            while($row = mysqli_fetch_assoc($result)) {
                $output.="
                    <tr>
                        <td><span>Department</span></td>
                        <td><input type='text' name='update_department' id='update_department' value='{$row["department"]}'>
                        <input type='text'name='faculty_id'  id='faculty_id' hidden value='{$row["id"]}'></td>
                    </tr>
                    <tr>
                        <td><span>Faculty Name</span></td>
                        <td><input type='text' name='update_faculty_name' id='update_faculty_name' value='{$row["faculty_name"]}'></td>
                    </tr>
                    <tr>
                        <td><span>Post</span></td>
                        <td><input type='text' name='update_faculty_post' id='update_faculty_post' value='{$row["post"]}'>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Department</span></td>
                        <td><input type='text' name='update_department' id='update_department' value='{$row["department"]}'></td>
                    </tr>
                    <tr>
                        <td><span>Faculty Image</span></td>
                        <td><input type='file' name='update_faculty_image' id='update_faculty_image' value='{$row["faculty_image"]}'></td>
                    </tr>            
                    
                    <tr>
                        <td colspan='2' align='center'><input type='submit' value='Update' id='update_faculty'  style='margin-top: 20px; width:70% !important;'></td>
                    </tr>";
            }
            mysqli_close($conn);
            echo $output;
        } else {
            echo "<h2>No Record Found</h2>";
        }
    }
    // End script

    // Update faculty data
    if($operation == 'update-data') {
        $facultyId    = $_POST['faculty_id'];
        $faculty_name = $_POST['update_faculty_name'];
        $faculty_post = $_POST['update_faculty_post'];
        $department   = $_POST['update_department'];
        $facultyImage = $_POST['facultyImage'];

        // Initialize image-related variables
        if($facultyImage != "") {
            $targetDir = "../faculty-images/";
            $targetFile = $targetDir . basename($_FILES["update_faculty_image"]["name"]);
            $fileError = 0;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $fileError = "";

            // Check if image file is a real image or fake image
            $check = getimagesize($_FILES["update_faculty_image"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                return;
            }

            // Check file size must be less then 5 MB
            if ($_FILES["update_faculty_image"]["size"] > 500000) {
                echo "Sorry, your file is too large (file must be less than 5MB).";
                return;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                return;
            }
            // Delete course image from folder
            $selectImage = "SELECT faculty_image FROM department WHERE id={$facultyId}";
            $imageExist = mysqli_query($conn, $selectImage);
            if(mysqli_num_rows($imageExist) > 0) {
                $imagePath =  mysqli_fetch_assoc($imageExist);
                if(file_exists($imagePath['faculty_image'])) {
                    unlink($imagePath['faculty_image']);
                }
            }

            if (move_uploaded_file($_FILES["update_faculty_image"]["tmp_name"], $targetFile)) {
                $sql ="UPDATE department SET faculty_name='{$faculty_name}', post='{$faculty_post}', department='{$department}', faculty_image='{$targetFile}' WHERE id={$facultyId}";
                if(mysqli_query($conn, $sql)) {
                    echo 1;
                } else {
                    echo "Sorry, faculty can't update.";
                }
            }
        } else {
            $sql ="UPDATE department SET faculty_name='{$faculty_name}', post='{$faculty_post}', department='{$department}' WHERE id={$facultyId}";
            if(mysqli_query($conn, $sql)) {
                echo 1;
            } else {
                echo "Sorry, faculty can't update.";
            }
        }
    }

    // End script
    
    // Search faculty record
    if($operation == 'search-faculty') {
        $search_value = $_POST["search"];

        $sql = "SELECT * FROM department WHERE faculty_name LIKE '%{$search_value}%' OR department LIKE '%{$search_value}%'";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";

        if(mysqli_num_rows($result) > 0) {
            $output.="<tr style='background: transparent'>
                            <td align='center'>{$row['department']}</td>
                            <td align='center'>{$row['faculty_name']}</td>
                            <td align='center'>{$row['post']}</td>
                            <td align='center'><img src='".$row['faculty_image']."' alt='No image found'  style=' height:200px; width:200px'></td>
                            <td align='center'><button class='edit-btn' data-id='{$row['id']}' title='Update Faculty'><i class='fa fa-edit'></button></td>
                            <td align='center'><button class='delete-btn' data-id='{$row['id']}' title='Delete Faculty'><i class='fa fa-trash-o'></button></td>
                        </tr>";
            mysqli_close($conn);
            echo $output;
        } else {
            echo "<td colspan='5'>No Record Found</td>";
        }
    }

}
    
?>