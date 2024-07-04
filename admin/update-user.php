<?php 
include "header.php"; 

if (isset($_POST['submit'])) {
    include "config.php";

    $userid = mysqli_real_escape_string($conn, $_POST['user_id']);
    $fname = mysqli_real_escape_string($conn, $_POST['f_name']);
    $lname = mysqli_real_escape_string($conn, $_POST['l_name']);
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Check if the username already exists
    $check_user_sql = "SELECT * FROM user WHERE username = '$user' AND user_id != '$userid'";
    $check_user_result = mysqli_query($conn, $check_user_sql);

    if ($check_user_result && mysqli_num_rows($check_user_result) > 0) {
        echo "<p style='color:red; text-align:center; margin:10px 0;'>Username already exists.</p>";
    } else {
        // Update user details
        $update_sql = "UPDATE user SET first_name = '$fname', last_name = '$lname', username = '$user', role = '$role' WHERE user_id = '$userid'";
        
        if (mysqli_query($conn, $update_sql)) {
            header("Location: {$hostname}/admin/users.php");
            exit();
        } else {
            echo "<p style='color:red; text-align:center; margin:10px 0;'>Failed to update user details. Error: " . mysqli_error($conn) . "</p>";
        }
    }
} else {
    include "config.php";

    $user_id = $_GET['id'];
    $sql = "SELECT * FROM user WHERE user_id = {$user_id}";
    $result = mysqli_query($conn, $sql) or die("Query failed: " . mysqli_error($conn));

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Modify User Details</h1>
            </div>
            <div class="col-md-offset-4 col-md-4">
                <!-- Form Start -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="user_id" class="form-control" value="<?php echo $row['user_id']; ?>">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>User Role</label>
                        <select class="form-control" name="role">
                            <?php
                            if ($row['role'] == 1) {
                                echo "<option value='0'>Normal User</option>
                                      <option value='1' selected>Admin</option>";
                            } else {
                                echo "<option value='0' selected>Normal User</option>
                                      <option value='1'>Admin</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Update">
                </form>
                <!-- /Form -->
            </div>
        </div>
    </div>
</div>
<?php
    }
}

include "footer.php"; 
?>
