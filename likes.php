<?php
//include 'header.php';
 session_start();?>
<?php if(!isset($_SESSION['user_data'])):?>
<?php header("location:index.php");?>
<?php else:?>
<?php include 'config.php';
$user_id=$_SESSION['id'];
 if(isset($_POST['like'])) {
      
      $blog_id=$_SESSION['id'];
     
     
        $sql="INSERT INTO likes(user_id,blog_id) VALUES ('$user_id','$blog_id')";
        $query=mysqli_query($config,$sql);
        if($query){
            header("location:index.php?id=" . $blog_id);
        }
      }
  
 ?> 
 <?php endif;?>