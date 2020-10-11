<?php

elgg_gatekeeper();

$guid = elgg_extract('guid', $vars);

elgg_extend_view('page/elements/head', 'assessment/input_mask');

elgg_require_js("assessment/input_validation");
elgg_entity_gatekeeper($guid);
elgg_group_gatekeeper(true, $guid);

$container = get_entity($guid);

// Make sure user has permissions to add a topic to container
if (!$container->canWriteToContainer(0, 'object', 'assessment')) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$title = elgg_echo('assessment:add:assessment');

elgg_push_breadcrumb($container->getDisplayName(), "assessment/owner/{$container->guid}");
elgg_push_breadcrumb($title);
//$form_vars = array('enctype' => 'multipart/form-data');
$body_vars = assessment_prepare_form_vars();
$content = elgg_view_form('assessment/save', array(), $body_vars);

$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('assessment/sidebar/edit'),
	'filter' => '',
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);