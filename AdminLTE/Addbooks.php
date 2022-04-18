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
        if(isset($_POST['addBooks'])){
          $bookIsbn = ($_POST['isbn']);
          $newsTitle = ($_POST['title']);
          $bookStock =($_POST['stock']);
          $bookAuthor = ($_POST['author']);
          $des = ($_POST['des']);

                define ("MAX_SIZE","55000");
                function getExtension($str) {
                        $i = strrpos($str,".");
                        if (!$i) { return ""; }
                        $l = strlen($str) - $i;
                        $ext = substr($str,$i+1,$l);
                        return $ext;
                }

                function reArrayFiles($file)
                {
                    $file_ary = array();
                    $file_count = count($file['name']);
                    $file_key = array_keys($file);                   
                    for($i=0;$i<$file_count;$i++)
                    {
                        foreach($file_key as $val)
                        {
                            $file_ary[$i][$val] = $file[$val][$i];
                        }
                    }
                    return $file_ary;
                }
                function error($msg){
                     echo $msg;
                }
                               
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {          
                        $img =$_FILES["file"];                     
                        if(!empty($img))
                         {
                            $img_desc = reArrayFiles($img);
                            foreach($img_desc as $val)
                            {
                               $filename = stripslashes($val['name']);
                               $extension = getExtension($filename);
                               $extension = strtolower($extension); 
                               $size=filesize($val['tmp_name']);
                               if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png")) 
                               {  
                                  error("Unknown Image Extension");
                               } 
                               else if ($size > MAX_SIZE*5024)
                               {
                                    error("You have exceeded the size limit");
                               }                               
                               else{
                                 $filename=$val['name'];
                                //  echo '<pre>';
                                //  print_r($mysqli);
                                //  echo '</pre>';
                                //  die;
                                 move_uploaded_file($val['tmp_name'],'../img/'.$val['name']);
                                $add_sql =$mysqli->query("INSERT INTO `Book` SET ISBN ='$bookIsbn', BookTitle='$newsTitle' ,Author='$bookAuthor', DescBook='$des', Stock='$bookStock',BookCoverPic = '$filename'");
                                //print_r($add_sql);
                              }
                            }
                         }

                     echo "<meta http-equiv='refresh' content='0'>";
                     echo "<script>alert('Successfully  Added.');
                           window.location.href='Addbooks.php';
                           </script>";
                    }
                }    
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="generator"
    content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Admin Panel</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
                folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css" />
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css" />
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css" />
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" />
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css" />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" />
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
        <h1>Add Book</h1>
        <ol class="breadcrumb">
          <li>
            <a href="#">Home</a>
          </li>
          <li class="active">Books</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- quick email widget -->
            <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">ADD Book</h3>
                <!-- tools box -->
                <div class="pull-right box-tools"></div>
                <!-- /. tools -->
              </div>
              <div class="box-body">
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                  <label>ISBN Number</label>
                  <input type="text" class="form-control" name="isbn" placeholder="ISBN Number">
                  </div>

                  <div class="form-group">
                  <label>Book Title</label>
                  <input type="text" class="form-control" name="title" placeholder="TITLE">
                  </div>

                  <div class="form-group">
                  <label>Author</label>
                  <input type="text" class="form-control" name="author" placeholder="AUTHOR">
                  </div>

                  <div class="form-group">
                  <label>Stock</label>
                  <input type="text" class="form-control" name="stock" placeholder="NUMBER OF BOOKS AVAILABLE">
                  </div>
                
                <label>DESCRIPTION</label>
                <div>
                  <textarea name="des" class="textarea" placeholder="Description"
                  style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>

                 <div class="form-group">
                   <label class="form-label">Upload Book Cover Photo</label> 
                   <input name="file[]" type="file" multiple="multiple" />
                 </div>
                   <div class="box-footer clearfix">
                      <button type="submit" name="addBooks" class="pull-right btn btn-default" id="sendEmail">Save </button>
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
    <b>Version</b> 2.3.12</div>
    <strong>Copyright © 2014-2016 
    <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.</footer>
  
    <!-- Add the sidebar's background. This div must be placed
                        immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <!-- jQuery 2.2.3 -->
  <script src="plugins/jQuery/jquery-2.2.3.min.js"></script> 
  <!-- jQuery UI 1.11.4 -->
   
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script> 
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
   
  <script>
      $.widget.bridge(&#39;uibutton&#39;, $.ui.button);
                
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
   
  <script src="dist/js/demo.js"></script></body>
</html>
<?php }?>