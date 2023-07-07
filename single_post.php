<?php include "header.php";
include "config.php";
if (isset($_SESSION['user_data'])){
    $userID=$_SESSION['user_data']['0'];
}
$id=$_GET['id'];
if (empty($id)) {
    header("location:index.php");
}
$sql="SELECT * FROM blog WHERE blog_id='$id'";
$run=mysqli_query($config,$sql);
$post=mysqli_fetch_assoc($run);
$sql2="SELECT * FROM blog LEFT JOIN categories ON blog.category=categories.cat_id LEFT JOIN users ON blog.author_id=users.user_id WHERE blog_id='$id' ORDER BY blog.publish_date DESC";

$query2=mysqli_query($config,$sql2);
//$rows2=mysqli_num_rows($query);

?>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body" >
                   <div id="single_img">
                    <?php $img=$post['blog_image'] ?>
                    <a href="../dynamic_blog/admin/upload/<?= $img ?>">
                       <img src="admin/upload/<?= $img ?>" alt="">
 
                    </a>
                    
                    
                    
                   
                    

                   </div> 
                  
                   <div class="side-align">
                   <?php 
                     $count=0;
                     while($post2=mysqli_fetch_assoc($query2)) {
                      ?>
                     <tr>
                    
                     
                     <?php } ?> 
                  
                     </tr>
                    
                    
                    <h1><?=ucfirst($post['blog_title']) ?></h1>
                    <p><?= $post['blog_body'] ?></p>
                   </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row">
    
                 <div class="col-lg-12">
                   <form class="form-horizontal" action="comment.php" method="POST">
                   <input type="hidden" name="id" value=<?php echo $id;?>>
                   <div class="form-group">
                     <label class="col-lg-3 control-label" >Add comment</label>
                     <div class="col-lg-9">
                       <textarea class="form-control" rows="3" col="3" name="comment" placeholder="comment"></textarea>
                     </div>
                   </div>
                   <br>
                   <input type="submit" name="postcomment" value="Comment" class="btn-btn-primary">
                 </form>
                 
                 </div>
                    
                 </div>
 <br>
                 <div class="row">
                 
                 <div class="col-lg-12">
                   <h3>comments</h3>
                   <?php
                   $com_query = "SELECT * FROM comments WHERE blog_id = '$id' ORDER BY id DESC";
                   $coms_result = mysqli_query($config,$com_query)or die("error");
                   if(mysqli_num_rows($coms_result) > 0){
                     while($posts = mysqli_fetch_assoc($coms_result)){
                      
                       $comment = $posts['comment'];
                     ?>
                     <p><?php echo $comment;?></p>
                     <?php
 
                     }
                   }
                   ?>
               
                </div>
                 
                 </div>
</div>
</div>

</div>
<?php include "footer.php" ?>
