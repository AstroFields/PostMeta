<?php

namespace WCM\AstroFields\PostMeta\Commands;

use WCM\AstroFields\Core;

/**
 * Class SaveMeta
 * This Command performs the initial saving of a meta value.
 * @package WCM\AstroFields\PostMeta\Commands
 */
class SaveMeta implements \SplObserver, Core\Commands\ContextAwareInterface
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

		if (
			! isset( $_POST[ $data['key'] ] )
			OR empty( $_POST[ $data['key'] ] )
		)
			return;

		$updated = $this->save();
		$notice  = $this->check( $updated );

		# @TODO Do something with the notice. Example:
		if ( ! isset( $_POST['message'] ) )
			$_POST['message'] = $notice;
		else
			$_POST['message'] .= "<br>{$notice}";
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

	public function save()
	{
		return add_post_meta(
			$this->postID,
			$this->data['key'],
			$_POST[ $this->data['key'] ],
			true
		);
	}

	public function check( $updated )
	{
		/** @var \WP_Error|mixed $updated */
		if ( is_wp_error( $updated ) )
		{
			$notice = sprintf(
				'%s: %s',
				$updated->get_error_code(),
				$updated->get_error_message()
			);
		}
		elseif ( is_int( $updated ) )
		{
			$notice = sprintf(
				'New value added for: <code>%s</code>',
				$this->data['key']
			);
		}
		elseif ( ! $updated )
		{
			$notice = sprintf(
				'Post meta <code>%s</code> not updated',
				$this->data['key']
			);
		}
		else
		{
			$notice = sprintf(
				'Post Meta <code>%s</code> updated',
				$this->data['key']
			);
		}

		return $notice;
	}
}