<?php
    if (session_id() == "") session_start();

    if (isset($_SESSION["SaveData"]))
    {
        header('Location: register.html#' . $_REQUEST['EventCode']);
        $data = $_SESSION["SaveData"];
        $data['firstName'] = 'Restored';
        $_SESSION["RegData"] =  $data;
    }
    else
    {
        //echo('Location: register.html#' . $_REQUEST['EventCode']);
        echo "There is no saved session data<br>";

        echo 'The following session values exist:<br><ul>';
        foreach( $_SESSION as $key =>$value )
        {
            echo "<li>$key</li>";
        }
        echo '</ul>';

        echo '<a href="register.html#' . $_REQUEST['EventCode'] . '">[Return]</a>';
    }
?>