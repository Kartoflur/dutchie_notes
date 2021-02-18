<?php
    session_start();
    if(isset($_GET['logout']))        //kung ma tuplok tong logout nga button nga naa sa index.php
    {
        session_destroy();
        header("location:../html/login.php");
    }

?>
