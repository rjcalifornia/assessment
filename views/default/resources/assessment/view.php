<?php

$guid = elgg_extract('guid', $vars);

elgg_register_rss_link();

elgg_entity_gatekeeper($guid, 'object', 'assessment');

$assessment = get_entity($guid);
elgg_extend_view('page/elements/head', 'assessment/datatable');
elgg_require_js("assessment/datatable");

$container = $assessment->getContainerEntity();

elgg_set_page_owner_guid($container->getGUID());

elgg_group_gatekeeper();

if ($container instanceof ElggGroup) {
	$owner_url = "assessment/group/$container->guid";
} else {
	$owner_url = "assessment/owner/$container->guid";
}

elgg_push_breadcrumb($container->getDisplayName(), $owner_url);
elgg_push_breadcrumb($assessment->title);

$title = $assessment->title;

$content = elgg_view_entity($assessment, array('full_view' => true));


if ($assessment->status == 'closed') {
	$content .= elgg_view('assessment/closed');
}

$body = elgg_view_resource('assessment/elements/landing', array('entity'=>$assessment));


echo elgg_view_page($title, $body);
