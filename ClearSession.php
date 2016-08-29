<?php
    if (session_id() == "") session_start();
    header('Location: register.html#' . $_REQUEST['EventCode']);
    echo('Location: register.html#' . $_REQUEST['EventCode']);
    $data = array();
    $_SESSION["RegData"] =  $data;
?>