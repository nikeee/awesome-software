<?php
// #!/usr/bin/php

$file = "software.json";
$destMarkdown = "README.md";
$destHtml = "index.html";
$preCommitFile = "pre-commit.sh";

$data = json_decode(file_get_contents($file));

$title = "List of Software";

$md = "# $title\n";
$html = '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>' . htmlspecialchars($title) . '</title>
	<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/cosmo/bootstrap.min.css">
</head>
<body>
<div class="container">
		<header>
			<h1 class="page-header">' . htmlspecialchars($title). '</h1>
		</header>' . "\n";

// content list
$md .= "## Contents\n";

foreach ($data as $category => $values)
{
	$href = '#' . str_replace(' ', '-', strtolower($category));
	$md .= "- [$category]($href)\n";
}

$rawText = [
	"To edit this file, you have to edit the `software.json`. You need PHP (:/). If you're done, do a `php autogen.php` to generate this file. Then commit.\n"
];

$html .= "<div><p>";
$html .= nl2br(htmlspecialchars($rawText[0]));
$html .= "</p></div>";

$md .= "\n";
$md .= $rawText[0];
$md .= "You might also put this in your pre-commit:\n";
$md .= "```bash\n";
$md .= file_get_contents($preCommitFile);
$md .= "```\n";
$md .= "Now let's come top the good stuff.\n";

function getMdLine($software, $url)
{
	if($url === null)
		return "- $software\n";
	return "- [$software]($url)\n";
}
function getHtmlLine($software, $url)
{
	if($url === null)
		return '<span class="list-group-item">' . htmlspecialchars($software) . "</span>\n";
	return '<a class="list-group-item" href="' . htmlspecialchars($url) . '">' . htmlspecialchars($software) . "</a>\n";
}


// actual content
foreach ($data as $category => $values)
{
	$md .= "\n";
	$md .= "### $category\n";
	$html .= '<article class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">' . htmlspecialchars($category) . '</h3></div><div class="list-group">';
	foreach ($values as $software => $url)
	{
		$md .= getMdLine($software, $url);
		$html .= getHtmlLine($software, $url);
	}
	$html .= "</div></article>\n";
}

$html .= "</div></body></html>\n";

// $md .= "\n";

file_put_contents($destMarkdown, $md);
file_put_contents($destHtml, $html);
