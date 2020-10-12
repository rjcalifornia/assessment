<?php
/**
 * View for questions objects
 *
 * @package Assessment
 */

$full = elgg_extract('full_view', $vars, FALSE);
$questions = elgg_extract('entity', $vars, FALSE);

if (!$questions) {
	return TRUE;
}

$owner = $questions->getOwnerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = $questions->excerpt;
if (!$excerpt) {
	$excerpt = elgg_get_excerpt($questions->description);
}

$owner_icon = elgg_view_entity_icon($owner, 'tiny');

$vars['owner_url'] = "questions/owner/$owner->username";
$by_line = elgg_view('page/elements/by_line', $vars);

// The "on" status changes for comments, so best to check for !Off
 
	$comments_link = '';


$subtitle = "$by_line $comments_link $categories";

$metadata = '';
if (!elgg_in_context('widgets')) {
	// only show entity menu outside of widgets
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'questions',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

if ($full) {

	$body = elgg_view('output/longtext', array(
		'value' => $questions->title,
		'class' => 'questions-post',
	));

	$params = array(
		'entity' => $questions,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
		'entity' => $questions,
		'summary' => $summary,
		'icon' => $owner_icon,
		'body' => $body,
	));

} else {
	// brief view

	$params = array(
		'entity' => $questions,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $excerpt,
		'icon' => $owner_icon,
	);
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);

}
