<div class="clearfix"></div>
</div>
<div class="x_content">
<div class="row">
  <div class="col-sm-12">
  <div class="card-box table-responsive">

<table id="datatable-responsive" class="table table-bordered table-striped dt-responsive nowrap" cellspacing="0" width="100%">
<thead>
<tr>
<th>ID</th>
      <th>Username</th>
      <th>Email</th>
      <th>Category</th>
      <th>Image</th>
      <th>Actions</th>
</tr>
</thead>
<tbody>
<?php
    require_once "includes/conn.php";
    $sql ="SELECT * FROM users";
    $query = $conn->query($sql);
    while($row = $query->fetch_assoc()){

?>
 <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><img src="../<?php echo $row['image']; ?>" width="50" height="50"></td>
                        <td>
    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm edit"><i class="fa fa-edit"></i> EDIT</a>
    <a href="../delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm delete" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-trash"></i> DELETE</a>
</td>
</tr>
              <?php
              }
                ?>
          </tbody>
      </table>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- /page content -->

<!-- footer content -->
<footer>
<div class="pull-right">
<a href="../add_user.php">Add New</a>
</div>
<div class="clearfix"></div>
</footer>
<!-- /footer content -->
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
	</script>
  </body>
</html>