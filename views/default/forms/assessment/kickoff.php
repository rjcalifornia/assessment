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

$loggedUser = elgg_get_logged_in_user_guid();
$userResponse = getUserResponse($loggedUser, $assessment->guid);

if($userResponse != null || $assessment->status == 'closed')
{
    register_error(elgg_echo('actionunauthorized'));
    forward($assessment->getURL());
}

$containerInput = elgg_view(
        'input/hidden',array(
		'name' => 'container_guid',
		'value' => $guid,)
	
        );

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
        'id' => 'save',
       
	'name' => 'save',
));

$action_buttons = $save_button . $delete_link;

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
   
   $questionContainer = elgg_view(
        'input/hidden',array(
		'name' => 'radio-'.$q->guid.'[]',
		'value' => $q->guid,)
	
        );
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
              <input type="radio" name="response[$q->guid]" value="$c->title" required/>$c->title

              
   </br>
        </div>
        
___HTML;
}
echo <<<___HTML
$questionContainer
</div>
___HTML;
}
   
echo <<<___HTML

$containerInput

___HTML;

    

$footer = <<<___HTML

$action_buttons
___HTML;

elgg_set_form_footer($footer);

