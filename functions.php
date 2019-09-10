<?php
function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function is_blank($value) {
    return !isset($value) || trim($value) === '';
  }
  function has_presence($value) {
    return !is_blank($value);
  }

function check_uniqueness($email){
    global $db;
    
    $sql = "SELECT * FROM sinup_details ";
    $sql .= "WHERE email='" . $email . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $unique = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    // If Return true then you can create account with the used email.
    return $unique['Email'] == $email ? false : true;
}
function check_paswd_for_login($email,$paswd){
    global $db;
    $sql = "SELECT * FROM sinup_details ";
    $sql .= "WHERE Email='" . $email . "' ";
    $sql .= "AND password='" . $paswd . "'";
    $execute = mysqli_query($db, $sql);
    confirm_result_set($execute);
    $result = mysqli_fetch_assoc($execute);
    mysqli_free_result($execute);
    if (empty($result)) {
  if (($result['Password'] != $paswd) || ($result['Email'] != $email)) {
      $error['Ops'] = "Email or Password not match";
  }   
    }
    /* If there are mismatch on password/email then
    Return value must be an array because I am checking
    is_array($error) in process_login_form.php to display the error.
    */
    
     /* Return true means inputed email and password are correct
     ?? only works in > php7.1
     */
    return $error ?? true;
}

    function check_new_account_errors($data=[], $required){
        $error=[];
        /* Store true or false.
        false means requested email is already used.
        so you have to use unused email inorder to sinup.
        */
    $check_for_uniqueness = check_uniqueness($data['email']);
        /*This will generate an error, if requested email has used already. */
    if ($check_for_uniqueness === false) {
      $error['email'] = "The ${data['email']} has used already. Please use different email.";
    }
        
        foreach ($required as $key) {
  		if(!has_presence($data[$key])){
  			$error[$key] = "can not blank";
  		}

  		if(!(isset($error['password'])) && strlen(($data['password'])) < 4){
  			$error['password'] = 'length must be greater than 3 digits';	 
  	}
  	if(has_presence($data['mobile_number']) && strlen(($data['mobile_number'])) < 10){
  			$error['mobile_number'] = 'length must be 10 in digits';	 
  	}
  	} /*end of first foreach()*/
        
        /* It checks that inputed values contains html code or NOT*/
  	foreach ($data as $key => $value) {
  		if($value != strip_tags($value)) {
  		$error[$key]= "can not contain HTML";
}
        $_SESSION['form_values'][$key]= has_presence($value) ? $value : null;
  	} /*end of second foreach()*/
  	  	return $error;
    }

function check_login_account_errors($data=[], $required){
        $error=[];
        
        foreach ($required as $key) {
  		if(!has_presence($data[$key])){
  			$error[$key] = "can not blank";
  		}

  	} /*end of first foreach()*/
        
        /* It checks that inputed values contains html code or NOT*/
  	foreach ($data as $key => $value) {
  		if($value != strip_tags($value)) {
  		$error[$key]= "can not contain HTML";
}
        $_SESSION['form_values'][$key]= has_presence($value) ? $value : null;
  	} /*end of second foreach()*/
  	  	return $error;
    }



    function create_new_account($data=[]){
         global $db;
        
        $sql = "INSERT INTO sinup_details ";
    $sql .= "(Full_name, Email, Mobile_number, Password) ";
    $sql .= "VALUES (";
    $sql .= "'" . $data['full_name'] . "',";
    $sql .= "'" . $data['email'] . "',";
    $sql .= "'" . $data['mobile_number'] . "',";
    $sql .= "'" . $data['password'] . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }

    }

function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class='errors sinup_errors'>";
    $output .= "Please fix the following errors:";
    $output .= "<ol>";
    foreach($errors as $show_err => $err_value) {
      $output .= "<li>" . h(ucwords(str_replace('_', ' ', $show_err))) . ' : ' . h($err_value) . "</li>";
    }
    
    $output .= "</ol>";
    $output .= "</div>";
  }
  echo $output;
}

function get_full_name_by_using_email($email){
    global $db;

    $sql = "SELECT * FROM sinup_details ";
    $sql .= "WHERE Email='" . $email . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user_detail = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    // returns an assoc. array
    return $user_detail['Full_name']; 
    
}

function insert_activity_detail($data){
    global $db;
        
    $sql = "INSERT INTO user_activity ";
    $sql .= "(Full_name, Email, Time, Date, Day, Action) ";
    $sql .= "VALUES (";
    $sql .= "'" . $data['full_name'] . "',";
    $sql .= "'" . $data['email'] . "',";
    $sql .= "'" . $data['time'] . "',";
    $sql .= "'" . $data['date'] . "',";
    $sql .= "'" . $data['day'] . "',";
    $sql .= "'" . $data['msg'] . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
    }

function user_activity($activity = [], $msg){
     //echo date("l,Y-m-d,h:i:s A");
    $email = $activity['email'];
    // Return time in hh:mm:ss AM/PM
    $time_in_am_pm = date("h:i:s A");
    // Return date in dd:mm:yyyy
    $date = date("d/m/Y");
    // Return weekday like Sunday
    $day = date("l");
    /* Here we are finding the Full_name of the user by using their email because our db table needs Full_name */
    $full_name = get_full_name_by_using_email($email);
    $log_msg = $msg;
    
    $activity_detail = ['full_name'=>$full_name,'email'=>$email, 'time'=>$time_in_am_pm,'date'=>$date,'day'=>$day,'msg'=>$log_msg];
    /* Here we are storing the values in database table.
    / Return true means insertion successful.
    */
    $result = insert_activity_detail($activity_detail);
    if($result){
    return true;
    }
    else{
        return false;
    }   
}


function display_users_activity() {
    global $db;

    $sql = "SELECT * FROM user_activity";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
$i=0;
while ($all_users_account = mysqli_fetch_assoc($result)) {
    if ($i==0) {
  
echo '<div class="log_attributes"><table>';
$show_data = "<tr>";
foreach ($all_users_account as $key => $value) {
        $show_data.= "<th>". ucwords($key)."</th>";
              }
      $show_data.= "</tr>";
echo $show_data;
$i=1;
}
$show_data = "<tr>";
        foreach ($all_users_account as $key => $value) {
          
          $show_data.= "<td>{$all_users_account[$key]}</td>";
        }
        $show_data.= "</tr>";
        echo $show_data;
   
    //return $all_users_account; // returns an assoc. array
  }
mysqli_free_result($result);
}



?>
