<?php
session_start();
$success_location = './index.php';
$location = './login.php';
require_once('./database.php');
require_once("./functions.php");
//echo '<h3>Developement Values -</h3>';
function is_post_request(){
    return $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']);
}
function is_get_request(){
    return $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submit']);
}

if(is_post_request() || is_get_request()) {
    //echo $_SERVER['REQUEST_METHOD'];
  $new_account_data = [];
  $errors = [];
  $new_account_data['email'] = $_POST['email'] ?? '';
  $new_account_data['password'] = $_POST['password'] ?? '';
    
    $required = ['email','password'];
    
    $errors = check_login_account_errors($new_account_data,$required);
    if(!empty($errors)){
        $_SESSION['errors'] = $errors;
        redirect_to($location);
    }
    $result = check_paswd_for_login($new_account_data['email'],$new_account_data['password']);
    if(is_array($result)){
        $_SESSION['errors'] = $result;
        redirect_to($location);
    }
    else{
        $msg = 'Logging in successfull';
        /* LOG table for user activity */
        /* Stores true OR false */
        # Send email when a user logged-in
        $user_activities = user_activity($_SESSION['form_values'], $msg);
        /* For hint purpsoe hence user will get notification */
        $_SESSION['msg'] = $msg;
        $user_email = $_SESSION['form_values']['email'];
        $_SESSION['save_user_email_navigation'] = $user_email;
        unset($_SESSION['form_values']);
        unset($_SESSION['errors']);
        redirect_to($success_location);
 }
}
    
else{
$new_account_data['email'] ='';
$new_account_data['password'] = '';
}
?>
