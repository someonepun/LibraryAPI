<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin Panel </b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">Admin</span>
          
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                <p>
                  Admin
                </p>
              </li>
             <!-- Menu Footer-->
              <li class="user-footer">
               <div class="pull-right">
                  <a href="logout.php">Logout</a>
                </div>
              </li>
            </ul>
          </li>
         </ul>
      </div>
    </nav>
  </header>
<aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="home">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
         
         <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Books</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="Addbooks.php"><i class="fa fa-circle-o"></i>Add Book</a></li>
            <li><a href="Editbooks.php"><i class="fa fa-circle-o"></i> Edit Book</a></li>
          </ul>
        </li>
    </ul>
    </section>
    <!-- /.sidebar -->
  </aside>