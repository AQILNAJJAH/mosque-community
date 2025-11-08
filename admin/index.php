<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>
  <link rel="icon" href="../image/mosque.png" type="image/png">
  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
</head>
<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="../index.html" class="site_title"><i class="fa fa-adjust"></i> <span>Al-A'la System</span></a>
          </div>
          <?php
            session_start();
            require_once "includes/conn.php";

            // Check if the user is logged in
            if (!isset($_SESSION['user_id'])) {
                // Redirect to login page if not logged in
                header("Location: ../login.php");
                exit();
            }

            // Retrieve user information from session
            $user_id = $_SESSION['user_id'];

            // Fetch user information from the database
            $sql = "SELECT username, image FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if user exists
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
            } else {
                // Handle case where user is not found
                echo "User not found";
                exit();
            }
          ?>

          <div class="clearfix"></div>
          <div class="profile clearfix">
              <div class="profile_pic">
                  <img src="../<?php echo htmlspecialchars($user['image']); ?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                  <span>Welcome,</span>
                  <h2><?php echo htmlspecialchars($user['username']); ?></h2>
              </div>
          </div>

          <br />
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>Dashboard</h3>
              <ul class="nav side-menu">
                <li><a href="#" data-target="dashboard.php"><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a></li>
                <li><a href="#" data-target="community.php"><i class="fa fa-edit"></i> Community <span class="fa fa-chevron-down"></span></a></li>
                <li><a href="#" data-target="booking.php"><i class="fa fa-desktop"></i> Booking <span class="fa fa-chevron-down"></span></a></li>
                <li><a href="#" data-target="donation.php"><i class="fa fa-money"></i> Donation <span class="fa fa-chevron-down"></span></a></li>
                <li><a href="../admin.php"><i class="fa fa-shopping-bag"></i> Hajj/Umrah Essentials <span class="fa fa-chevron-down"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen"><span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span></a>
            <a data-toggle="tooltip" data-placement="top" title="Lock"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></a>
          </div>
        </div>
      </div>
      <div class="top_nav">
        <div class="nav_menu">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
          <nav class="nav navbar-nav">
            <ul class="navbar-right">
              <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                  <img src="../<?php echo htmlspecialchars($user['image']); ?>" alt=""><?php echo htmlspecialchars($user['username']); ?>
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="../update_user.php"> Profile</a>
                  <a class="dropdown-item" href="../logout.php"> Logout</a>
                </div>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>LIST OF RECORDS</h3>
            </div>
            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search for...">
                  <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button">Go!</button>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Lists</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Settings 1</a>
                        <a class="dropdown-item" href="#">Settings 2</a>
                      </div>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content" id="content">
                  <!-- Dynamic content will be loaded here -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer>
        <div class="pull-right">2022</div>
        <div class="clearfix"></div>
      </footer>
    </div>
  </div>
  <!-- jQuery -->
  <script src="../vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- FastClick -->
  <script src="../vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="../vendors/nprogress/nprogress.js"></script>
  <!-- iCheck -->
  <script src="../vendors/iCheck/icheck.min.js"></script>
  <!-- Datatables -->
  <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="../vendors/jszip/dist/jszip.min.js"></script>
  <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="../build/js/custom.min.js"></script>
  <script>
    $(document).ready(function() {
      // Handle other dynamic content loading here
      $('a[data-target]').click(function(event) {
        event.preventDefault();
        var targetUrl = $(this).data('target');
        $('#content').load(targetUrl);
      });
    });
  </script>
</body>
</html>