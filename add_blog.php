<?php include "header.php"; 
if (isset($_SESSION['user_data'])) {
  $author_id=$_SESSION['user_data']['0'];
}
$config=mysqli_connect("localhost","root","","blog_web") or die("DB Not connected");
//$sql="SELECT * FROM authors";
//$query=mysqli_query($config,$sql);
$sql2="SELECT * FROM categories";
$query2=mysqli_query($config,$sql2);

?>
<div class="container">
   <h5 class="mb-2 text-gray-800">Blogs
   </h5>
  <div class="row">
    <div class="col-xl-8 col-lg-6">
      <div class="card">
        <div class="card-header">
           <h6 class="font-weight-bold text-primary mt-2">publish blog/article
           </h6>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="text" name="blog_title" placeholder="Title" class="form-control" required>

                </div>
                <div class="mb-3">
                    <label>Body/Description</label>
                    <textarea class="form-control" name="blog_body" rows="2" id="blog"></textarea>
                </div>
                <div class="mb-3">
                    <input type="file" name="blog_image" class="form-control" required> 
                </div>           
                            
                <div class="mb-3">
                  <select class="form-control" name="category" required>
                    <option value="">select category</option>
                    <?php while($cats=mysqli_fetch_assoc($query2)) { ?>
                    
                    <option value="<?=$cats['cat_id'] ?>"><?=$cats['cat_name'] ?></option>
                    <?php } ?>
                  </select> 
                </div>
                <div class="mb-3">
                   <input type="submit" name="add_blog" value="Add" class="btn btn-primary">
                   <a href="index.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div> 
</div>
<?php include "footer.php";
if(isset($_POST['add_blog'])){
    $title=mysqli_real_escape_string($config,$_POST['blog_title']);
    $body=mysqli_real_escape_string($config,$_POST['blog_body']);
    //$author=mysqli_real_escape_string($config,$_POST['author_id']);
    $filename=$_FILES['blog_image']['name'];
    $tmp_name=$_FILES['blog_image']['tmp_name'];
    $size=$_FILES['blog_image']['size'];
    $image_ext=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
    $allow_type=['jpg','png','jpeg'];
    $destination="upload/".$filename;
    $category=mysqli_real_escape_string($config,$_POST['category']);

    
    
    if(in_array($image_ext,$allow_type)) {

      if($size <= 2000000){

          move_uploaded_file($tmp_name,$destination);

          $sql3="INSERT INTO blog(blog_title,blog_body,blog_image,category,author_id) VALUES ('$title','$body','$filename','$category','$author_id')";

          $query3=mysqli_query($config,$sql3);

          if($query3) {

                  $msg =['blog has been added successfully','alert-success'];

                  $_SESSION['msg']=$msg;

                  header("location:add_blog.php");

               }

         

          else{

              $msg =['failed,please try again','alert-danger'];

              $_SESSION['msg']=$msg;

              header("location:add_blog.php");

          }  

          }

          else{

         

            $msg =['image size should not be greater than 2mb','alert-danger'];

            $_SESSION['msg']=$msg;

            header("location:index.php");

      }

    }

 else{

     $msg =['file type is not allowed','alert-danger'];

     $_SESSION['msg']=$msg;

     header("location:index.php");

 }  

 }

 






?>