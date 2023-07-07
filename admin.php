<h3>welcome </h3>
<?php
     if(isset($_SESSION['error'])) {
         echo $_SESSION['user_data'][1];
             unset($_SESSION['error']);
                }
                 ?>