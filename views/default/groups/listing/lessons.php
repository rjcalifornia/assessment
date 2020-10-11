<?php

/**
 * Rendered on /groups/all?filter=discussion
 * Displays a list of discussions created within groups
 */

$container = 'group';
$content = show_all_site_assessments($container);
/*echo elgg_view('lessons/listing/all', [
	'container_type' => 'group',
]);*/

echo $content;