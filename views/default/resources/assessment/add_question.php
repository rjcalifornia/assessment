<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

elgg_gatekeeper();


$guid = elgg_extract('guid', $vars);

$assessment = get_entity($guid);
$user = elgg_get_logged_in_user_entity();

elgg_entity_gatekeeper($guid);
elgg_group_gatekeeper(true, $guid);
elgg_require_js("assessment/generate_field");
$container = get_entity($guid);

// Make sure user has permissions to add a topic to container
if (!$container->canWriteToContainer(0, 'object', 'assessment')) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$title = elgg_echo('assessment:add:questions');

elgg_push_breadcrumb($container->getDisplayName(), "assessment/view/{$container->guid}");
elgg_push_breadcrumb($title);
 
$content = elgg_view_form('assessment/questions/save', array(), $vars);

 


$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('assessment/sidebar/edit'),
	'filter' => '',
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);


