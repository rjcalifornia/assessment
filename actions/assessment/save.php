<?php
/**
 * Topic save action
 */

// Get variables
$title = htmlspecialchars(get_input('title', '', false), ENT_QUOTES, 'UTF-8');

$desc = get_input("description");
$quantity = get_input("quantity");
$duration = get_input("duration");
$grade = get_input("minimun_grade");
 


$status = get_input("status");
$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid');
$guid = (int) get_input('assessment_guid');
$tags = get_input("tags");

elgg_make_sticky_form('assessment');

// validation of inputs
if (!$title || !$desc) {
	register_error(elgg_echo('assessment:error:missing'));
	forward(REFERER);
}

$container = get_entity($container_guid);


// check whether this is a new topic or an edit
$new_assessment = true;
if ($guid > 0) {
	$new_assessment = false;
}

if ($new_assessment) {
	$assessment = new ElggAssessment();
	$assessment->subtype = 'assessment';
} else {
	// load original file object
	$assessment = get_entity($guid);
	if (!elgg_instanceof($assessment, 'object', 'assessment') || !$assessment->canEdit()) {
		register_error(elgg_echo('assessment:notfound'));
		forward(REFERER);
	}
}

$assessment->title = $title;
$assessment->description = $desc;
$assessment->max_duration = $duration;
$assessment->min_grade = $grade;
$assessment->question_quantity = $quantity;
$assessment->owner_guid = elgg_get_logged_in_user_guid();
$assessment->container_guid = (int)get_input('container_guid');

 
 


$assessment->status = $status;
$assessment->access_id = $access_id;
//$topic->container_guid = $container_guid;

$assessment->tags = string_to_tag_array($tags);

$result = $assessment->save();

if (!$result) {
	register_error(elgg_echo('assessment:error:notsaved'));
	forward(REFERER);
}

// topic saved so clear sticky form
elgg_clear_sticky_form('assessment');


// handle results differently for new topics and topic edits
if ($new_assessment) {
	system_message(elgg_echo('assessment:created'));

	elgg_create_river_item(array(
		'view' => 'river/object/assessment/create',
		'action_type' => 'create',
		'subject_guid' => elgg_get_logged_in_user_guid(),
		'object_guid' => $assessment->guid,
		'target_guid' => $container_guid,
	));
} else {
	system_message(elgg_echo('assessment:updated'));
}

forward($assessment->getURL());
