<?php
session_start();
 error_reporting(0);
   require_once("inc/config.php");
   if(strlen($_SESSION['login_user'])==0)
{   
    header("Location:login.php"); 
}
  else
  {
    
   $ActivityId=$_GET['isbn'];
   $add_sql = $mysqli->query("DELETE FROM Book WHERE ISBN=$ActivityId");
   if($add_sql = TRUE){
       echo "<meta http-equiv='refresh' content='0'>";       
       echo "<script>alert('Successfully Events Deleted.');
                            window.location.href='EditBooks.php';
             </script>";
   }
}
?>