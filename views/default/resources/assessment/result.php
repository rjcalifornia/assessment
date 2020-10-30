<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

elgg_gatekeeper();


$guid = elgg_extract('guid', $vars);
$getUser = get_input('user_guid');

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

//elgg_push_breadcrumb($assessment);
elgg_push_breadcrumb($assessment->title);

 

$body = elgg_view_resource('assessment/elements/user_individual_result', array('entity'=>$assessment, 'user_guid'=>$getUser));

echo elgg_view_page($assessment->title, $body);