<?php
/**
 * Latest forum posts
 *
 * @uses $vars['entity']
 */

if ($vars['entity']->assessment_enable == 'no') {
	return true;
}

$group = $vars['entity'];

$page_owner = $group->owner_guid;


$all_link = elgg_view('output/url', array(
	'href' => "assessment/owner/$group->guid",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'assessment',
	'container_guid' => $group->getGUID(),
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
	'no_results' => elgg_echo('assessment:none'),
);
$content = elgg_list_entities($options);
elgg_pop_context();
if($page_owner == elgg_get_logged_in_user_entity()->guid)
{
$new_link = elgg_view('output/url', array(
	'href' => "assessment/add/" . $group->getGUID(),
	'text' => elgg_echo('assessment:add:assessment'),
	'is_trusted' => true,
));
}



echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('assessment:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));