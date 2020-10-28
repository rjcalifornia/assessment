<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$entity = $vars['entity'];

$owner = $vars['owner'];

$questionsAdded = $vars['questions_added'];
$assessmentQuestionsQuantity = $vars['assessment_questions_quantity'];
$startUrl = $vars['start_url'];
$allQuestions = $vars['all_questions'];
$loggedUser = $vars['logged_user'];
$loggedUserDetails = $vars['user_details'];
$assessment = get_entity($entity);

if($owner->guid != elgg_get_logged_in_user_guid() && $questionsAdded >= $assessmentQuestionsQuantity && $assessment->status == 'open'){
    $userResponse = getUserResponse($loggedUser, $assessment->guid);
    $finishedLabel = elgg_echo('assessment:status:finished');
    if($userResponse == null)
    {
        
?>
<div style="padding: 25px;">
 <a href="<?php echo $startUrl; ?>" class="elgg-menu-content elgg-button elgg-button-action extras-reading">
   <span class="fa fa-check-circle-o"></span>
       <?php echo elgg_echo('assessment:start'); ?>
   </a>
</div>
<?php

    }
    else{
        //$correctAnswers = getCorrectAnswers($allQuestions);
        $loggedUserResult =getUserScore($assessment->guid, $allQuestions, $loggedUser);
        $resultLabel = elgg_echo('assessment:individual:score');
        
        
        echo  <<<HTML

        <div style="padding: 35px;">
                <h4>$loggedUserDetails->name</4>
                <h2>$resultLabel</2>
                 $loggedUserResult
        </div>
        
        <div style="padding: 25px;">
        <a href="#" class="elgg-menu-content elgg-button elgg-button-action extras-reading">
          <span class="fa fa-ban"></span>
             $finishedLabel
          </a>
       </div>
                
HTML;
    }
}

if($questionsAdded < $assessmentQuestionsQuantity && $owner->guid != elgg_get_logged_in_user_guid()){
    $pendingLabel = elgg_echo('assessment:pending');
   // echo $assessment->status;
        echo  <<<HTML

        <div style="padding: 25px;">
        <a href="#" class="elgg-menu-content elgg-button elgg-button-action extras-reading">
          <span class="fa fa-clock-o"></span>
             $pendingLabel
          </a>
       </div>
HTML;
}

