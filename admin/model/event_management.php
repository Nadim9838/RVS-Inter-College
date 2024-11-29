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
        $sql = "SELECT * FROM events ORDER BY id ASC LIMIT {$offset},{$limit}";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $timestamp = strtotime($row['date']);
                $output.="<tr style='background: transparent'>
                            <td align='center'>{$row['title']}</td>
                            <td align='center'>{$row['content']}</td>";
                if($row['file']) {
                    $output.="<td align='center'><a href='".$row['file']."' target='_blank'> View Attachment</a></td>";
                } else {
                    $output.="<td align='center'></td>";
                }

                $output.="<td align='center'>".date('d/m/Y', $timestamp)."</td>
                            <td align='center'><button class='edit-btn btn btn-warning' data-id='{$row['id']}' title='Update Event'><i class='fa fa-edit'></button></td>
                            <td align='center'><button class='delete-btn btn btn-danger' data-id='{$row['id']}' title='Delete Event'><i class='fa fa-trash-o'></button></td>
                        </tr>";                              
            }

            // Start pagination script
            $sql1 = "SELECT * FROM events";
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
            $output.="<td colspan'5'>No Record Found</td>";
        }
        echo $output;
            
    }
    // End to load records 
    
    // insert new data
    if($operation == 'create-event') {
        $event_title   = $_POST['event_title'];
        $event_content = $_POST['event_content'];
        $eventFile     = $_POST['eventFile'];
        // Initialize image-related variables
        if($eventFile != "") {
            $targetDir  = "event-files/";
            $targetFile = $targetDir . basename($_FILES["event_file"]["name"]);
            $fileError  = 0;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $fileError = "";

            // Check file size must be less then 5 MB
            if ($_FILES["event_file"]["size"] > (1024*1024*5)) {
                echo "Sorry, your file is too large (file must be less than 5MB).";
                return;
            }

            // Allow certain file formats
            $allowed_types = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
            if (!in_array($imageFileType, $allowed_types)) {
                echo "Sorry, only JPG, JPEG, PNG, PDF, DOC, and DOCX files are allowed.";
                return;
            }

            if (move_uploaded_file($_FILES["event_file"]["tmp_name"], $targetFile)) {
                $sql ="INSERT INTO events (title, content, file) VALUES ('{$event_title}', '{$event_content}', '{$targetFile}')";
                if(mysqli_query($conn, $sql)) {
                    echo 1;
                } else {
                    echo "Sorry, course can't add.";
                }
            }
        } else {
            $sql ="INSERT INTO events (title, content) VALUES ('{$event_title}', '{$event_content}')";
            if(mysqli_query($conn, $sql)) {
                echo 1;
            } else {
                echo "Sorry, news can't add.";
            }
        }
    }
    // End script
    
    // Delete record
    if($operation == 'delete-data') {
        $id  = $_POST['id'];
        $selectImage = "SELECT file FROM events WHERE id={$id}";
        $fileExist = mysqli_query($conn, $selectImage);
        if(mysqli_num_rows($fileExist) > 0) {
            $filePath =  mysqli_fetch_assoc($fileExist);
            if(file_exists($filePath['file'])) {
                unlink($filePath['file']);
            }
        }
        $sql = "DELETE FROM events WHERE id={$id}";
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
        $sql = "SELECT * FROM events WHERE id={$id}";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        if(mysqli_num_rows($result) > 0) {
            $output = '';
            while($row = mysqli_fetch_assoc($result)) {
                $output.="
                    <tr>
                        <td><span>Event Title</span></td>
                        <td><input type='text' name='update_event_title' id='update_event_title' value='{$row["title"]}'>
                            <input type='text'name='event_id'  id='event_id' hidden value='{$row["id"]}'>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Event Content</span></td>
                        <td><input type='text' name='update_event_content' id='update_event_content' value='{$row["content"]}'></td>
                    </tr>
                    <tr>
                        <td><span>Attached File</span></td>
                        <td><input type='file' name='update_event_file' id='update_event_file' value='{$row["file"]}'></td>
                    </tr>            
                    
                    <tr>
                        <td colspan='2' align='center'><input type='submit' value='Update' id='update_event'  style='margin-top: 20px; width:70% !important;'></td>
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
        $eventId    = $_POST['event_id'];
        $event_title = $_POST['update_event_title'];
        $content   = $_POST['update_event_content'];
        $eventFile = $_POST['eventFile'];

        // Initialize image-related variables
        if($eventFile != "") {
            $targetDir = "event-files/";
            $targetFile = $targetDir . basename($_FILES["update_event_file"]["name"]);
            $fileError = 0;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $fileError = "";

            // Check file size must be less then 5 MB
            if ($_FILES["update_event_file"]["size"] > 1024*1024*5) {
                echo "Sorry, your file is too large (file must be less than 5MB).";
                return;
            }

            // Allow certain file formats
            $allowed_types = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
            if (!in_array($imageFileType, $allowed_types)) {
                echo "Sorry, only JPG, JPEG, PNG, PDF, DOC, and DOCX files are allowed.";
                return;
            }

            // Delete course image from folder
            $selectImage = "SELECT file FROM events WHERE id={$eventId}";
            $fileExist = mysqli_query($conn, $selectImage);
            if(mysqli_num_rows($fileExist) > 0) {
                $filePath =  mysqli_fetch_assoc($fileExist);
                if(file_exists($filePath['file'])) {
                    unlink($filePath['file']);
                }
            }

            if (move_uploaded_file($_FILES["update_event_file"]["tmp_name"], $targetFile)) {
                $sql ="UPDATE events SET title='{$event_title}', content='{$content}', file='{$targetFile}' WHERE id={$eventId}";
                if(mysqli_query($conn, $sql)) {
                    echo 1;
                } else {
                    echo "Sorry, event can't update.";
                }
            }
        } else {
            $sql ="UPDATE events SET title='{$event_title}', content='{$content}' WHERE id={$eventId}";
            if(mysqli_query($conn, $sql)) {
                echo 1;
            } else {
                echo "Sorry, event can't update.";
            }
        }
    }

    // End script
    
    // Search faculty record
    if($operation == 'search-record') {
        $search_value = $_POST["search"];

        $sql = "SELECT * FROM events WHERE title LIKE '%{$search_value}%' OR content LIKE '%{$search_value}%' OR date LIKE '%{$search_value}%'";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $timestamp = strtotime($row['date']);
                $output.="<tr style='background: transparent'>
                            <td align='center'>{$row['title']}</td>
                            <td align='center'>{$row['content']}</td>";
                if($row['file']) {
                    $output.="<td align='center'><a href='".$row['file']."' target='_blank'> View Attachment</a></td>";
                } else {
                    $output.="<td align='center'></td>";
                }

                $output.="<td align='center'>".date('d/m/Y', $timestamp)."</td>
                            <td align='center'><button class='edit-btn btn btn-warning' data-id='{$row['id']}' title='Update Event'><i class='fa fa-edit'></button></td>
                            <td align='center'><button class='delete-btn btn btn-danger' data-id='{$row['id']}' title='Delete Event'><i class='fa fa-trash-o'></button></td>
                        </tr>";                              
            }
            mysqli_close($conn);
            echo $output;
        } else {
            echo "<td colspan='5'>No Record Found</td>";
        }
    }

}
    
?>