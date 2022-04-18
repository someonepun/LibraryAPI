
<?php
    include('inc/config.php');
    session_start();
    $error='';
      if(isset($_POST['submits'])){
            $username = $_POST['username'];
            $password = ($_POST['password']);
            $sql = $mysqli->query("SELECT * FROM logins WHERE username = '$username' AND passwords = '$password'");
            $count = $sql->num_rows;
            if($count == 1) {
                $_SESSION['login_user'] = $username;
                header("location:index.php");
            }else {
                $error = "Your Login Name or Password is invalid";   
            }
    }
?>

<html>
<head>
<title>Librarian Login Page - ishelf</title>
<style type = "text/css">
body {
    font-family: Arial,Helvetica,sans-serif;
    font-size: 14px;
    background-color:#20D4EA;
}
label {
    font-size: 14px;
    font-weight: normal;
    width: 100px;
}
.box {
    border: 0px solid #666666;
}
.login-boxwrap {
    height: 100%;
    position: relative;
}
.login-box {
    height: 250px;
    left: 50%;
    margin-left: -175px;
    margin-top: -125px;
    max-width: 350px;
    position: absolute;
    background-color:white;
    top: 50%;
    border-radius:10px;
}
.login-box h2 {
    background-color: #005c5c;
    color: #fff;
    font-size: 15px;
    font-weight: normal;
    margin: 0;
    padding: 8px 15px;
    text-align: left;
    text-transform: uppercase;
}
.login-box form {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: currentcolor #ccc #ccc;
    border-image: none;
    border-style: none solid solid;
    border-width: 0 1px 1px;
    padding: 15px;
}
.login-box form label {
    display: inline-block;
    margin-right: 15px;
    width: 78px;
}
.login-box form .box {
    background-color: #fff;
    border: 1px solid #ccc;
    height: 30px;
    margin-bottom: 15px;
    padding: 5px 15px;
}
.login-box form input[type="submit"] {
    background-color: #007E7E;
    border: 0px solid #005c5c;
    color: #fff;
    display: block;
    margin-left:100px;
    padding: 7px 15px;
    width: 200px;
    text-transform: uppercase;
}
.error_message {
    background-color: #ffffff;
    color: red;
    font-size: 15px;
    padding: 5px 15px;
}

</style>
</head>

<body>
<div class="login-boxwrap">
<center><img src="images/librarian.png" height="110" width="110" id="logo" style="margin-top:100px;"/></center>
  <div class="login-box">
    <h2><b>Admin-Login</b></h2>
    <div>
      <form action = "" method = "post">
        <label>Username :</label>
        <input type = "text" name = "username" class = "box"/>
        <label>Password  :</label>
        <input type = "password" name = "password" class = "box" />
        <input type = "submit" value = " Login " name="submits">
      </form>
      <!--for displaying error-->
      <div class="error_message"><center><u><?php echo $error; ?></u></center></div>
    </div>
  </div>
</div>
</body>
</html>