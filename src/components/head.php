<?php
	function render_title()
	{
        if($_SESSION["config"] != NULL)
        {
			print($_SESSION["config"]->title);
			return;
		}
		
		// title for the <title> tag of the website
		$url = $_SERVER['REQUEST_URI'];
		$file = "../content".$url."index.html";
		$title = "Home";
		if($url != "/")
		{
			$title = $url;
			if(strcmp(substr($title, -1), "/") === 0)
			{
				$title = substr($title, 0, -1);
			}
			// get filename without extension
			$title = ucfirst(reset(explode(".", end(explode("/", $title)))));
			$title = str_replace("_", " ", $title);
		}
		print($title);
	}
	
	function render_nav()
	{
		$url = $_SERVER["REQUEST_URI"]; //to check which item should be active later

		$content_path = dirname(__FILE__, 3)."/content/";
		//list of menu items
		$nav = [];
		foreach(scandir($content_path) as $subdir)
		{
			$entry = [];
			$category_config_path = $content_path.$subdir."/category.json";
			if(is_file($category_config_path))
			{
				$category_config = json_decode(file_get_contents($category_config_path));
				$category_config->url = "/".$subdir."/";
				$nav[] = $category_config;
			}

			$page_config_path = $content_path.$subdir."/page.json";
			if(is_file($page_config_path))
			{
				$page_config = json_decode(file_get_contents($page_config_path));
				$page_config->url = "/".$subdir."/";
				$nav[] = $page_config;
			}
		}

		// activeindex is used to check which element of the main nav is currently active
		$activeindex = -1;

		$i = 0;
		foreach($nav as $item)
		{
			//check if this item should be active by checking if the <filename>.php appears in the url
			$uppermost_parent = ("/".explode("/", $url)[1]."/");
			if (strcmp($uppermost_parent, $item->url) === 0)
			{
				$activeindex = $i;
				break;
			}
			$i ++;
		}
		
		$i = 0;
		print('<ul class="nav" id="topnav">');
		foreach($nav as $item)
		{
			// add a class to the currently visiting page in the navigation
			// in order to style it differently
			$a_class = "";
			if($i == $activeindex)
			{
				$a_class = "class=\"active\"";
			}

			$li_class = "";
			if($item->class != NULL)
			{
				$li_class = "class=".$item->class;
			}

			$url = $item->url;
			$icon = $ite->icon;
			$title = $item->title;
			echo <<< EOT
			<li $li_class>
				<a $a_class href="$url">
					<i class="$icon"></i>
					$title
				</a>
			</li>
EOT;
			$i ++;
		}
		print('</ul>');
	}
?>
