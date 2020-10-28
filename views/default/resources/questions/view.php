<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

elgg_gatekeeper();

$current_user = elgg_get_logged_in_user_entity();



$guid = elgg_extract('guid', $vars);

elgg_register_rss_link();

elgg_entity_gatekeeper($guid, 'object', 'questions');

$question = get_entity($guid);

if (!$question->canWriteToContainer(0, 'object', 'assessment')) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}


$container = $question->getContainerEntity();

if ($container instanceof ElggGroup) {
	$owner_url = "assessment/view/$container->guid";
} else {
	$owner_url = "assessment/view/$container->guid";
}
elgg_push_breadcrumb($container->getDisplayName(), $owner_url);
elgg_push_breadcrumb($container->title);

elgg_set_page_owner_guid($container->getGUID());

elgg_group_gatekeeper();

$title = elgg_echo('assessment:question:single');

$content = elgg_view_entity($question, array('full_view' => true));

$optionsLabel = elgg_echo('assessment:choices');
$content .=<<<HTML
    <div class="col-md-12" style="padding:10px;">
        
    <h3>$optionsLabel</h3>
    </div>
HTML;



$options = array(
'type' => 'object',
'subtype' => 'options',
'container_guid' => $question->guid,
'order_by' => 'e.last_action desc',
'limit' => max(20, elgg_get_config('default_limit')),
'full_view' => false,
'no_results' => elgg_echo('questions:none'),
'preload_owners' => true,
'preload_containers' => true,
);
$answers= elgg_get_entities($options);
$correctAnswer = null;
$correctLabel = elgg_echo('single:correct:answer');
foreach ($answers as $a) {
  $content.=  <<<HTML
    <div class="col-md-12" style="padding-left:25px; padding-top: 10px;">
        
   <span class="fa fa-angle-double-right"></span> <b>$a->title</b>
    </div>
HTML;
  //$content .=  $a->title;
  if($a->correct_answer == 1)
  {
      $correctAnswer = $a->title;
  }
    //$content .=  $a->correct_answer;
  //$content .= '</br>';  
    
   // echo '</br>';
    
}

  $content.=  <<<HTML
    <div class="col-md-12" style="padding:20px;">
        
   <h3>  $correctLabel:</h3> 
       <p><span class="fa fa-check"></span> <b>$correctAnswer</b></p>
    </div>
HTML;

//$content .= $test;
$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('assessment/sidebar'),
	'filter' => '',
);


$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
/*$questions = get_entity($guid);

var_dump($questions);

$test = array(
'type' => 'object',
'subtype' => 'options',
'container_guid' => $questions->guid,
'order_by' => 'e.last_action desc',
'limit' => max(20, elgg_get_config('default_limit')),
'full_view' => false,
'no_results' => elgg_echo('questions:none'),
'preload_owners' => true,
'preload_containers' => true,
);

$newtest= elgg_get_entities($test);

foreach ($newtest as $value) {
    
    echo $value->title;
    echo $value->correct_answer;
    
    echo '</br>';
    
}*/