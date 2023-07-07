<?php
//include 'header.php';
 session_start();?>
<?php if(!isset($_SESSION['user_data'])):?>
<?php header("location:index.php");?>
<?php else:?>
<?php include 'config.php';

    if(isset($_POST['postcomment'])){
        $user_id = $_SESSION['id']; 
        $blog_id =$_POST['id'];
        $comment = $_POST['comment'];
        if($comment != ""){
           
            $sql ="INSERT INTO comments (user_id, blog_id, comment) VALUES('$user_id', '$blog_id','$comment')";

        $query = $config->query($sql);
        if($query){
            header("header:index.php?id=" . $blog_id);

        }
        }

    }
?>
<?php endif;?>




