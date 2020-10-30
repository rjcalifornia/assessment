<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


elgg_gatekeeper();
elgg_require_js("assessment/test");
$guid = elgg_extract('guid', $vars);
$loggedUser = elgg_get_logged_in_user_guid();
elgg_entity_gatekeeper($guid);
elgg_group_gatekeeper(true, $guid);
$token = $_SERVER['HTTP_REFERER'];
//var_dump($token);
elgg_require_js("assessment/max_duration");

$container = get_entity($guid);
//echo $container->getURL();
//echo time();
//echo date(DATE_ATOM, $token);
if ($container instanceof ElggGroup) {
	//$owner_url = "assessment/view/$container->guid";
} else {
	//$owner_url = "assessment/view/$container->guid";
}

if($token != $container->getURL()){
    register_error(elgg_echo('actionunauthorized'));
    forward($container->getURL());
}

/*
if($token == null){
    register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}*/
//$attempts = checkUserAttempts($container->guid, $loggedUser);
/*
if($attempts != null)
{
    register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}*/
$pageRefresh = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
if($pageRefresh){
    register_error(elgg_echo('assessment:page:reload'));
    forward($container->getURL());
    
}
else{
elgg_push_breadcrumb($container->getDisplayName(), $owner_url);
elgg_push_breadcrumb($container->title);

$title = elgg_echo('assessment:in_progress');

$content = elgg_view_form('assessment/kickoff', array(), $vars);

$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('assessment/sidebar/edit'),
	'filter' => '',
);
$body = elgg_view_layout('content', $params);


echo elgg_view_page($title, $body);
}