<?php

namespace WCM\AstroFields\PostMeta\Commands;

use WCM\AstroFields\Core\Commands;
use WCM\AstroFields\Core\Mediators\EntityInterface;

class UpdateMeta implements
	Commands\CommandInterface,
	Commands\ContextAwareInterface
{
	/** @type string */
	private $context = 'edit_post';

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
		$notice  = $this->check( $updated, $id, $key );
		# @TODO Do something with the notice
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
		return update_post_meta( $id, $key, $_POST[ $key ] );
	}

	public function check( $updated, $id, $key )
	{
		$notice = 'Post Meta updated';
		/** @var \WP_Error $updated */
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
			esc_url( add_query_arg( 'message', 5, get_permalink( $id ) ) );
			$notice = "New value added for: {$key}";
		}
		elseif ( ! $updated )
		{
			esc_url( add_query_arg( 'message', 6, get_permalink( $id ) ) );
			$notice = 'Post meta not updated';
		}
		else
		{
			esc_url( add_query_arg( 'message', 7, get_permalink( $id ) ) );
		}

		return $notice;
	}
}