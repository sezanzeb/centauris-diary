<!DOCTYPE html>
<html>
	<head lang="en">
	    <meta charset="utf-8"/>
		<title><?php render("title") ?> | Centauri's Diary</title>
		<link rel="stylesheet" href="/style.css"/>
	</head>
	<body>
		<div id="main">
			<div id="title">
				<h1><a href="/">Centauri's Diary</a></h1>
			</div>
			<?php render("nav") ?>
			<div id="content">
				<?php render("toc") ?>
				<?php render("content") ?>
			</div>
			<ul class="nav">
				<li><a href="/about.html">About</a></li>
			</ul>
		</div>
	</body>
</html>
