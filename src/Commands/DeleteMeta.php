<?php

namespace WCM\AstroFields\PostMeta\Commands;

use WCM\AstroFields\Core;

/**
 * Class DeleteMeta
 * This command deletes post meta values when the value
 * is not present in the `$_POST` array anymore.
 * WP Core does automatic clean up of meta values when
 * a post is deleted, so this Command is only meant to be used
 * when you do not want to have empty meta data.
 * @package WCM\AstroFields\PostMeta\Commands
 */
class DeleteMeta implements \SplObserver, Core\Commands\ContextAwareInterface
{
	/** @type string */
	private $context = 'save_post_{type}';

	/** @type Array */
	private $data;

	/** @type int */
	private $postID;

	/** @type \WP_Post */
	private $post;

	/**
	 * @param \SplSubject $subject
	 * @param array       $data
	 */
	public function update( \SplSubject $subject, Array $data = null )
	{
		$this->data   = $data;
		$this->postID = $data['args'][0];
		$this->post   = $data['args'][1];

		$updated = empty( $_POST[ $data['key'] ] )
			? $this->delete()
			: false;
		// @TODO Do something with the return value
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

	public function delete()
	{
		return delete_post_meta(
			$this->postID,
			$this->data['key']
		);
	}
}