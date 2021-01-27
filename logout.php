<?php
    session_start();
    $_SESSION['accessToken'] = null;
    header("Location: index.php");
?>