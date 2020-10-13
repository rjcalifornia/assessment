<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


elgg_gatekeeper();

$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid);
elgg_group_gatekeeper(true, $guid);

$container = get_entity($guid);

if ($container instanceof ElggGroup) {
	$owner_url = "assessment/view/$container->guid";
} else {
	$owner_url = "assessment/view/$container->guid";
}
elgg_push_breadcrumb($container->getDisplayName(), $owner_url);
elgg_push_breadcrumb($container->title);

$title = elgg_echo('assessment:in_progress');

$content = elgg_view_form('assessment/kickoff', array(), $vars);

$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('assessment/sidebar/edit'),
	'filter' => '',
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);