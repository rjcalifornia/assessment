<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
elgg_load_library('elgg:assessment');
$ia = elgg_set_ignore_access(true);
elgg_set_ignore_access(true);
$container_guid =  get_input('container_guid');
$assessment = get_entity($container_guid);

$token = get_input('__elgg_ts');

if (empty($assessment)) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();
$attempts = checkUserAttempts($assessment->guid, $user->guid);

if($attempts != null)
{
    register_error(elgg_echo('actionunauthorized'));
    forward(REFERER);
}
else{
$attempt = new ElggObject();
$attempt->subtype = 'assessment_attempt';
$attempt->access_id = ACCESS_PUBLIC;
$attempt->container_guid = $assessment->guid;
$attempt->title = $assessment->title;
$attempt->owner_guid = $user->guid;
$attempt->description = $user->name;        
$attempt->save();

$siteUrl = elgg_get_site_url();

$url = "{$siteUrl}assessment/kickoff/{$assessment->guid}";

forward($url);
}