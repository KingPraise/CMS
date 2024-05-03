<?php include "includes/admin_header.php";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username ='{$username}'";
    $select_user_profile_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($select_user_profile_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
    }
}



?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to The Admin Page
                        <small>Subheading</small>
                    </h1>

                    <form action="" method="post" enctype="multipart/form-data">
                        <?php



                        if (isset($_POST['edit_user'])) {
                            $user_name = $_SESSION['username'];

                            $username = $_POST['username'];
                            $user_firstname = $_POST['user_firstname'];
                            $user_lastname = $_POST['user_lastname'];
                            $user_email = $_POST['user_email'];
                            $user_password = $_POST['user_password'];


                            $query = "UPDATE users SET ";
                            $query .= "username ='{$username}', ";
                            $query .= "user_firstname ='{$user_firstname}', ";
                            $query .= "user_lastname ='{$user_lastname}', ";
                            $query .= "user_email ='{$user_email}', ";
                            $query .= "user_password ='{$user_password}' ";
                            $query .= "WHERE username ='{$user_name}' ";

                            $edit_user_query = mysqli_query($connection, $query);
                            confirm($edit_user_query);
                        }
                        ?>
                        <div class="form-group">
                            <label for="title">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $username ?>">
                        </div>

                        <div class="form-group">
                            <label for="title">Firstname</label>
                            <input type="text" class="form-control" name="user_firstname"
                                value="<?php echo $user_firstname ?>">
                        </div>

                        <div class="form-group">
                            <label for="title">Lastname</label>
                            <input type="text" name="user_lastname" id="" class="form-control"
                                value="<?php echo $user_lastname ?>">
                        </div>

                        <div class="form-group">
                            <label for="post_tags">Email</label>
                            <input type="email" class="form-control" name="user_email"
                                value="<?php echo $user_email ?>">
                        </div>

                        <div class="form-group">
                            <label for="post_tags">Password</label>
                            <input type="password" class="form-control" name="user_password" autocomplete="off"
                                required>
                        </div>

                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="edit_user" value="Update Profile">
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include "includes/admin_footer.php" ?>