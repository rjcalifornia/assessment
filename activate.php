<?php
/**
 * Register the ElggBlog class for the object/blog subtype
 */

if (get_subtype_id('object', 'assessment')) {
	update_subtype('object', 'assessment', 'ElggAssessment');
} else {
	add_subtype('object', 'assessment', 'ElggAssessment');
}


if (get_subtype_id('object', 'questions')) {
	update_subtype('object', 'questions', 'ElggQuestions');
} else {
	add_subtype('object', 'questions', 'ElggQuestions');
}

if (get_subtype_id('object', 'options')) {
	update_subtype('object', 'options', 'ElggOptions');
} else {
	add_subtype('object', 'options', 'ElggOptions');
}
