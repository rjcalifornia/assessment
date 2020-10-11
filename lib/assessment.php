<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function assessment_list($container_guid = NULL) {

	$return = array();

	$return['filter_context'] = $container_guid ? 'mine' : 'all';

	$options = array(
		'type' => 'object',
		'subtype' => 'assessment',
		'full_view' => false,
		'no_results' => elgg_echo('assessment:none'),
		'preload_owners' => true,
		'distinct' => false,
	);

	$current_user = elgg_get_logged_in_user_entity();

	if ($container_guid) {
		// access check for closed groups
		elgg_group_gatekeeper();

		$container = get_entity($container_guid);
		if ($container instanceof ElggGroup) {
		$options['container_guid'] = $container_guid;
		} else {
			$options['owner_guid'] = $container_guid;
		}
		$return['title'] = elgg_echo('assessment:title:user_assessment', array($container->name));

		$crumbs_title = $container->name;
		elgg_push_breadcrumb($crumbs_title);

		if ($current_user && ($container_guid == $current_user->guid)) {
			$return['filter_context'] = 'mine';
		} else if (elgg_instanceof($container, 'group')) {
			$return['filter'] = false;
		} else {
			// do not show button or select a tab when viewing someone else's posts
			$return['filter_context'] = 'none';
		}
	} else {
		$options['preload_containers'] = true;
		$return['filter_context'] = 'all';
		$return['title'] = elgg_echo('assessment:title:all_assessments');
		elgg_pop_breadcrumb();
		elgg_push_breadcrumb(elgg_echo('assessment:assessments'));
	}

	elgg_register_title_button('assessment', 'add', 'object', 'assessment');

	$return['content'] = elgg_list_entities($options);

	return $return;
}

function show_all_site_assessments($container_type){
    $options = array(
	'type' => 'object',
	'subtype' => 'assessment',
	'order_by' => 'e.last_action desc',
	'limit' => max(20, elgg_get_config('default_limit')),
	'full_view' => false,
	'no_results' => elgg_echo('assessment:none'),
	'preload_owners' => true,
	'preload_containers' => true,
);

//$container_type = elgg_extract('container_type', $vars);
if ($container_type) {
	$dbprefix = elgg_get_config('dbprefix');
	$container_type = sanitize_string($container_type);
	$options['joins'][] = "JOIN {$dbprefix}entities ce ON ce.guid = e.container_guid";
	$options['wheres'][] = "ce.type = '$container_type'";
}

return elgg_list_entities($options);
}