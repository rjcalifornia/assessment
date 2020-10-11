<?php
/**
 * Extended class to override the time_created
 *
 * @property string $status      The published status of the blog post (published, draft)
 * @property string $comments_on Whether commenting is allowed (Off, On)
 * @property string $excerpt     An excerpt of the blog post used when displaying the post
 */
class ElggOptions extends ElggObject {
 
	/**
	 * Set subtype to blog. 
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "options";
	}

	 
	/**
	 * Get the excerpt for this blog post
	 *
	 * @param int $length Length of the excerpt (optional)
	 * @return string
	 * @since 1.9.0
	 */
	public function getExcerpt($length = 14) {
		if ($this->excerpt) {
			return elgg_get_excerpt($this->title, $length);
		} else {
			return elgg_get_excerpt($this->title, $length);
		}
	}

}
