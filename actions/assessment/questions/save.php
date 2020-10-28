<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$title = get_input("title");
$container_guid = (int) get_input('container_guid');
$answers = get_input("mytext");

$assessment = get_entity($container_guid);

if (!$title /*|| !$options*/) {
	register_error(elgg_echo('question:error:missing'));
	forward(REFERER);
}


$new_question = true;
if ($guid > 0) {
	$new_question = false;
}

if ($new_question) {
	$question = new ElggQuestions();
	$question->subtype = 'questions';
} else {
	// load original file object
	$question = get_entity($guid);
	if (!elgg_instanceof($question, 'object', 'questions') || !$assessment->canEdit()) {
		register_error(elgg_echo('question:notfound'));
		forward(REFERER);
	}
}

$question->title = $title;
$question->owner_guid = elgg_get_logged_in_user_guid();
$question->container_guid = (int)get_input('container_guid');
$question->access_id = $assessment->access_id;
$result = $question->save();

if($answers != null)
{
    $datos = sizeof($answers);
}




$i = 0;
foreach ($answers as $key => $val) {
    if($datos>$i)
    {
    $options = new ElggOptions();
    
    if($answers[$i] == '1'){
    $options->correct_answer = true;
    }
    else{
        $options->correct_answer = false;
    }
    $i++;
    $options->title = $answers[$i];
    
    $options->container_guid = $question->guid;
    $options->access_id = $assessment->access_id;
    $options->save();
    $i++;
    }
    
}
system_message(elgg_echo('question:added'));
forward($assessment->getURL());