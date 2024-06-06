<?php
function check_login() {
    session_start();
    if (!isset($_SESSION['is_loged_in'])) {
        header("Location: login.php");
        exit();
    }
    return True;
}
?>