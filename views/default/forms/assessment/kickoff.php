<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$assessment = get_entity($vars['guid']);

echo $assessment->guid;

$guid = $assessment->guid;

$questions = array(
'type' => 'object',
'subtype' => 'questions',
'container_guid' => $assessment->guid,
'order_by' => 'e.last_action desc',
'limit' => max(20, elgg_get_config('default_limit')),
'full_view' => false,
'no_results' => elgg_echo('questions:none'),
'preload_owners' => true,
'preload_containers' => true,
);

$allQuestions = elgg_get_entities($questions);

foreach ($allQuestions as $q) {
    echo '<div style="margin-bottom: 48px;">';
    
    echo '<p>';
    echo $q->title;
    echo '</p>';
    
 $choices =   array(
'type' => 'object',
'subtype' => 'options',
'container_guid' => $q->guid,
'order_by' => 'e.last_action desc',
'limit' => max(20, elgg_get_config('default_limit')),
'full_view' => false,
'no_results' => elgg_echo('questions:none'),
'preload_owners' => true,
'preload_containers' => true,
);
 
 $allChoices = elgg_get_entities($choices);
foreach ($allChoices as $c) {
   echo $c->title;
   echo '</br>';
}
    echo '</div>';
}