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
                <td>View responses (Coming soon...)</td>
                 
            </tr>
                <?php }?>
        </tbody>
        
</table>
