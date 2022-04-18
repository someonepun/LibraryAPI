
<?php

session_start();
error_reporting(0);
require_once("inc/config.php");

if(strlen($_SESSION['login_user'])==0){   
  header("Location:login.php"); 
}
else{
      $successMsg = "";
      $scr = "";
      $ActivityId=$_GET['isbn'];
      
      $Blogs = $mysqli->query("select * from Book where isbn=$ActivityId");
      $SiProjects=$Blogs->fetch_array();

      $isbn = $SiProjects['ISBN'];
      $title=$SiProjects['BookTitle'];
      $author = $SiProjects['Author'];
      $stock = $SiProjects['Stock'];
      $desc=$SiProjects['DescBook'];
      $photo=$SiProjects['BookCoverPic'];

      $filename16=$photo;
      if(isset($_POST['newsSubmit'])){
        $Isbn = ($_POST['isbn']);
        $Title = ($_POST['title']);
        $Stock =($_POST['stock']);
        $Author = ($_POST['author']);
        $des = ($_POST['des']);

        define ("MAX_SIZE","55000");
        function getExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
      } 

      $errors=0;
      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        $image =$_FILES["file"]["name"];
        $uploadedfile = $_FILES['file']['tmp_name'];  
        if ($image) 
        {
          $filename = stripslashes($_FILES['file']['name']);
          $extension = getExtension($filename);
          $extension = strtolower($extension);
      if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
      {

        $change='<div class="msgdiv">Unknown Image extension </div> ';
        $errors=1;
      }
      else
      {

      $size=filesize($_FILES['file']['tmp_name']);
      if ($size > MAX_SIZE*5024)
      {
        $change='<div class="msgdiv">You have exceeded the size limit!</div> ';
        $errors=1;
      }

      if($extension=="jpg" || $extension=="jpeg" )
      {
        $uploadedfile = $_FILES['file']['tmp_name'];
        $src = imagecreatefromjpeg($uploadedfile);


      }
      else if($extension=="png")
      {
        $uploadedfile = $_FILES['file']['tmp_name'];
        $src = imagecreatefrompng($uploadedfile);
    }
    else
      {
        $src = imagecreatefromgif($uploadedfile);
      }
      echo $scr;
      list($width,$height)=getimagesize($uploadedfile);
      $newwidth=120;
      $newheight=94;
      $newwidth1=$width;
      $newheight1=$height;
      $tmp1=imagecreatetruecolor($newwidth1,$newheight1);
      imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);
      $filename1 = "../img/".strtolower(($_FILES['file']['name']));
      $filename16 =strtolower(($_FILES['file']['name']));
      imagejpeg($tmp1,$filename1,100);
      imagedestroy($src);
      imagedestroy($tmp1);
    }
  }
}

$add_sql = $mysqli->query("UPDATE Book SET ISBN ='$Isbn', BookTitle='$Title',Author='$Author', DescBook='$des', Stock='$Stock',BookCoverPic = '$filename' WHERE isbn='$ActivityId'");

if($add_sql = TRUE){
   echo "<meta http-equiv='refresh' content='0'>";
   echo "<script>alert('Successfully  Updated.');
                 window.location.href='Editaboutus.php';
         </script>";
}else{
  $successMsg = '<div class="alert alert-success">Some Error!!!</div>';
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php
    #top nav, aside menu
    require_once("inc/header.php");
    ?>
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
        About us
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">About us</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <?=$successMsg?>
            <!-- quick email widget -->
            <div class="box box-info">
              <div class="box-header">
                <i class="fa fa-envelope"></i>

                <h3 class="box-title">EDIT About us</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                </div>
                <!-- /. tools -->
              </div>
              <div class="box-body">
                <form action="" method="post" enctype="multipart/form-data">
                  
                  <div class="form-group">
                  <label>ISBN Number</label>
                  <input type="text" class="form-control" name="isbn" value="<?=$isbn?>" placeholder="ISBN Number">
                  </div>

                  <div class="form-group">
                  <label>Book Title</label>
                  <input type="text" class="form-control" name="title" value="<?=$title?>"  placeholder="TITLE">
                  </div>

                  <div class="form-group">
                  <label>Author</label>
                  <input type="text" class="form-control" name="author" value="<?=$author?>" placeholder="AUTHOR">
                  </div>

                  <div class="form-group">
                  <label>Stock</label>
                  <input type="text" class="form-control" name="stock" value="<?=$stock?>" placeholder="NUMBER OF BOOKS AVAILABLE">
                  </div>
                
                  <div class="form-group">
                  <label>DESCRIPTION</label>
                  <div>
                    <textarea name="des" class="textarea" 
                    style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?=$desc?></textarea>
                  </div>

                  <div class="form-group">
                    <label class="form-label">Upload Photo</label>
                    <input name="file" type="file"/>

             </div>
                  
                  <div class="box-footer clearfix">
                    <button type="submit" name="newsSubmit" class="pull-right btn btn-default" id="sendEmail">Save
                      <i class="fa fa-arrow-circle-right"></i></button>
                    </div>
                  </form>
                </div>
              </div>

            </section>
            <!-- /.Left col -->

          </div>
          <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.12
        </div>
        <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
        reserved.
      </footer>

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>

<?php }?>