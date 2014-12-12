<?php

namespace WCM\AstroFields\PostMeta\Commands;

use WCM\AstroFields\Core\Commands;
use WCM\AstroFields\Core\Mediators\EntityInterface;

/**
 * Class SaveMeta
 * This Command performs the initial saving of a meta value.
 * @package WCM\AstroFields\PostMeta\Commands
 */
class SaveMeta implements
	Commands\CommandInterface,
	Commands\ContextAwareInterface
{
	/** @type string */
	private $context = 'save_post_{type}';

	/**
	 * @param int             $id
	 * @param \WP_Post        $post
	 * @param bool            $updated
	 * @param EntityInterface $entity
	 * @param array           $data
	 * @return mixed|void
	 */
	public function update(
		$id = 0,
		\WP_Post $post = null,
		$updated = false,
		EntityInterface $entity = null,
		Array $data = array()
		)
	{
		$key = $entity->getKey();
		if (
			! isset( $_POST[ $key ] )
			OR empty( $_POST[ $key ] )
		)
			return;

		$updated = $this->save( $id, $key );
		$notice  = $this->check( $updated, $key );

		# @TODO Do something with the notice. Example:
		/*if ( ! isset( $_POST['message'] ) )
			$_POST['message'] = $notice;
		else
			$_POST['message'] .= "<br>{$notice}";*/
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

	public function save( $id, $key )
	{
		return add_post_meta( $id, $key, $_POST[ $key ], true );
	}

	public function check( $updated, $key )
	{
		$notice = sprintf( 'Post Meta <code>%s</code> updated', $key );
		/** @var \WP_Error|mixed $updated */
		if ( is_wp_error( $updated ) )
		{
			$notice = sprintf( '%s: %s',
				$updated->get_error_code(),
				$updated->get_error_message()
			);
		}
		elseif ( is_int( $updated ) )
			$notice = sprintf( 'New value added for: <code>%s</code>', $key );
		elseif ( ! $updated )
			$notice = sprintf( 'Post meta <code>%s</code> not updated', $key );

		return $notice;
	}
}