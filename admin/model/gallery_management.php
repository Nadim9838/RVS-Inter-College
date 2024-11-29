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
        $sql = "SELECT * FROM gallery_images ORDER BY id ASC LIMIT {$offset},{$limit}";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        $imageCount = 1;
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $output.="<tr style='background: transparent'>
                            <td align='center'>{$imageCount}</td>
                            <td align='center'><a href='galery-images/".$row['gallery_image']."' alt='Gallery Image' target='_blank'><img src='galery-images/".$row['gallery_image']."' alt='img'  style=' height:200px; width:400px'></a></td>
                            <td align='center'><button class='edit-btn btn btn-warning' data-id='{$row['id']}' title='Update Image'><i class='fa fa-edit'></button></td>
                            <td align='center'><button class='delete-btn btn btn-danger' data-id='{$row['id']}' title='Delete Image'><i class='fa fa-trash-o'></button></td>
                        </tr>";
                $imageCount++;                       
            }
            // Start pagination script
            $sql1 = "SELECT * FROM gallery_images";
            $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
            if(mysqli_num_rows($result1) > 0) {
                $total_records = mysqli_num_rows($result1);
                $total_pages = ceil($total_records / $limit);
                $output .= "<tr p-5><td colspan=4><ul class='pagination admin-pagination'>";
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
            $output.="<td colspan='3'>No Record Found</td>";
        }
        echo $output;
    }
    // End to load records 
    
    // insert new data
    if($operation == 'add-image') {
        // Initialize image-related variables
        $targetDir = "../gallery-images/";
        $targetFile = $targetDir . basename($_FILES["gallery_image"]["name"]);
        $fileError = 0;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $fileError = "";

        // Check if image file is a real image or fake image
        $check = getimagesize($_FILES["gallery_image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            return;
        }

        // Check file size must be less then 5 MB
        if ($_FILES["gallery_image"]["size"] > (1024*1024*5)) {
            echo "Sorry, your file is too large (file must be less than 5MB).";
            return;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG & PNG files are allowed.";
            return;
        }

        if (move_uploaded_file($_FILES["gallery_image"]["tmp_name"], $targetFile)) {
            $sql ="INSERT INTO gallery_images (gallery_image) VALUES ('{$targetFile}')";
            if(mysqli_query($conn, $sql)) {
                echo 1;
            } else {
                echo "Sorry, image can't add.";
                return;
            }
        }
    }
    // End script
    
    // Delete image
    if($operation == 'delete-image') {
        $id = $_POST['id'];
        if($id) {
            $selectImage = "SELECT gallery_image FROM gallery_images WHERE id={$id}";
            $imageExist = mysqli_query($conn, $selectImage);
            if(mysqli_num_rows($imageExist) > 0) {
                $imagePath =  mysqli_fetch_assoc($imageExist);
                if($imagePath['gallery_image']) {
                    unlink($imagePath['gallery_image']);
                }
            }
            $sql = "DELETE FROM gallery_images WHERE id={$id}";
            if(mysqli_query($conn, $sql)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo "Image id is not exist";
            return;
        }
    }
    // End delete record

    // Load update form record
    if($operation =='load-update-data') {
        $id = $_POST['id'];
        $sql = "SELECT * FROM gallery_images WHERE id={$id}";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        if(mysqli_num_rows($result) > 0) {
            $output = '';
            while($row = mysqli_fetch_assoc($result)) {
                $output.="
                <tr>
                    <td><span>Choose Gallery Image</span></td>
                    <td style='float: right;'><input type='file' name='update_image' id='update_image' title='Choose gallery image' required value='{$row["gallery_image"]}'>
                    <input type='text' name='update_image_id' id='update_image_id' value='{$row["id"]}' hidden></td>
                </tr>            
                
                <tr>
                    <td colspan='2' align='center'><input type='submit' value='Update' id='update_gallery_image'  style='margin-top: 20px; width:70% !important;'></td>
                </tr>";
                        
            }
            $output.="</table>";
            mysqli_close($conn);
            echo $output;
        } else {
            echo "<h2>No Record Found</h2>";
        }
    }
    // End script

    // Update data
    if($operation == 'update-data') {
        $imageId      = $_POST['update_image_id'];
        $galleryImage = $_POST['galleryImage'];
        // Initialize image-related variables
        if($galleryImage != "") {
            $targetDir = "../gallery-images/";
            $targetFile = $targetDir . basename($_FILES["update_image"]["name"]);
            $fileError = 0;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $fileError = "";

            // Check if image file is a real image or fake image
            $check = getimagesize($_FILES["update_image"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                return;
            }

            // Check file size must be less then 5 MB
            if ($_FILES["update_image"]["size"] > 500000) {
                echo "Sorry, your file is too large (file must be less than 5MB).";
                return;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                return;
            }

            // Delete image from folder
            $selectImage = "SELECT gallery_image FROM gallery_images WHERE id={$imageId}";
            $imageExist = mysqli_query($conn, $selectImage);
            if(mysqli_num_rows($imageExist) > 0) {
                $imagePath =  mysqli_fetch_assoc($imageExist);
                if(file_exists($imagePath['gallery_image'])) {
                    unlink($imagePath['gallery_image']);
                }
            }

            if (move_uploaded_file($_FILES["update_image"]["tmp_name"], $targetFile)) {
                $sql ="UPDATE  gallery_images SET gallery_image='{$targetFile}' WHERE id={$imageId}";
                if(mysqli_query($conn, $sql)) {
                    echo 1;
                } else {
                    echo "Sorry, course can't add.";
                }
            }
        } else {
            echo "Please select an image.";
        }
    }
    // End script


}
    
?>