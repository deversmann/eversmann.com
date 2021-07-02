<?php
// ** USER CONFIGURATION BELOW **
	$blog_title = "My Weblog";
	$blog_description = "Just another blog.";
	$blog_language = "en";
	$file_extension = ".txt";
	$depth_max = 0;
	$date_format = "D, M j, Y";
	$time_format = "g:i A T";
	$data_dir = "";
	$url = "";
	$template_path = "templates";
	date_default_timezone_set('America/Los_Angeles');
// ** USER CONFIGURATION ABOVE - DO NOT EDIT ANYTHING BELOW THIS POINT **

	class Blog {
		public $title;
		public $description;
		public $language;
		public $date_format;
		public $time_format;
		public $url;
		public $path;
		public $file_extension;
		public $year_filter;
		public $month_filter;
		public $date_filter;
	}
	
	class Entry {
		public $title;
		public $lines;
		public $path;
		public $fn;
		public $date;
	}

	$blog_info = new Blog();
	$blog_info->title = $blog_title;
	$blog_info->description = $blog_description;
	$blog_info->language = $blog_language;
	$blog_info->date_format = $date_format;
	$blog_info->time_format = $time_format;
	$blog_info->file_extension = $file_extension;
	$blog_info->url = $url;
	if (!$blog_info->url) $blog_info->url = $_SERVER['SCRIPT_NAME'];
	if (!$data_dir) $data_dir = getcwd();
	$path_info = $_SERVER['PATH_INFO'];
	$date_info = array();
	preg_match_all('|/([\d]+)|',$path_info, $date_info, PREG_PATTERN_ORDER);
	$date_info = $date_info[1];
	$blog_info->year_filter = $date_info[0];
	$blog_info->month_filter = $date_info[1];
	$blog_info->day_filter = $date_info[2];
	
	$cat_info = array();
	preg_match_all('|/\D[^/]*|',$path_info, $cat_info);
	$cat_info = $cat_info[0];
	$template = end($cat_info);
	if (strpos($template, "index.")==1 && strlen($template) > 7) {
		$template=substr($template, 7);
		array_pop($cat_info);
	}
	else {
		$template="html";
	}
	$blog_info->path = implode('',$cat_info);
	$file_path = $data_dir . $blog_info->path;
	if (!$blog_info->path) $blog_info->path='/';
	$files = array();
	traverseDir($file_path, $files, max(1,count($cat_info)));
	krsort($files);
	
	generate_head();
	$current_date = date("Y m d", 0);
	foreach ($files as $date => $filename) {
		if (!$year_filter || $year_filter == date(Y,$date)) {
			if (!$month_filter || $month_filter == date(m,$date)) {
				if (!$day_filter || $day_filter == date(d,$date)) {
					if (strcmp($current_date, date("Y m d", $date))) {
						if (strcmp($current_date, date("Y m d", 0))) {
							generate_date_footer($date);
						}
						$current_date = date("Y m d", $date);
						generate_date_header($date);
					}
					generate_entry($filename, $date);
				}
			}
		}
	}
	generate_foot();

	function generate_entry($filename, $date) {
		global $blog_info,$template_path,$template,$data_dir;
		$entry_info = new Entry();
		$entry_info->fn = substr($filename, (strrpos($filename, "/"))+1, -(strlen($blog_info->file_extension)));
		$entry_info->path = substr($filename, strlen($data_dir), -(strlen($entry_info->fn) + strlen($blog_info->file_extension) + 1));
		if (!$entry_info->path) $entry_info->path = '/';
		$entry_info->lines = file($filename);
		$entry_info->title = trim(array_shift($entry_info->lines));
		$entry_info->date = $date;

		$entry_template = "$template_path/entry.$template";
		if (is_file($entry_template)) {
			include($entry_template);
		}
		else if ($template === "html") {
			echo "<h3>$entry_info->title</h3><a name='$entry_info->fn'/>\n";
			foreach ($entry_info->lines as $line) {
				if (trim($line)) echo "<p>".trim($line)."</p>\n";
			}
			echo "<h5>Posted at ".date($blog_info->time_format, $entry_info->date)." in <a href='$blog_info->url$entry_info->path'>$entry_info->path</a> ";
			echo "| <a href='$blog_info->url/".date(Y,$entry_info->date)."/".date(m,$entry_info->date)."/".date(d,$entry_info->date)."#$entry_info->fn'>Permalink</a></h5>\n";
		}
		else if ($template === "rss") {
			echo "<item>\n<title>$entry_info->title</title>\n";
			echo "<link>$blog_info->url./".date(Y,$entry_info->date)."/".date(m,$entry_info->date)."/".date(d,$entry_info->date)."#$entry_info->fn ?></link>\n";
			echo "<description>\n";
			foreach ($entry_info->lines as $line) {
				if (trim($line)) echo "<p>".trim($line)."</p>\n";
			}
			echo "</description>\n";
			echo "<pubDate>".date('r', $entry_info->date)."</pubDate>\n";
			echo "<guid>$blog_info->url./".date(Y,$entry_info->date)."/".date(m,$entry_info->date)."/".date(d,$entry_info->date)."#$entry_info->fn ?></guid>\n";
			echo "</item>\n";
		}
	}

	function generate_head() {
		global $blog_info,$template_path,$template;
		$head_template = "$template_path/head.$template";
		if (is_file($head_template)) {
			include($head_template);
		}
		else if ($template === "html") {
			echo "<html>\n<head>\n<title>$blog_info->title</title>\n";
			echo "<link href='$blog_info->url/index.rss' rel='alternate' type='application/rss+xml' title='RSS Feed' />\n</head>\n";
			echo "<body>\n<h1>$blog_info->title</h1>\n<h2>$blog_info->description</h2>\n";
		}
		else if ($template === "rss") {
			echo "<?xml version='1.0'?>\n";
			echo "<rss version='2.0'>\n<channel>\n";
			echo "<title>$blog_info->title</title>\n<link>$blog_info->url</link>\n";
			echo "<description>$blog_info->description</description>\n<language>$blog_info->language</language>\n";
		}
	}

	function generate_foot() {
		global $blog_info,$template_path,$template;
		$foot_template = "$template_path/foot.$template";
		if (is_file($foot_template)) {
			include($foot_template);
		}
		else if ($template === "html") {
			echo "<h4>Powered by TextFileBlog</h4>\n</body>\n</html>\n";
		}
		else if ($template === "rss") {
			echo "</channel>\n</rss>\n";
		}
	}

	function generate_date_header($date) {
		global $blog_info,$template_path,$template;
		$date_header_template = "$template_path/date_header.$template";
		if (is_file($date_header_template)) {
			include($date_header_template);
		}
		else if ($template === "html") {
			echo "<h3>".date($blog_info->date_format,$date)."</h3>\n";
		}
	}

	function generate_date_footer($date) {
		global $blog_info,$template_path,$template;
		$date_footer_template = "$template_path/date_footer.$template";
		if (is_file($date_footer_template)) {
			include($date_footer_template);
		}
		else if ($template === "html") {
			echo "<hr />\n";
		}
	}

	function traverseDir ($dir, &$fileArr, $currDepth=1) {
		global $file_extension, $depth_max;
		if ($depth_max == 0 || $currDepth <= $depth_max) {
			foreach(scandir($dir) as $afile) {
				if (is_dir($dir . "/" .$afile)) {
					if ($afile != "." && $afile != "..") {
						traverseDir($dir . "/" . $afile, $fileArr, $currDepth + 1);
					}
				}
				else if (substr( $afile, strlen( $afile ) - strlen( $file_extension ) ) === $file_extension) {
					$fileArr[filemtime($dir . "/" . $afile)] = $dir . "/" . $afile;
				}
			}
		}
	}
?>