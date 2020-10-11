<?php

/**
 * Discussion topic add/edit form body
 *
 */

$assessment = get_entity($vars['guid']);

$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$guid = $assessment->guid;
$action_buttons = '';
$delete_link = '';
$container_guid = elgg_extract('container_guid', $vars);
//var_dump($container_guid);
if ($vars['guid']) {
	// add a delete button if editing
	$delete_url = "action/assessment/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/url', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete float-alt',
		'confirm' => true,
	));
}


$titleLabel = elgg_echo('assessment:title');
$titleInput = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'assessment_title',
	'value' => $vars['title'],
        'required' => true,
));

$contentLabel = elgg_echo('assessment:instructions');
$contentInput = elgg_view('input/longtext', array(
	'name' => 'description',
	'id' => 'assessment_description',
	'value' => $vars['description'],
        'required' => true,
));

 



$quantityLabel = elgg_echo('assessment:quantity');
$quantityInput = elgg_view('input/text', array(
	'name' => 'quantity',
	'id' => 'assessment_quantity',
	'value' => $vars['quantity'],
        'required' => true,
));

$durationLabel = elgg_echo('assessment:duration');
$durationInput = elgg_view('input/text', array(
	'name' => 'duration',
	'id' => 'assessment_duration',
	'value' => $vars['duration'],
        'required' => true,
));

$gradeLabel = elgg_echo('assessment:minimun_grade');
$gradeInput = elgg_view('input/text', array(
	'name' => 'minimun_grade',
	'id' => 'assessment_minimun_grade',
	'value' => $vars['minimun_grade'],
        'required' => true,
));

 

$statusLabel = elgg_echo('access');
$statusInput = elgg_view('input/select', array(
    'name' => 'status',
    'id' => 'assessment_status',
    'value' => $vars['status'],
    'options_values' => array(
            'open' => elgg_echo('status:open'),
            'closed' => elgg_echo('status:closed'),
		),
)
        );

 
$accessLabel = elgg_echo('access');
$accessInput = elgg_view(
'input/access',array(
		'name' => 'access_id',
		'value' => $access_id,
		'entity' => get_entity($guid),
		'entity_type' => 'object',
		'entity_subtype' => 'lessons',
		'label' => elgg_echo('access'),
));

$containerInput = elgg_view(
        'input/hidden',array(
		'name' => 'container_guid',
		'value' => $container_guid,)
	
        );
$assessment_guid = elgg_view(
        'input/hidden',array(
		'name' => 'assessment_guid',
		'value' => $assessment_guid,)
	
        );


$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
        'id' => 'save',
       
	'name' => 'save',
));

$action_buttons = $save_button . $delete_link;


echo <<<___HTML

   
   
<div>
	<label for="title">$titleLabel</label>
	$titleInput
</div>


<div>
	<label for="content">$contentLabel</label>
	$contentInput
</div>
        
 <div>
	<label for="duration">$quantityLabel</label>
	$quantityInput
</div>
       
<div>
	<label for="duration">$gradeLabel</label>
	$gradeInput
</div>
             
<div>
	<label for="duration">$durationLabel</label>
	$durationInput
</div>
    
<div>
	<label for="access">$statusLabel</label>
	$statusInput
</div>
<div>
	<label for="access">$accessLabel</label>
	$accessInput
</div>
$containerInput
        
___HTML;

$footer = <<<___HTML

$action_buttons
___HTML;

elgg_set_form_footer($footer);