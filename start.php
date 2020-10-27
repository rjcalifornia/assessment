<?php

// register an initializer
elgg_register_event_handler('init', 'system', 'assessment_init');

function assessment_init() {
    elgg_register_page_handler('assessment', 'assessment_page_handler');
    elgg_register_page_handler('questions', 'questions_page_handler');
    elgg_register_library('elgg:assessment', __DIR__ . '/lib/assessment.php');
    
    elgg_register_plugin_hook_handler('entity:url', 'object', 'assessment_set_url');
    
    elgg_register_plugin_hook_handler('entity:url', 'object', 'questions_set_url');
    
    $action_base = __DIR__ . '/actions/assessment';
    elgg_register_action('assessment/save', "$action_base/save.php");
    elgg_register_action('assessment/kickoff', "$action_base/kickoff.php");
    elgg_register_action('assessment/questions/save', "$action_base/questions/save.php");
    
    add_group_tool_option('assessment', elgg_echo('assessment:enableassessment'), true);
    elgg_extend_view('groups/tool_latest', 'assessment/group_module');
    elgg_extend_view('elgg.css', 'assessment/css');

}


function assessment_page_handler($page) {

	elgg_load_library('elgg:assessment');

	// push all blogs breadcrumb
	elgg_push_breadcrumb(elgg_echo('assessment:assessment'), 'assessment/all');

	$page_type = elgg_extract(0, $page, 'all');
	$resource_vars = [
		'page_type' => $page_type,
	];

	switch ($page_type) {
		case 'owner':
			$resource_vars['username'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('assessment/owner', $resource_vars);
			break;
		case 'friends':
			$resource_vars['username'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('assessment/friends', $resource_vars);
			break;
		case 'archive':
			$resource_vars['username'] = elgg_extract(1, $page);
			$resource_vars['lower'] = elgg_extract(2, $page);
			$resource_vars['upper'] = elgg_extract(3, $page);
			
			echo elgg_view_resource('assessment/archive', $resource_vars);
			break;
		case 'view':
			$resource_vars['guid'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('assessment/view', $resource_vars);
			break;
                    
                case 'preview':
			$resource_vars['guid'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('questions/view', $resource_vars);
			break;
		case 'add':
			$resource_vars['guid'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('assessment/add', $resource_vars);
			break;
		case 'edit':
			$resource_vars['guid'] = elgg_extract(1, $page);
			$resource_vars['revision'] = elgg_extract(2, $page);
			
			echo elgg_view_resource('assessment/edit', $resource_vars);
			break;
		case 'group':
                
			
			echo elgg_view_resource('assessment/group', [
				'guid' => elgg_extract(1, $page),
			]);
			break;
                    
                case 'add_question':
			$resource_vars['guid'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('assessment/add_question', $resource_vars);
			break;
                    
                case 'kickoff':
			$resource_vars['guid'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('assessment/kickoff', $resource_vars);
			break;
                    
		case 'all':
			echo elgg_view_resource('assessment/all', $resource_vars);
			break;
		default:
			return false;
	}

	return true;
}


function questions_page_handler($page) {

	elgg_load_library('elgg:assessment');

	// push all blogs breadcrumb
	//elgg_push_breadcrumb(elgg_echo('assessment:assessment'), 'questions/all');

	$page_type = elgg_extract(0, $page, 'all');
	$resource_vars = [
		'page_type' => $page_type,
	];

	switch ($page_type) {
                
                case 'view':
			$resource_vars['guid'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('questions/view', $resource_vars);
			break;
                
		default:
			return false;
	}

	return true;
}


function assessment_set_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'assessment')) {
		$friendly_title = elgg_get_friendly_title($entity->title);
		return "assessment/view/{$entity->guid}/$friendly_title";
	}
}

function questions_set_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'questions')) {
		$friendly_title = elgg_get_friendly_title($entity->title);
		return "questions/view/{$entity->guid}/$friendly_title";
	}
}

function assessment_prepare_form_vars($assessment = NULL) {
	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'status' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'topic' => $assessment,
	);

	if ($assessment) {
		foreach (array_keys($values) as $field) {
			if (isset($assessment->$field)) {
				$values[$field] = $assessment->$field;
			}
		}
	}

	if (elgg_is_sticky_form('assessment')) {
		$sticky_values = elgg_get_sticky_values('assessment');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('assessment');

	return $values;
}
