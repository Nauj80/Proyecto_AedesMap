<?php

if (!isset($_SESSION['auth']) || $_SESSION['auth'] != "ok") {
    redirect("../view/login/Login.php");
}
?>