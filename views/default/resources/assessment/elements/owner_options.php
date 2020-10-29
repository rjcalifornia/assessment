<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$entity = $vars['entity'];

$owner = $vars['owner'];
$questions = $vars['questions'];
$siteUrl = $vars['site_url'];
$questionsAdded = $vars['questions_added'];
$assessment = get_entity($entity);

$add_url = "{$siteUrl}assessment/add_question/{$assessment->guid}";

if($owner->guid == elgg_get_logged_in_user_guid())
{
$label= elgg_echo('assessment:add_question');



?>
<div class="col-md-12" style="padding:15px;">
<h2 class="assessment-questions"> 
              
    <?php
        echo elgg_echo('assessment:questions_options');
        
    ?>
     
</h2>
    
    <h4 class="assessment-quantity-added"> 
              
    <?php
        echo elgg_echo('assessment:questions:added'); 
        echo $questionsAdded;
    ?>
        
     
</h4>
    
     <p class="assessment-alert"> 
              
    <?php
        echo elgg_echo('assessment:questions:alert'); 
        
    ?>
        
     
</p>


<?php
//echo $questionsAdded;
echo elgg_list_entities($questions);
    

?>
</div>

<?php


echo  <<<HTML
    <a href="$add_url" class="elgg-menu-content elgg-button elgg-button-action extras-reading">
              <span class="fa fa-arrow-circle-down"></span> 
              $label
          </a>

HTML;

}