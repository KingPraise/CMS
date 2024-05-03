<?php

if (isset($_GET['edit_user'])) {
    $the_user_id = escape($_GET['edit_user']);

    $query = "SELECT * FROM  users WHERE user_id = $the_user_id";
    $select_users_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_users_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }

    if (isset($_POST['edit_user'])) {

        $username = escape($_POST['username']);
        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_email = escape($_POST['user_email']);
        $user_role = escape($_POST['user_role']);
        $user_password = escape($_POST['user_password']);
        if (!empty($user_password)) {
            $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
            $get_user = mysqli_query($connection, $query_password);
            confirm($get_user);
            $row = mysqli_fetch_array($get_user);
            $db_user_password = $row['user_password'];

            if ($db_user_password != $user_password) {

                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
            }
            $query = "UPDATE users SET ";
            $query .= "username ='{$username}', ";
            $query .= "user_firstname ='{$user_firstname}', ";
            $query .= "user_lastname ='{$user_lastname}', ";
            $query .= "user_email ='{$user_email}', ";
            $query .= "user_role ='{$user_role}', ";
            $query .= "user_image ='{$user_image}', ";
            $query .= "user_password ='{$hashed_password}' ";
            $query .= "WHERE user_id ={$the_user_id} ";

            $edit_user_query = mysqli_query($connection, $query);
            // confirm($edit_user_query);
            echo "<br>User Updated" . "<a href='users.php'> View Users </a>";
        }


    }

} else {
    header('Location: index.php');
}
?>
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username ?>">
    </div>

    <div class="form-group">
        <label for="user_role">Roles</label>
        <select name="user_role" id="" class="form-control">
            <option value=" <?php echo $user_role; ?>">
                <?php echo $user_role; ?>
            </option>
            <?php
            if ($user_role == 'subscriber') {

                echo "<option value='admin'>Admin</option>";
            } else {
                echo " <option value='subscriber'>Subscriber</option> ";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname ?>">
    </div>
    <div class="form-group">
        <label for="title">Lastname</label>
        <input type="text" name="user_lastname" id="" class="form-control" value="<?php echo $user_lastname ?>">
    </div>



    <div class="form-group">
        <label for="post_tags">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo $user_email ?>">
    </div>

    <div class="form-group">
        <label for="post_tags">Password</label>
        <input type="password" class="form-control" autocomplete="off" name="user_password">
    </div>




    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User">
    </div>


</form>