<?php include "header.php";
$id=$_GET['id'];
$sql="SELECT * FROM users WHERE user_id='$id'";
$query=mysqli_query($config,$sql);
$row=mysqli_fetch_assoc($query);

?>
<div class="container">
   <h5 class="mb-2 text-gray-800">Users
   </h5>
  <div class="row">
    <div class="col-xl-6 col-lg-5">
      <div class="card">
        <div class="card-header">
           <h6 class="font-weight-bold text-primary mt-2">Edit user
           </h6>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <input type="text" name="username" placeholder="username" class="form-control" required value="<?= $row['username']; ?>">
                </div>
                <div class="mb-3">
                   <input type="submit" name="update_user" value="Update" class="btn btn-primary">
                   <a href="users.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div> 
</div>
<?php include "footer.php";
$config=mysqli_connect("localhost","root","","blog_web") or die("DB Not connected");
if(isset($_POST['update_user'])) {
   
    $author_name=mysqli_real_escape_string($config,$_POST['username']);
   $sql2="UPDATE users SET username='$username' WHERE user_id='{$id}'";
   $update=mysqli_query($config,$sql2);
   if($update) {
    $msg =['user has been updated successfully','alert-success'];
    $_SESSION['msg']=$msg;
    header("location:users.php");
 }
 else{
     $msg=['failed,please try again','alert-danger'];
     $_SESSION['msg']=$msg;
     header("location:users.php");
 } 
}




?>