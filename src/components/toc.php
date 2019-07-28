<?php
    function render_toc()
    {
        // table of contents of a category
    
        // url is /category/article/
        $category_name = explode('/', $_SERVER['REQUEST_URI'])[1];
        $category_relative = "../content/".$category_name."/"; // the actual path to the category, relative to this php file
        $category_config = json_decode(file_get_contents($category_relative."category.json"));
        
        // for each page in the blog/ directory of the server
        // add an url to the navigation. Sort by newest article
        $articles = scandir($category_relative);
        // $path => [filename, date], then sort
        $blogentries = [];
        foreach($articles as $article)
        {
            $path = $category_relative.$article;
            $config_path = $path."/article.json";
            if(is_file($config_path))
            {
                $config = json_decode(file_get_contents($config_path));
                $index = $path."/index.html";
                $timestamp = $config->timestamp;
                if(!isset($timestamp))
                {
                    $timestamp = filectime($index);
                }
                $blogentries[$path] = [$article, $timestamp];
            }
        }
        // sort by second column (index 1)
        array_multisort(array_column($blogentries, 1), SORT_DESC, $blogentries);
        
        echo <<< EOT
    <h1 class="$category_config->class">$category_config->title</h1>
    <div id="Tableofcontents" class="section">
        <h2>Articles</h2>
        <ul>
EOT;
        // now build the navigation page by page
        foreach($blogentries as $path => [$article_folder, $date])
        {
            $article_config = json_decode(file_get_contents($path."/article.json"));
            $name = $article_config->title;
            echo("<li><a href='/".$category_name."/".$article_folder."/'>");
            echo($name.", ".date("F d, Y", $date));
            echo("</a></li>\n");
        }
        echo <<< EOT
        </ul>
    </div>
EOT;
    }
?>
