<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 $added_institucion = $request->request->get('mytext');
 if($added_institucion != null)
            {
                $datos = sizeof($added_institucion);
            }
 foreach ($added_institucion as $key => $val) {
               
                 if($datos>$i && $added_institucion[$i]!= null)
                 {
                $involucrada = new Institucionesinvolucradas();
                $institucionRepository = $em->getRepository('AppBundle:Institucion');
                $institucion = $institucionRepository->findOneBy(array('id'=>"$added_institucion[$i]"));
                $involucrada->setIdinstitucion($institucion);
                $i++;
                $involucrada->setDescripcion($added_institucion[$i]);
                $i++;
                $involucrada->setIdproyecto($proyecto);
                
                 $em->persist($involucrada);
                $em->flush();
                 }
                 
            }
 * 
 * 
 */

$assessment = get_entity($vars['guid']);

$action_buttons = '';
$delete_link = '';

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
        'id' => 'save',
       
	'name' => 'save',
));
if ($vars['question_guid']) {
	// add a delete button if editing
	$delete_url = "action/questions/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/url', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete float-alt',
		'confirm' => true,
	));
}

//echo $vars['guid'];

$containerInput = elgg_view(
        'input/hidden',array(
		'name' => 'container_guid',
		'value' => $assessment->guid,)
	
        );

$titleLabel = elgg_echo('assessment:question_content');
$titleInput = elgg_view('input/longtext', array(
	'name' => 'title',
	'id' => 'assessment_title',
	'value' => $vars['title'],
        'required' => true,
));

$optionsLabel = elgg_echo('assessment:add_option');

$action_buttons = $save_button . $delete_link;

echo <<<___HTML
<div>
	<label for="title">$titleLabel</label>
	$titleInput
</div>

<div class="container1" >
    
    <div style="padding-bottom: 18px;">
        <select name="mytext[]" value="1" style="float: left; margin-right:12px;">
   <option value="2"> </option>
   <option value="1">Correct answer</option>
   </select>
        <input type="text" name="mytext[]" style="display: inline-block; width: 75%; vertical-align: middle;">
    </div>
</div>
   <div>     
<button class="add_form_field"> &nbsp; 
      <span style="font-size:16px; font-weight:bold;">$optionsLabel + </span>
    </button>    
        </div>
$containerInput
   
___HTML;

$footer = <<<___HTML

$action_buttons
___HTML;

elgg_set_form_footer($footer);