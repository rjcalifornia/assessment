<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$responses = $vars['responses'];
$correctAnswers = $vars['correct_answers'];
$entity = $vars['entity'];
$assessment = get_entity($entity);
$i = 0;
$siteUrl = elgg_get_site_url();


?>


<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Score</th>
                <th>Options</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($responses as $v) {
                    $i++;
                $owner = get_entity($v->owner_guid);
                $userResult = calculateAssessmentResult($v->description, $correctAnswers, $assessment);
                $view_result_url = "{$siteUrl}assessment/result/{$assessment->guid}?user_guid={$v->owner_guid}";
            ?>
            <tr>
                <td>
                    <?php echo $i;?>
                </td>
                <td>
                    <?php echo $owner->name;?>
                </td>
                <td><?php echo $userResult;
               // echo $v->description;
                ?></td>
                <td>
                    <a href="<?php echo $view_result_url;?>">
                    View responses (Coming soon...)
                    </a>
                </td>
                 
            </tr>
                <?php }?>
        </tbody>
        
</table>
