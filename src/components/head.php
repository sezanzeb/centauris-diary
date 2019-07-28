<?php
	function render_title()
	{
		$url = $_SERVER["REQUEST_URI"];
		// title for the <title> tag of the website
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
				$entry["icon"] = $category_config->icon;
				$entry["name"] = $category_config->title;
				$entry["category"] = "/".$subdir."/";
				$entry["class"] = $category_config->class;
				$nav[] = $entry;
			}

			$page_config_path = $content_path.$subdir."/page.json";
			if(is_file($page_config_path))
			{
				$page_config = json_decode(file_get_contents($page_config_path));
				$entry["icon"] = $page_config->icon;
				$entry["name"] = $page_config->title;
				$entry["category"] = "/".$subdir."/";
				$entry["class"] = $page_config->class;
				$nav[] = $entry;
			}
		}

		// activeindex is used to check which element of the main nav is currently active. a headline in the correct color
		// will be rendered automatically
		$activeindex = -1;

		$i = 0;
		foreach($nav as $item)
		{
			//check if this item should be active by checking if the <filename>.php appears in the url
			$uppermost_parent = ("/".explode("/", $url)[1]."/");
			if (strcmp($uppermost_parent, $item["category"]) === 0)
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
			if($item["class"] != NULL)
			{
				$li_class = "class=".$item["class"];
			}

			$category = $item["category"];
			$icon = $item["icon"];
			$name = $item["name"];
			echo <<< EOT
			<li $li_class>
				<a $a_class href="$category">
					<i class="$icon"></i>
					$name
				</a>
			</li>
EOT;
		$i ++;
		}
		print('</ul>');
	}
?>
