<?php include"header.php" ;
if ($admin!=1){
  header("location:index.php");
} 
$config=mysqli_connect("localhost","root","","blog_web") or die("DB Not connected");
$sql="SELECT * FROM users";
$query=mysqli_query($config,$sql);
$row=mysqli_num_rows($query);
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h5 class="mb-2 text-gray-800">Users
  </h5>
  <!-- DataTales Example -->
  <div class="card shadow">
    <div class="card-header py-3 d-flex justify-content-between">
      <div>
        <a href="add_user.php">
          <h6 class="font-weight-bold text-primary mt-2">Add New
          </h6>
        </a>
      </div>
      <div>
        <form class="navbar-search">
          <div class="input-group">
            <input type="text" class="form-control bg-white border-0 small" placeholder="Search for...">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button"> 
                <i class="fa fa-search">
                </i> 
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Sr.No
              </th>
              <th>Username
              </th>
              <th>Email
              </th>
              <th>Role
              </th>
              <th colspan="2">Action
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
            $count=0;
            if ($row) {
               while($result=mysqli_fetch_assoc($query)){
                  ?>
                  <tr>
                    <td><?=++$count ?></td>
                    <td><?=$result['username'] ?></td>
                    <td><?=$result['email'] ?></td>
                    <td><?php 
                    $role=$result['role'];
                    if($role==1){
                      echo "Admin";
                    }
                    else{
                      echo "Co-Admin";
                    }
                     ?>
                    </td>
                    <td>
                     
                      <form class="mt-2" action="" method="POST" onsubmit="return confirm('Are you sure you want to delete?')">
                          <input type="hidden" name="userid" value="<?= $result['user_id'] ?>">
                            <input type="submit" name="deleteUser" value="Delete" class="btn btn-sm btn-danger">
                        </form> 
                      
                    </td>
                  </tr>
                  <?php
            }
          }
            else{

               ?>
               <tr>
                <td>No record found</td>
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
<!-- /.container-fluid -->
</div>
<?php include "footer.php";
if(isset($_POST['deleteUser'])) {
  $id=$_POST['userid'];
  $delete="DELETE FROM users WHERE user_id='$id'";
  $run=mysqli_query($config,$delete);
  if($run){
      $msg =['user has been deleted successfully','alert-success'];
        $_SESSION['msg']=$msg;
      header("location:users.php");
  }
  else{
      $msg =['failed,please try again','alert-danger'];
        $_SESSION['msg']=$msg;
      header("location:users.php");
}
}
?>


