<?php

namespace WCM\AstroFields\PostMeta\Commands;

use WCM\AstroFields\Core;

/**
 * Class SaveMeta
 * This Command performs the initial saving of a meta value.
 * @package WCM\AstroFields\PostMeta\Commands
 */
class Messages implements Core\Commands\ContextAwareInterface
{
	/** @type string */
	private $context = 'redirect_post_location';

	/** @type Array */
	private $data;

	/**
	 * @param \SplSubject $subject
	 * @param array       $data
	 */
	public function update( \SplSubject $subject, Array $data = null )
	{
		$this->data = $data;
		$location = $data['args'][0];
		$post_id  = $data['args'][1];

		if (
			! isset( $_POST['message'] )
			OR empty( $_POST['message'] )
		)
			return $location;

		# $location = add_query_arg( 'message', 4, get_edit_post_link( $post_id, 'url' ) );
		return $location;
	}

	public function setContext( $context )
	{
		$this->context = $context;

		return $this;
	}

	public function getContext()
	{
		return $this->context;
	}
}
