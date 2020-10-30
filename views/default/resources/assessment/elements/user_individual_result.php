<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$assessment = $vars['entity'];
$getUser = $vars['user_guid'];

$userGuid = get_entity($getUser);

$group = get_entity($assessment->container_guid);

$userResponse = getUserResponse($userGuid->guid, $assessment->guid);

echo elgg_view('assessment/formcss');
elgg_gatekeeper();

$allQuestions = getAllQuestions($assessment->guid);

$loggedUserResult =getUserScore($assessment->guid, $allQuestions, $userGuid->guid);

?>
 
    
    <div class="panel-body">
    <p>
      
    <a href="<?php echo $assessment->getURL();?>"> 
          
        <h4><span class="btn btn-info btn-round info">
            <span class="fa fa-arrow-circle-o-left"></span> 
                 return to assessment
                </span>
        </h4>
              
    </a>
        
</p>
<div class="tabs-wrapper text-center">
    <div class="col-md-12 tab-content">

              <div role="tabpanel" class="tab-pane fade active in" id="tabs-area-demo" aria-labelledby="tabs1">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="col-md-12 tabs-area">
                      <div class="liner"></div>
                      <ul class="nav nav-tabs nav-tabs-v5" id="tabs-demo6"></ul>
                <div class="tab-content tab-content-v5">
                  <div class="tab-pane fade in active" id="tabs-demo6-area3">
                     
                      <center>
                          <img class="img-circle-result avatar-result" src="<?php echo $userGuid->getIconURL('medium');?>" 
                          </center>
                      <div class="spacing-image"></div>
                    <h3 class="head text-center"><?php echo $userGuid->name;?> responses</h3>
                    <p class="narrow text-center">
                      <?php 
                     // echo $group->briefdescription;
                        
                      ?>
                    </p>

                    <p class="text-center">
                        <span class="btn btn-success btn-round green">
                        
                          <span style="margin-left:10px;" class="fa fa-book"></span> <?php echo $assessment->title; ?></span>
                    </p>
                    
                    <div style="padding: 15px;">
               
                <h2><?php echo elgg_echo('assessment:individual:score');?></2>
                 <?php echo $loggedUserResult; ?>
        </div>
                  </div>
                  
                  <div class="clearfix"></div>
                </div>
                     
              </div>
            </div>      
              </div>
               
                  <?php
                  
    foreach ($userResponse as $a) {
    
    $responses = unserialize($a->description);
    
        foreach ($responses as $key => $value) {
                $i++;
                    $question = get_entity($key);
                    ?>
                      <div class="col-md-12 padding-0 box-v7-comment">
                         <h3> Question <?php echo $i;?></h3>
                         <div class="question-division"></div>
                          <b>
                              <?php echo $question->title; ?>
                          </b>
                          </br>
                          <div class="col-sm-12 padding-0">
                              <span class="btn btn-dark btn-round dark">    User response: <b><?php echo $value; ?></b></span>
                          </div>
                      </div>
                <?php

                  }

            }
            
            ?>
                 
                 
                </div>
                
                
              </div>
</div>
        </div>