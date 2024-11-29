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
        $sql = "SELECT * FROM news ORDER BY id ASC LIMIT {$offset},{$limit}";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $timestamp = strtotime($row['date']);
                $output.="<tr>
                            <td align='center'>{$row['title']}</td>
                            <td align='center'>{$row['content']}</td>";
                if($row['file']) {
                    $output.="<td align='center'><a href='".$row['date']."' target='_blank'> View Attachment</a></td>";
                } else {
                    $output.="<td align='center'></td>";
                }

                $output.="<td align='center'>".date('d/m/Y', $timestamp)."</td>
                            <td align='center'><button class='edit-btn btn btn-warning' data-id='{$row['id']}' title='Update News'><i class='fa fa-edit'></button></td>
                            <td align='center'><button class='delete-btn btn btn-danger' data-id='{$row['id']}' title='Delete News'><i class='fa fa-trash-o'></button></td>
                        </tr>";                              
            }

            // Start pagination script
            $sql1 = "SELECT * FROM news";
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
    if($operation == 'create-news') {
        $news_title   = $_POST['news_title'];
        $news_content = $_POST['news_content'];
        $newsFile     = $_POST['newsFile'];
        // Initialize image-related variables
        if($newsFile != "") {
            $targetDir  = "news-files/";
            $targetFile = $targetDir . basename($_FILES["news_file"]["name"]);
            $fileError  = 0;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $fileError = "";

            // Check file size must be less then 5 MB
            if ($_FILES["news_file"]["size"] > (1024*1024*5)) {
                echo "Sorry, your file is too large (file must be less than 5MB).";
                return;
            }

            // Allow certain file formats
            $allowed_types = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
            if (!in_array($imageFileType, $allowed_types)) {
                echo "Sorry, only JPG, JPEG, PNG, PDF, DOC, and DOCX files are allowed.";
                return;
            }

            if (move_uploaded_file($_FILES["news_file"]["tmp_name"], $targetFile)) {
                $sql ="INSERT INTO news (title, content, file) VALUES ('{$news_title}', '{$news_content}', '{$targetFile}')";
                if(mysqli_query($conn, $sql)) {
                    echo 1;
                } else {
                    echo "Sorry, course can't add.";
                }
            }
        } else {
            $sql ="INSERT INTO news (title, content) VALUES ('{$news_title}', '{$news_content}')";
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
        $selectImage = "SELECT file FROM news WHERE id={$id}";
        $fileExist = mysqli_query($conn, $selectImage);
        if(mysqli_num_rows($fileExist) > 0) {
            $filePath =  mysqli_fetch_assoc($fileExist);
            if(file_exists($filePath['file'])) {
                unlink($filePath['file']);
            }
        }
        $sql = "DELETE FROM news WHERE id={$id}";
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
        $sql = "SELECT * FROM news WHERE id={$id}";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        if(mysqli_num_rows($result) > 0) {
            $output = '';
            while($row = mysqli_fetch_assoc($result)) {
                $output.="
                    <tr>
                        <td><span>News Title</span></td>
                        <td><input type='text' name='update_news_title' id='update_news_title' value='{$row["title"]}'>
                            <input type='text'name='news_id'  id='news_id' hidden value='{$row["id"]}'>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Content</span></td>
                        <td><input type='text' name='update_content' id='update_content' value='{$row["content"]}'></td>
                    </tr>
                    <tr>
                        <td><span>Attached File</span></td>
                        <td><input type='file' name='update_news_file' id='update_news_file' value='{$row["file"]}'></td>
                    </tr>            
                    
                    <tr>
                        <td colspan='2' align='center'><input type='submit' value='Update' id='update_news'  style='margin-top: 20px; width:70% !important;'></td>
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
        $newsId    = $_POST['news_id'];
        $news_title = $_POST['update_news_title'];
        $content   = $_POST['update_content'];
        $newsFile = $_POST['newsFile'];

        // Initialize image-related variables
        if($newsFile != "") {
            $targetDir = "news-files/";
            $targetFile = $targetDir . basename($_FILES["update_news_file"]["name"]);
            $fileError = 0;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $fileError = "";

            // Check file size must be less then 5 MB
            if ($_FILES["update_news_file"]["size"] > 1024*1024*5) {
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
            $selectImage = "SELECT file FROM news WHERE id={$newsId}";
            $fileExist = mysqli_query($conn, $selectImage);
            if(mysqli_num_rows($fileExist) > 0) {
                $filePath =  mysqli_fetch_assoc($fileExist);
                if(file_exists($filePath['file'])) {
                    unlink($filePath['file']);
                }
            }

            if (move_uploaded_file($_FILES["update_news_file"]["tmp_name"], $targetFile)) {
                $sql ="UPDATE news SET title='{$news_title}', content='{$content}', file='{$targetFile}' WHERE id={$newsId}";
                if(mysqli_query($conn, $sql)) {
                    echo 1;
                } else {
                    echo "Sorry, news can't update.";
                }
            }
        } else {
            $sql ="UPDATE news SET title='{$news_title}', content='{$content}' WHERE id={$newsId}";
            if(mysqli_query($conn, $sql)) {
                echo 1;
            } else {
                echo "Sorry, news can't update.";
            }
        }
    }

    // End script
    
    // Search faculty record
    if($operation == 'search-record') {
        $search_value = $_POST["search"];

        $sql = "SELECT * FROM news WHERE title LIKE '%{$search_value}%' OR content LIKE '%{$search_value}%' OR date LIKE '%{$search_value}%'";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $timestamp = strtotime($row['date']);
                $output.="<tr>
                            <td align='center'>{$row['title']}</td>
                            <td align='center'>{$row['content']}</td>";
                if($row['file']) {
                    $output.="<td align='center'><a href='".$row['file']."' target='_blank'> View Attachment</a></td>";
                } else {
                    $output.="<td align='center'></td>";
                }

                $output.="<td align='center'>".date('d/m/Y', $timestamp)."</td>
                            <td align='center'><button class='edit-btn btn btn-warning' data-id='{$row['id']}' title='Update News'><i class='fa fa-edit'></button></td>
                            <td align='center'><button class='delete-btn btn btn-danger' data-id='{$row['id']}' title='Delete News'><i class='fa fa-trash-o'></button></td>
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