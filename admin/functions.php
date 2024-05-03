<?php


// Database Helper Funtion
function querySth($query)
{
    global $connection;
    return mysqli_query($connection, $query);

}


function fetchRecords($result)
{
    return mysqli_fetch_array($result);
}

function getUserName()
{


    if (isset($_SESSION['username'])) {
        return $_SESSION['username'];
    }
}


function getAllUserPosts()
{
    global $connection;
    $query = "SELECT * FROM posts WHERE user_id" . loggedInUserId() . "";
    $select_all_post = mysqli_query($connection, $query);
    $post_count = mysqli_num_rows($select_all_post);
}


function is_admin($username)
{
    if (isLoggedIn()) {
        global $connection;
        $result = mysqli_query($connection, "SELECT user_role FROM users WHERE username= '$username' ");
        $row = fetchRecords($result);
        if ($row['user_role'] == 'admin') {
            return true;
        } else {
            return false;
        }
    }
}



function imagePlaceHolder($image = '')
{
    if (!$image) {
        return 'image_4.jpg';
    } else {
        return $image;
    }
}


function currentUser()
{
    if (isset($_SESSION['username'])) {
        return $_SESSION['username'];
    }
    return false;
}


function redirect($location)
{
    header("Location: " . $location);
    exit;
}


function ifItIsMethod($method = null)
{
    if ($_SERVER["REQUEST_METHOD"] == strtoupper($method)) {
        return true;
    }
    return false;
}


function isLoggedIn()
{
    if (isset($_SESSION['user_role'])) {
        return true;
    }
    return false;
}


function loggedInUserId()
{
    if (isLoggedIn()) {
        global $connection;
        $result = mysqli_query($connection, "SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'");
        confirm($result);
        $user = mysqli_fetch_array($result);
        if (mysqli_num_rows($result) >= 1) {
            return $user['user_id'];
        }
    }
    return false;
}

function userLikedThisPost($post_id)
{
    global $connection;
    $result = mysqli_query($connection, "SELECT * FROM likes WHERE user_id = " . loggedInUserId() . " AND post_id  = {$post_id}");
    confirm($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}

function getPostlikes($post_id)
{
    global $connection;
    $result = mysqli_query($connection, "SELECT * FROM likes WHERE post_id=$post_id");
    confirm($result);
    echo mysqli_num_rows($result);

}
function checkIfUserIsLoggedInAndRedirect($redirectLocation = null)
{
    if (isLoggedIn()) {
        redirect($redirectLocation);
    }
}

function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function checkStatus($table, $column, $status)
{
    global $connection;

    $query = "SELECT * FROM $table WHERE $column = '$status'";
    $select_all_published_posts = mysqli_query($connection, $query);

    $result = mysqli_num_rows($select_all_published_posts);

    return $result;
}

function set_message($message)
{
    if (!$message) {
        $_SESSION['message'] = $message;
    } else {
        $message = "";
    }
}

function unApprove()
{
    global $connection;
    if (isset($_GET['unapprove'])) {
        $the_comment_id = $_GET['unapprove'];

        $query = "UPDATE comments SET comment_status ='unapproved' WHERE comment_id = $the_comment_id";
        $unapprove_comment_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    }
}

function approve()
{
    global $connection;
    if (isset($_GET['approve'])) {
        $the_comment_id = $_GET['approve'];

        $query = "UPDATE comments SET comment_status ='approved' WHERE comment_id = $the_comment_id";
        $approve_comment_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    }
}

function recordCount($table)
{
    global $connection;
    $query = "SELECT * FROM " . $table;
    $select_all_post = mysqli_query($connection, $query);

    $result = mysqli_num_rows($select_all_post);
    confirm($result);
    return $result;
}

function display_message()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}
function users_online()
{
    if (isset($_GET['onlineusers'])) {


        global $connection;

        if (!$connection) {
            session_start();
            include '../includes/db.php';
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 05;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == NULL) {

                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
            } else {

                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $count_user = mysqli_num_rows($users_online_query);
        }
    }
}
users_online();

function confirm($result)
{
    global $connection;
    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}
function insert_categories()
{
    global $connection;

    //INSERTING CATEGORIES

    if (isset($_POST['submit'])) {
        $cat_title = $_POST["cat_title"];

        if ($cat_title == "" || empty($cat_title)) {
            echo "This field can not be left empty!";
        } else {

            $query1 = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?) ");
            mysqli_stmt_bind_param($query1, 's', $cat_title);
            mysqli_stmt_execute($query1);
            if (!$query1) {
                die("Query Failed" . mysqli_error($connection));
            }
        }
        mysqli_stmt_close($query1);
    }
}

function findAllCategories()
{
    global $connection;
    //Find All Cetegories Query
    $query = "SELECT * FROM  categories";
    $select_categories = mysqli_query($connection, $query);


    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td> <a href='categories.php?delete={$cat_id}'>Delete </a></td>";
        echo "<td> <a href='categories.php?edit={$cat_id}'>Edit </a></td>";
        echo "</tr>";
    }
}


function deleteCategories()
{
    global $connection;
    //DELETE QUERY
    if (isset($_GET['delete'])) {
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}



function username_exists($username)
{
    global $connection;
    $query = "SELECT username FROM users WHERE username= '$username'";
    $result = mysqli_query($connection, $query);
    confirm($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function userEmail_exists($email)
{
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email= '$email'";
    $result = mysqli_query($connection, $query);
    confirm($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}


function register_user($username, $email, $password)
{
    global $connection;

    $register_username = mysqli_real_escape_string($connection, $username);
    $register_email = mysqli_real_escape_string($connection, $email);
    $register_password = mysqli_real_escape_string($connection, $password);
    $register_password = password_hash($register_password, PASSWORD_BCRYPT, array('cost' => 12));


    $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
    $query .= "VALUES('{$register_username}','{$register_email}','{$register_password}', 'subscriber' )";
    $register_user_query = mysqli_query($connection, $query);
    confirm($register_user_query);
}

function login_user($username, $password)
{
    global $connection;
    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_query = mysqli_query($connection, $query);

    if (!$select_user_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    }

    while ($row = mysqli_fetch_array($select_user_query)) {
        $db_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];

        if (password_verify($password, $db_user_password)) {
            // $_SESSION['user_id'] = $db_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;



            redirect("/cms-scratch/admin");
        } else {
            return false;
        }
    }
    return true;
}