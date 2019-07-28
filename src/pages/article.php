<?php
    $config_path = "../content".$_SERVER['REQUEST_URI']."article.json";
    $_SESSION["config"] = json_decode(file_get_contents($config_path));

    // include and declare functions that will be available in template.php
    include("components/head.php");
    include("components/toc.php");

    function render_content()
    {
        $url = $_SERVER['REQUEST_URI'];

        $article_path = $url."index.html";
        $article_path_relative = "../content/".$article_path;

        print("<div class=\"article\">");
        print("<h2>");
        print($_SESSION["config"]->title);
        print("</h2>");
        if(is_file($article_path_relative))
        {
            $timestamp = $_SESSION["config"]->timestamp;
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
