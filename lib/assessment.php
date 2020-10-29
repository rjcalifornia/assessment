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

function getAmountQuestions($allQuestions){
    $questions = elgg_get_entities($allQuestions);
    $counter = 0;
    foreach ($questions as $q)
    {
        $counter++;
    }
    return intval($counter);
}

function getUserScore($assessmentGuid, $allQuestions, $loggedUser){
  $userAnswers =   getUserResponse($loggedUser, $assessmentGuid);
  
  $correctAnswers = getCorrectAnswers($allQuestions);
  
  $assessment = get_entity($assessmentGuid);
  
  $userScore = null;
  
  foreach ($userAnswers as $v) {
      
  
  $userScore = calculateAssessmentResult($v->description, $correctAnswers, $assessment);
  
  }
  
  return $userScore;
    
}

function getCorrectAnswers($questions){
    $questionList = elgg_get_entities($questions);
    $testArray = array();
    
    foreach ($questionList as $t) {
    $questionOptions = array(
'type' => 'object',
'subtype' => 'options',
'container_guid' => $t->guid,
'order_by' => 'e.last_action desc',
//'limit' => max(20, elgg_get_config('default_limit')),
'full_view' => false,
//'no_results' => elgg_echo('questions:none'),
'preload_owners' => true,
'preload_containers' => true,
);
    $answers= elgg_get_entities($questionOptions);
    
    foreach ($answers as $a) {
        if($a->correct_answer == 1)
        {
        $testArray[$t->guid] = $a->title;
        }
        }
    }
 
    
    return $testArray;
    
}


function calculateAssessmentResult($v, $correctAnswers, $assessment){
    
    $user_responses = unserialize($v);
    //var_dump($user_responses);
     //var_dump($correctAnswers);
    //echo "</br>";
    //echo "</br>";
    
    $answersComparison = array_intersect_assoc($correctAnswers, $user_responses);
   // print_r($result4);  
    $score = sizeof($answersComparison);
    
    $totalQuestions = sizeof($correctAnswers);
    //echo $size;
    //echo "</br>";
    $asssessmentResult = ($score / $totalQuestions) * 10;
    
    return round($asssessmentResult, 2);
    
}

function getAllQuestions($assessmentGuid){
    $allQuestions = array(
'type' => 'object',
'subtype' => 'questions',
'container_guid' => $assessmentGuid,
'order_by' => 'e.last_action desc',
'limit' => 0,
'full_view' => false,
'no_results' => elgg_echo('questions:none'),
'preload_owners' => true,
'preload_containers' => true,
);
    
    return $allQuestions;
}

function getAllAssessmentResponses($assessmentGuid){
    
$getResponses = array(
'type' => 'object',
'subtype' => 'assessment_results',
'container_guid' => $assessmentGuid,
'order_by' => 'e.last_action desc',
'limit' => 0,
'full_view' => false,
'no_results' => elgg_echo('questions:none'),
'preload_owners' => true,
'preload_containers' => true,
);
return $getResponses;
}

function getUserResponse($loggedUser, $assessmentGuid){
  $getUserResponse = array(
'type' => 'object',
'subtype' => 'assessment_results',
'container_guid' => $assessmentGuid,
'owner_guid' => $loggedUser,
'order_by' => 'e.last_action desc',
'limit' => 0,
'full_view' => false,
'no_results' => elgg_echo('questions:none'),
'preload_owners' => true,
'preload_containers' => true,
);
  
  $getResponses = elgg_get_entities($getUserResponse);
return $getResponses;  
}


function checkUserAttempts($assessmentGuid, $loggedUser){
       
$getUserAttempt = array(
'type' => 'object',
'subtype' => 'assessment_attempt',
'container_guid' => $assessmentGuid,
'owner_guid' => $loggedUser,
'order_by' => 'e.last_action desc',
'limit' => 0,
'full_view' => false,
'no_results' => elgg_echo('questions:none'),
'preload_owners' => true,
'preload_containers' => true,
);
  
  $attempts = elgg_get_entities($getUserAttempt);
return $attempts;  
}