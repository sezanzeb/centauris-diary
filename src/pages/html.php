<?php
    // include and declare functions that will be available in template.php
    include("components/head.php");
    
    function render_content()
    {
        $url = $_SERVER['REQUEST_URI'];
        $file = "../content".$url."index.html";
        $page_config = "../content".$url."page.json";
        $config = json_decode(file_get_contents($page_config));
        if(is_file($page_config))
        {
            print("<h1>");
            print($config->title);
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
