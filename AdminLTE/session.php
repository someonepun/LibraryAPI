<?php
   include('inc/config.php');
   
   session_start();
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = $mysqli->query("select username from logins where username = '$user_check'");
   
   $row = $ses_sql->fetch_array();
   
   $login_session = $row['username'];
   
   if(!isset($_SESSION['login_user'])){
      header('location:login.php');
      exit();
   }
   
?>