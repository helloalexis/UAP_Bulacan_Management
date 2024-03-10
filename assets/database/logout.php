<?php
session_start();
function logout()
{
    session_unset();
    session_destroy();
    session_regenerate_id(true);
    header("Location: /uap_management/index.php");
    exit();
}

logout();
