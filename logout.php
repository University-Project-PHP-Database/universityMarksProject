<?php
    session_start();

    session_destroy();

    header('location:3.index1.php');
?>