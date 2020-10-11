<?php

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('assessment'));

$content = elgg_view('assessment/listing/all');

$title = elgg_echo('assessment:latest');

$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('assessment/sidebar'),
	'filter' => '',
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);