<?php
if (isset($_POST['create_post'])) {
    $post_user = escape($_POST['post_users']);
    $post_title = escape($_POST['title']);
    $post_category = escape($_POST['post_category']);
    $post_date = date('d-m-y');
    $post_image = escape($_FILES['image']['name']);
    $post_image_temp = escape($_FILES['image']['tmp_name']);
    $post_content = escape($_POST['post_content']);
    $post_tags = escape($_POST['post_tags']);
    $post_status = escape($_POST['post_status']);

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts (post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status)";
    $query .= "VALUES({$post_category},'{$post_title}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}' )";

    $create_post_query = mysqli_query($connection, $query);
    confirm($create_post_query);
    $the_post_id = mysqli_insert_id($connection);
    echo " <br> <p class='bg-success'> Post Created. <a href='../post.php?p_id={$the_post_id}'> View Post </a> Or <a href='posts.php'> Edit Other Posts </a></p>";
}
?>
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select name="post_category" id="" class="form-control">
            <?php
            $query = "SELECT * FROM  categories";
            $select_categories = mysqli_query($connection, $query);

            confirm($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<option value=' {$cat_id}'>{$cat_title} </option>";
            }
            ?>
        </select>
    </div>
    <!-- <div class="form-group">
        <label for="title">Post Author</label>
        <input type="text" class="form-control" name="author">
    </div> -->
    <div class="form-group">
        <label for="title">Post Status</label>
        <select name="post_status" id="" class="form-control">
            <option value="">Select Options </option>
            <option value="draft">Draft </option>
            <option value="published">Publish</option>
        </select>

    </div>
    <div class="form-group">
        <label for="users">Users</label>
        <select name="post_users" id="" class="form-control">
            <?php
            $query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $query);

            confirm($select_users);

            while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row['user_id'];
                $username = $row['username'];

                echo "<option value='$username'>{$username}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>


</form>