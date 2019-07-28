<?php
    // include and declare functions that will be available in template.php
    include("components/head.php");
    include("components/toc.php");

    function render_content()
    {
        $url = $_SERVER['REQUEST_URI'];

        $article_path = $url."index.html";
        $article_path_relative = "../content/".$article_path;
        
        $config_path_relative = "../content".$url."article.json";
        $config = json_decode(file_get_contents($config_path_relative));

        print("<div class=\"article\">");
        print("<h2>");
        print($config->title);
        print("</h2>");
        if(is_file($article_path_relative))
        {
            $timestamp = $config->timestamp;
            if(!isset($timestamp))
            {
                $timestamp = filectime($article_path_relative);
            }
            echo("<h3>".date("F d, Y", $timestamp)."</h3>");
            include($article_path_relative);
        }
        print("</div>");
    }

    include("../template.php");
?>
