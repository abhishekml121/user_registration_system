<?php
session_start();
$location = './index.php';
$check = $_SESSION['save_user_email_navigation'] ?? null;
if(isset($check) && $check != null){
    header("Location: " . $location);
    exit;
}

/*function msg($msg){
    $output = '';
    if(!empty($msg)) {
        $output .="<div class='msg'>";
        $output .="$msg </div>";
        unset($_SESSION['msg']);
    }
    return $output;
    
}*/

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
        <?php
        //echo msg($_SESSION['msg'] ?? '');
        ?>
        <div id="h2_form_div">
            <h2>Registration form</h2>
        </div>
        <?php
        echo display_errors($_SESSION['errors'] ?? array());
        ?>
        <form action="process_sinup_form.php" method="post" id="form">
            <div class="input_div">
                <label for="full_name">
                    Full Name
                </label>
                <input type="text" name="full_name" maxlength="50" placeholder="Enter your full name" value="<?php echo $_SESSION['form_values']['full_name'] ?? ''; ?>">
            </div>
            <div class="input_div">
                <label for="email">
                    Email
                </label>
                <input type="email" name="email" maxlength="120" placeholder="Enter your email" value="<?php echo $_SESSION['form_values']['email'] ?? ''; ?>">
            </div>
            <div class="input_div">
                <label for="mobile_number">
                    Mobile Number
                </label>
                <input type="text" name="mobile_number" placeholder="Enter your mobile number" maxlength="10" inputmode="numeric" value="<?php echo $_SESSION['form_values']['mobile_number'] ?? ''; ?>">

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
