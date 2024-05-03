<?php
if (isset($_POST['create_user'])) {
    $username = escape($_POST['username']);
    $user_firstname = escape($_POST['user_firstname']);
    // $user_image = $_FILES['image']['name'];
    // $user_image_temp = $_FILES['image']['tmp_name'];
    $user_lastname = escape($_POST['user_lastname']);
    $user_email = escape($_POST['user_email']);
    $user_role = escape($_POST['user_role']);
    $user_password = escape($_POST['user_password']);
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "INSERT INTO users (username, user_firstname, user_lastname, user_email, user_password, user_role) ";
    $query .= "VALUES('{$username}','{$user_firstname}','{$user_lastname}','{$user_email}','{$user_password}','{$user_role}' )";

    $create_user_query = mysqli_query($connection, $query);
    confirm($create_user_query);
    echo "<br> User Created: " . " " . "<a href='users.php'>View Users</a>";
}
?>
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="post_tags">Roles</label>
        <select name="user_role" id="" class="form-control">
            <option value="">SELECT Roles</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="title">Lastname</label>
        <input type="text" name="user_lastname" id="" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_tags">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="post_tags">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>


</form>