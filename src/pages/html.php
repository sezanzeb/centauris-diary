<?php
    // include and declare functions that will be available in template.php
    include("components/head.php");
    
    function render_content()
    {
        $url = $_SERVER['REQUEST_URI'];
        $file = "../content".$url."index.html";
        if(!is_file($file))
        {
            $file = "../content".$url;
        }
        include($file);
    }

    include("../template.php");
?>
