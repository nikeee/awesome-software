<?php
// #!/usr/bin/php

$file = "software.json";
$destFile = "README.md";

$data = json_decode(file_get_contents($file));

$md = "# List of Software\n";

// content list
$md .= "## Contents\n";

foreach ($data as $category => $values)
{
	$href = '#' . str_replace(' ', '-', strtolower($category));
	$md .= "[$category]($href)\n";
}

$md .= "To edit this file, you have to edit the `software.json`. If you commit, this file gets automatically generated. You need PHP (:/).\n";
$md .= "Now let's come top the good stuff.\n";

// actual content
foreach ($data as $category => $values)
{
	$md .= "\n";
	$md .= "### $category\n";
	foreach ($values as $software => $url)
	{
		$entry = "";
		if($url === null)
		{
			$entry .= "- $software";
		}
		else
		{
			$entry .= "- [$software]($url)";
		}
		$md .= "$entry\n";
	}
}

// $md .= "\n";

file_put_contents($destFile, $md);
