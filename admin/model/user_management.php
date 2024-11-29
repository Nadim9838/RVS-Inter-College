<?php
include '../database.php';
if(isset($_POST['operation'])) {
    $operation = $_POST['operation'];

    // Load user records 
    if($operation == 'load-data') {
        if(isset($_POST['page'])) {
            $page = $_POST['page'];
        } else {
            $page = 1;
        }
        
        $limit = 10;
        $offset = ($page-1)*$limit;
        $sql = "SELECT * FROM users ORDER BY name ASC LIMIT {$offset},{$limit}";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $timestamp = strtotime($row['created_at']);
                $output.="<tr style='background: transparent'>
                            <td align='center'>{$row['username']}</td>
                            <td align='center'>{$row['name']}</td>
                            <td align='center'>{$row['email']}</td>
                            <td align='center'>{$row['phone']}</td>
                            <td align='center'>".date('d/m/Y h:i:A', $timestamp)."</td>
                            <td align='center'><button class='edit-btn btn btn-warning' data-id='{$row['id']}' title='Update User'><i class='fa fa-edit'></button></td>
                            <td align='center'><button class='delete-btn btn btn-danger' data-id='{$row['id']}' title='Delete User'><i class='fa fa-trash-o'></button></td>
                        </tr>";                              
            }

            // Start pagination script
            $sql1 = "SELECT * FROM users";
            $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
            if(mysqli_num_rows($result1) > 0) {
                $total_records = mysqli_num_rows($result1);
                $total_pages = ceil($total_records / $limit);
                $output .= "<tr p-5><td colspan=7><ul class='pagination admin-pagination'>";
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
            echo $output;         
        } else {
            $output.="<td colspan='6'>No Record Found</td>";
        }
            
    }
    // End to load user records 
    
    // insert new user record
    if($operation == 'create-user') {
        $uname    = $_POST['uname'];
        $name     = $_POST['name'];
        $email    = $_POST['email'];
        $password = $_POST['password'];
        $phone    = $_POST['phone'];

        $sql ="INSERT INTO users (username, name, email, password, phone) VALUES ('{$uname}', '{$name}', '{$email}', '{$password}', '{$phone}')";
        if(mysqli_query($conn, $sql)) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // End insert new user record
    
    // Delete user record
    if($operation == 'delete-user') {
        $userId    = $_POST['id'];
        $sql = "DELETE FROM users WHERE id={$userId}";
        if(mysqli_query($conn, $sql)) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // End delete user record

    // Load update form record
    if($operation =='load-update-user') {
        $userId = $_POST['id'];
        $sql = "SELECT * FROM users WHERE id={$userId}";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        if(mysqli_num_rows($result) > 0) {
            $output = '';
            while($row = mysqli_fetch_assoc($result)) {
                $output.="
                <tr>
                    <td><span>Username</span></td>
                    <td><input type='text' name='username' id='update_uname' value='{$row["username"]}'>
                        <input type='text' id='user_id' hidden value='{$row["id"]}'>
                    </td>
                </tr>
                <tr>
                    <td><span>Name</span></td>
                    <td><input type='text' name='name' id='update_name' value='{$row["name"]}'></td>
                </tr>
                <tr>
                    <td><span>Email</span></td>
                    <td><input type='email' name='email' id='update_email' value='{$row["email"]}'></td>
                </tr>
                <tr>
                    <td><span>Mobile</span></td>
                    <td><input type='text' name='phone' id='update_phone' value='{$row["phone"]}'></td>
                </tr>
                <tr>
                    <td><span>Password</span></td>
                    <td><input type='password' name='password' id='update_password' value='{$row["password"]}'></td>
                </tr>              
                
                <tr>
                    <td colspan='2' align='center'><input type='submit' value='Update' id='update_user_data'  style='margin-top: 20px; width:70% !important;'></td>
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

    // Update user record
    if($operation == 'update-user') {
        $userId   = $_POST['id'];
        $uname    = $_POST['uname'];
        $name     = $_POST['name'];
        $email    = $_POST['email'];
        $phone    = $_POST['phone'];
        $password = $_POST['password'];

        $sql ="UPDATE users SET username='{$uname}', name='{$name}', email='{$email}', password='{$password}', phone='{$phone}' WHERE id={$userId}";
        $result = mysqli_query($conn, $sql);
        if($result) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // End script
    
    // Search user record
    if($operation == 'search-user') {
        $search_value = $_POST["search"];

        $sql = "SELECT * FROM users WHERE username LIKE '%{$search_value}%' OR name LIKE '%{$search_value}%' OR email LIKE '%{$search_value}%' OR phone LIKE '%{$search_value}%' OR created_at LIKE '%{$search_value}%'";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed");
        $output = "";
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $timestamp = strtotime($row['created_at']);
                $output.="<tr style='background: transparent'>
                            <td align='center'>{$row['username']}</td>
                            <td align='center'>{$row['name']}</td>
                            <td align='center'>{$row['email']}</td>
                            <td align='center'>{$row['phone']}</td>
                            <td align='center'>".date('d/m/Y h:i:A', $timestamp)."</td>
                            <td align='center'><button class='edit-btn' data-id='{$row['id']}' title='Update User'><i class='fa fa-edit'></button></td>
                            <td align='center'><button class='delete-btn' data-id='{$row['id']}' title='Delete User'><i class='fa fa-trash-o'></button></td>
                        </tr>";                              
            }
            mysqli_close($conn);
            echo $output;
        } else {
            echo "<td colspan='6'>No Record Found</td>";
        }
    }

}
    
?>