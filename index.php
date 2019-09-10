<?php 
session_start();
$email = $_SESSION['save_user_email_navigation'] ?? null;
if(isset($email) && $email != null){
    $login = 1;
}
else{
    $login = 0;
}

function msg($msg){
    $output = '';
    if(!empty($msg)) {
        $output .="<div class='msg'>";
        $output .="$msg </div>";
        unset($_SESSION['msg']);
    }
    return $output;
    
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./style/animation.css">
    <title> Welcome </title>
    <style>
        nav ul {
            margin: 0;
            padding: 20px;
            background-color: #4CAF50;
            font: 25px sans-serif;

        }

        nav ul li {
            display: inline-block;
            padding-right: 20px;
            list-style-type: none;
        }

        nav ul li a {
            text-decoration: none;
            padding: 18px;
            color: #3c3a3a
        }

        #welcome {
            background-color: rgb(138, 201, 147);
            color: #ffffff;
            font: 45px sans-serif;
            padding: 80px 0px 80px 0px;
            text-align: center;

        }

        #welcome p {
            display: inline-block;
            padding: 0px 30px 0px 30px;
            transition: all 0.4s;
            word-spacing: 0.5em;
            margin-top: 10px;
        }

        #welcome p:hover {
            color: #6f6d6d;
            -webkit-animation-name: input_gr;
            animation-name: input_gr;
            -webkit-animation-duration: 0.3s;
            animation-duration: 0.1s;
            -webkit-animation-timing-function: linear;
            animation-timing-function: linear;
            /*-webkit-animation-iteration-count: 4;
            animation-iteration-count: 4;*/
            animation-iteration-count: infinite;
            -webkit-animation-direction: alternate;
            animation-direction: alternate;
            -webkit-animation-fill-mode: backwards;
            animation-fill-mode: backwards;
        }
        
        #img img{
            width: 10%;
        }
        
        .msg {
            position: absolute;
    color: white;
    background: green;
    padding: 10px;
    margin-bottom: 10px;
    display: inline-block;
            bottom: 0;
            
}

    </style>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="">HOME</a></li>
                <li><a href="./all_user_activity.php">User Activity</a></li>
                <?php if($login === 0):
                ?>
                <li><a href="./sinup.php">Sinup</a></li>
                <li><a href="./login.php">Login</a></li>
                <?php endif; ?>
                <?php
              if($login === 1):
              ?>
                <li><a href="./logout.php">Log Out</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
       <?php
        echo msg($_SESSION['msg'] ?? '');
        ?>
        <div id="welcome">
           <div id="img">
               <img src="./images/img.png" alt="">
           </div>
            <p>WELCOME <?php echo $email;?></p>
        </div>

    </main>
    <?php
    
    
    ?>


</body>

</html>
