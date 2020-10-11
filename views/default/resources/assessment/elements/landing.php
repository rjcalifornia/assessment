<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$assessment  = $vars['entity'];

$group_guid = $assessment->container_guid;

$details = get_entity($assessment->guid);

$group = get_entity($group_guid);
$siteUrl = elgg_get_site_url();

$owner = $details->getOwnerEntity();


$add_url = "{$siteUrl}assessment/add_question/{$assessment->guid}";
	$add_link = elgg_view('output/url', array(
		'href' => $add_url,
		'text' => elgg_echo('assessment:add_question'),
		'class' => 'elgg-button elgg-button-delete float-alt',
		//'confirm' => true,
	));
//echo $group->name;
        
        
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

?>
<div class="col-md-12" style="padding-top: 1%">

<img src="<?php echo $siteUrl?>mod/assessment/graphics/assessment_header.png" width="100%"
     style="border-radius: 15px;">    
    
</div>

<div class="col-md-12" style="padding:12px;">



<p>
    <a href="<?php echo $group->getURL();?>"> 
        <h4>
            <span class="fa fa-users"></span> 
                <?php echo $group->name;?>
        </h4>
    </a>
</p>

<h1 class="assessment-title"> 

    <?php
    echo $assessment->title;

    ?>

</h1>

</div>


<div id="tabsDemo6Content" class="assessment-content col-md-12">
    <div style="    display: block;">
            <div class="assessment-meta">
                    <ul>
                            <li>
                                <span>
                                    <?php echo elgg_echo('assessment:minimun_grade')?>
                                </span>
                                <i class="fa fa-certificate"></i>
                                    <?php echo $details->min_grade;?>      
                            </li>

                            <li>
                                <span>
                                    <?php echo elgg_echo('assessment:quantity')?>
                                </span>
                                <i class="fa fa-book"></i>
                                    <?php 
                                    echo $details->question_quantity;
                                    echo ' '. elgg_echo('assessment:questions');
                                    ?>                     
                            </li>
                            
                            <li>
                                <span>
                                    <?php echo elgg_echo('assessment:duration')?>
                                </span>
                                <i class="fa fa-clock-o"></i>
                                    <?php 
                                    echo $details->max_duration;
                                    echo ' '. elgg_echo('assessment:minutes');
                                    ?>
                            </li>
                            
                            <li>
                                 <span>
                                    <?php echo elgg_echo('status')?>
                                </span>
                                <i class="fa fa-folder-open-o"></i>
                                    <b>
                                        <?php echo $details->status;?>
                                    </b>
                            </li>
                    </ul>
            </div>
    <p>


    </p>
    </div>

</div>

<div class="col-md-12" style="padding:15px;">


<h2 class="assessment-description"> 
              
    <?php
        echo elgg_echo('assessment:instructions');
        
    ?>
     
</h2>
     
          
              
    <?php
        echo $assessment->description;
        
    ?>
     

</div>

<?php

if($owner->guid == elgg_get_logged_in_user_guid())
{
$label= elgg_echo('assessment:add_question');



?>
<div class="col-md-12" style="padding:45px;">
<h2 class="assessment-questions"> 
              
    <?php
        echo elgg_echo('assessment:questions_options');
        
    ?>
     
</h2>

<?php

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


/*
$test = array(
'type' => 'object',
'subtype' => 'options',
//'container_guid' => $assessment->guid,
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

?>

