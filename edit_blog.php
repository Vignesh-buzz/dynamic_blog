<?php include "header.php"; 
if (isset($_SESSION['user_data'])) {
  $author_id=$_SESSION['user_data']['0'];
}
$config=mysqli_connect("localhost","root","","blog_web") or die("DB Not connected");
//fetch_categories
$sql1="SELECT * FROM categories";
//$sql2="SELECT * FROM authors";
$query1=mysqli_query($config,$sql1);
//$query2=mysqli_query($config,$sql2);
//get blog id
 $blogID=$_GET['id'];
 $sql3="SELECT * FROM blog LEFT JOIN categories ON blog.category=categories.cat_id LEFT JOIN users ON blog.author_id=users.user_id WHERE blog_id='$blogID'";
 $query3=mysqli_query($config,$sql3);
$result=mysqli_fetch_assoc($query3);
?>
<div class="container">
   <h5 class="mb-2 text-gray-800">Blogs
   </h5>
  <div class="row">
    <div class="col-xl-8 col-lg-6">
      <div class="card">
        <div class="card-header">
           <h6 class="font-weight-bold text-primary mt-2">Edit blog/article
           </h6>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="text" name="blog_title" placeholder="Title" class="form-control" required value="<?=$result['blog_title']?>">

                </div>
                <div class="mb-3">
                    <label>Body/Description</label>
                    <textarea required class="form-control" name="blog_body" rows="2" id="blog"><?=$result['blog_body']?></textarea>
                </div>
                <div class="mb-3">
                    <input type="file" name="blog_image" class="form-control"> 
                    <img src="upload/<?=$result['blog_image']?>" width="100px" class="border">
                </div>
                

                
                <div class="mb-3">
                   <select class="form-control" name="category" required>
                   <option value="">select category</option>
                    <?php
                     while($cats=mysqli_fetch_assoc($query1)) { ?>
                    
                    <option value="<?=$cats['cat_id'] ?>"
                      
                       <?=($result['category']==$cats['cat_id']) ?"
                         selected":'';?>>
                
                       <?=$cats['cat_name'] ?>
                    </option>
                    <?php } ?>
        </select> 
                </div>
                <div class="mb-3">
                   <input type="submit" name="edit_blog" value="Update" class="btn btn-primary">
                   <a href="index.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div> 
</div>
<?php include "footer.php";
if(isset($_POST['edit_blog'])){
    $title=mysqli_real_escape_string($config,$_POST['blog_title']);
    $body=mysqli_real_escape_string($config,$_POST['blog_body']);
   // $author=mysqli_real_escape_string($config,$_POST['author_name']);
    $filename=$_FILES['blog_image']['name'];
    $tmp_name=$_FILES['blog_image']['tmp_name'];
    $size=$_FILES['blog_image']['size'];
    $image_ext=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
    $allow_type=['jpg','png','jpeg'];
    $destination="upload/".$filename;
    $category=mysqli_real_escape_string($config,$_POST['category']);
    if(!empty($filename)) {
        if(in_array($image_ext,$allow_type)) {
            if($size <= 2000000){
                $unlink="upload/".$result['blog_image'];
                unlink($unlink);
                move_uploaded_file($tmp_name,$destination);
                $sql4="UPDATE blog SET blog_title='$title',blog_body='$body',blog_image='$filename',category='$category',author_id='$author_id' WHERE blog_id='$blogID'";
                $query4=mysqli_query($config,$sql3);
                if($query3) {
                    $msg =['blog has been updated successfully','alert-success'];
                    $_SESSION['msg']=$msg;
                    header("location:index.php");
                 }
               
               else
               {
                  $msg =['failed,please try again','alert-danger'];
                  $_SESSION['msg']=$msg;
                  header("location:index.php");
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
    else{
        $sql3="UPDATE blog SET blog_title='$title',blog_body='$body',category='$category',author_id='$author_id' WHERE blog_id='$blogID'";
        $query3=mysqli_query($config,$sql3);
        if($query3) {
            $msg =['post updated successfully','alert-success'];
            $_SESSION['msg']=$msg;
            header("location:index.php");
         }
       
       else{
          $msg =['failed,please try again','alert-danger'];
          $_SESSION['msg']=$msg;
          header("location:index.php");
    } 
    }
}
?>
   
        



