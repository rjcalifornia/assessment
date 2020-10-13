<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$assessment = get_entity($vars['guid']);
echo elgg_view('assessment/formcss');
//echo $assessment->guid;
$i = 0;
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

$questionTitle = elgg_echo('assessment:takeoff:question');

$allQuestions = elgg_get_entities($questions);

foreach ($allQuestions as $q) {
   $i++; 
echo <<<___HTML
<div class="col-md-12 padding-0 box-v7-comment">
    <b>$questionTitle $i:</b>
        $q->title
    

___HTML;

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
echo <<<___HTML
    
      <div class="col-sm-12 padding-0">
              <input type="radio" name="radio-$q->guid" value="$c->title"/>$c->title

    
   </br>
        </div>
        
___HTML;
}
echo <<<___HTML
</div>
___HTML;
}
   
echo <<<___HTML

$containerInput

___HTML;

    


