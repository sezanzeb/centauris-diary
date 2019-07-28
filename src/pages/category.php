<?php
    $config_path = "../content".$_SERVER['REQUEST_URI']."category.json";
    $_SESSION["config"] = json_decode(file_get_contents($config_path));

    // include and declare functions that will be available in template.php
    include("components/head.php");
    include("components/toc.php");
    include("../template.php");
?>
