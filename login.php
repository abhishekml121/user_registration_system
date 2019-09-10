<?php
session_start();
$location = './index.php';
/* It means we successfully logged-in and now no need to execute the login.php code */
$check = $_SESSION['save_user_email_navigation'] ?? null;
if(isset($check) && $check != null){
    header("Location: " . $location);
    exit;
}

function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class='errors sinup_errors'>";
    $output .= "Please fix the following errors:";
    $output .= "<ol>";
    foreach($errors as $show_err => $err_value) {
      $output .= "<li>" . ucwords(str_replace('_', ' ', $show_err)) . ' : ' . $err_value . "</li>";
    }
    
    $output .= "</ol>";
    $output .= "</div>";
  }
  echo $output;
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Sinup page</title>
    <link rel="stylesheet" href="./style/animation.css">
    <link rel="stylesheet" href="./style/main.css">
</head>

<body>
    <div id="form_div">
        <div id="h2_form_div">
            <h2>Login form</h2>
        </div>
        <?php
        echo display_errors($_SESSION['errors'] ?? array());
        ?>
        <form action="process_login_form.php" method="post" id="form">

            <div class="input_div">
                <label for="email">
                    Email
                </label>
                <!--I have given maxlength attribute according to mysql database design-->
                <input type="email" name="email" maxlength="120" placeholder="Enter your email" value="<?php echo $_SESSION['form_values']['email'] ?? ''; ?>">
            </div>

            <div class="input_div password_div">
                <label for="password">
                    Password <span id="uncheck_img"><img src="./images/uncheck.png" alt="checkbox"></span>
                </label>
                <input type=password name="password" placeholder="Enter password" id="password" maxlength="18" value="<?php echo $_SESSION['form_values']['password'] ?? ''; ?>">
            </div>

            <div class="input_div submit_div">
                <input type="submit" value="submit" name="submit">
            </div>
        </form>
        <?php
    unset($_SESSION['form_values']);
    unset($_SESSION['errors']);
?>
    </div>

    <script>
        var checkbox = document.getElementById('uncheck_img');
        var paswd = document.getElementById("password");

        checkbox.onclick = function show_password() {
            if (paswd.type === "password") {
                paswd.type = "text";
                checkbox.firstElementChild.src = "./images/check.png";
            } else {
                paswd.type = "password";
                checkbox.firstElementChild.src = "./images/uncheck.png";

            }
        }

    </script>
</body>

</html>
