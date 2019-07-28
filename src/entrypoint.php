<?php
    /**
     * this file acts as the starting point and imports, depending on the request, the functions used
     * to render in template.php
     */
    
    $url = $_SERVER['REQUEST_URI'];

    $ext = pathinfo($url, PATHINFO_EXTENSION);

    /**
     * $target is one of "toc" "title" "content" or "nav"
     */
    function render($target)
    {
        $target = "render_".$target;
        if(function_exists($target))
        {
            $target();
        }
    }

    // the static directory contains scripts and styles, which
    // are of the highest priority, and is therefore checked first
    if(is_file("../static/".$url))
    {
        include("../static".$url);
    }

    // content category?
    else if(is_file("../content".$url."category.json"))
    {
        include("pages/category.php");
    }
    // content article?
    else if(is_file("../content".$url."article.json"))
    {
        include("pages/article.php");
    }

    // html files in the content directory will include header and footer
    else if(strcmp($ext, "html") === 0 and is_file("../content/".$url))
    {
        include("pages/html.php");
    }
    else if(is_file("../content".$url."index.html"))
    {
        include("pages/html.php");
    }
?>
