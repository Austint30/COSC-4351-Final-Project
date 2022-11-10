<?php

    function renderMsgs(){
        if (isset($_GET["errormsg"])){
            echo '<div class="alert alert-danger mb-2" role="alert">'.$_GET["errormsg"].'</div>';
        }
        if (isset($_GET["successmsg"])){
            echo '<div class="alert alert-success mb-2" role="alert">'.$_GET["successmsg"].'</div>';
        }
    }

?>