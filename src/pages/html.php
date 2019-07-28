<?php
    $config_path = "../content".$_SERVER['REQUEST_URI']."page.json";
    $_SESSION["config"] = json_decode(file_get_contents($config_path));

    // include and declare functions that will be available in template.php
    include("components/head.php");
    
    function render_content()
    {
        $url = $_SERVER['REQUEST_URI'];
        $file = "../content".$url."index.html";
        if($_SESSION["config"] != NULL)
        {
            print("<h1>");
            print($_SESSION["config"]->title);
            print("</h1>");
        }
        if(!is_file($file))
        {
            $file = "../content".$url;
        }
        include($file);
    }

    include("../template.php");
?>
