<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$container_guid = (int) get_input('container_guid');

$responses = get_input("response");


$assessment = get_entity($container_guid);

if (empty($responses)) {
	register_error(elgg_echo("assessment:noresponse"));
	forward(REFERER);
}
$user = elgg_get_logged_in_user_entity();

$result = new ElggObject();
$result->subtype = 'assessment_results';
$result->access_id = ACCESS_PUBLIC;
$result->container_guid = $assessment->guid;
$result->title = $assessment->title;
$result->description = serialize($responses);
$result->owner_guid = $user->guid;
$result->save();
        
/*
foreach ($responses as $question_guid => $response) {
    $question = get_entity($question_guid);
    
    
    if (is_array($response)) {
			foreach($response as $response_item) {
				 $question->annotate("response", $response_item, $assessment->access_id);
			}
		} else {
			 $question->annotate("response", $response_item, $assessment->access_id);
		}
    
}*/

system_message(elgg_echo($container_guid));
//echo $container_guid;