<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>
        <?php
        //EDITING CATEGORIES
        if (isset($_GET['edit'])) {
            $cat_id = $_GET['edit'];
            $query = "SELECT * FROM  categories WHERE cat_id = $cat_id";
            $select_categories_id = mysqli_query($connection, $query);


            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                ?>
        <input value="<?php if (isset($cat_title)) {
                    echo $cat_title;
                } ?>" type="text" name="cat_title" class="form-control">

        <?php
            }
        }
        ?>
        <?php
        //UPDATE QUERY
        if (isset($_POST['update_category'])) {
            $the_cat_title = $_POST['cat_title'];

            $query = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ?");
            mysqli_stmt_bind_param($query, 'si', $the_cat_title, $cat_id);
            mysqli_stmt_execute($query);
            if (!$query) {
                die("QUERY FAILED" . mysqli_error($connection));
            }
            mysqli_stmt_close($query);
            redirect('categories.php');

        }
        ?>
        <div class="form-group">
            <input type="submit" name="update_category" value="Update Category" class="btn btn-primary">
        </div>
    </div>
</form>