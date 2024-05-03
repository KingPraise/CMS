<?php include "includes/db.php"; ?>
<?php include "includes/header.php";
require 'vendor/autoload.php';
// $dotenv = new \Dotenv\Dotenv(__DIR__);
// $dotenv->load();



// $options = [
//     'cluster' => 'us2',
//     'useTLS' => true
// ];
// $pusher = new Pusher\Pusher(getenv('APP_KEY'), getenv('APP_SECRET'), getenv('APP_ID'), $options);

//Sending Email

if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];

    if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
        echo "<script type='text/javascript'>location.reload(); </script>";
    }
}
if (isset($_SESSION["lang"])) {
    include "includes/languages/" . $_SESSION['lang'] . ".php";
} else {
    include "includes/languages/en.php";

}

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $register_username = trim($_POST['username']);
    $register_email = trim($_POST['email']);
    $register_password = trim($_POST['password']);

    $error = [
        'username' => '',
        'email' => '',
        'password' => ''
    ];

    if (strlen($register_username) < 4) {
        $error['username'] = "Username needs to be  longer";
    }

    if ($register_username == '') {
        $error['username'] = "Username can not be empty";
    }

    if (username_exists($register_username)) {
        $error['username'] = "Username already exists, pick another ";
    }

    if (strlen($register_email) < 4) {
        $error['email'] = "Email needs to be  longer";
    }

    if ($register_email == '') {
        $error['email'] = "Email can not be empty";
    }

    if (userEmail_exists($register_email)) {
        $error['email'] = "Email already exists, use another ";
    }

    if ($register_password == '') {
        $error['password'] = "Password can not be empty";
    }

    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    }
    if (empty($error)) {
        register_user($register_username, $register_email, $register_password);
        $data['message'] = $register_username;
        // $pusher->trigger('notifications', 'new_user', $data);

        login_user($register_username, $register_password);

    }
}
?>
<!-- Navigation -->

<?php include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">
    <form action="" method="get" class="navbar-form navbar-right" id="language_form">
        <div class="class-group">
            <select name="lang" class="form-control" onchange="changeLanguage()">
                <option value="en" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') {
                    echo "selected";
                } ?>>
                    English</option>
                <option value="es" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'es') {
                    echo "selected";
                } ?>>Spanish</option>
            </select>
        </div>

    </form>

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1><?php echo _REGISTER; ?></h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="on">
                            <h4 class="text-center">

                            </h4>
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" autocomplete="on"
                                    value="<?php echo isset($username) ? $username : '' ?>"
                                    placeholder="<?php echo _USERNAME; ?>">
                                <p>
                                    <?php echo isset($error['username']) ? $error['username'] : '' ?>
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" autocomplete="on"
                                    value="<?php echo isset($email) ? $email : '' ?>"
                                    placeholder="<?php echo _EMAIL; ?>">
                                <p>
                                    <?php echo isset($error['email']) ? $error['email'] : '' ?>
                                </p>

                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control"
                                    placeholder="<?php echo _PASSWORD; ?>">
                                <p>
                                    <?php echo isset($error['password']) ? $error['password'] : '' ?>
                                </p>
                            </div>

                            <input type="submit" name="register" id="btn-login" class="btn btn-primary btn-lg btn-block"
                                value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <script>
    function changeLanguage() {
        document.getElementById('language_form').submit();
    }
    </script>
    <?php include "includes/footer.php"; ?>