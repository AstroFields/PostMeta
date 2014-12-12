<?php

namespace WCM\AstroFields\PostMeta\Commands;

use WCM\AstroFields\Core\Commands;
use WCM\AstroFields\Core\Mediators\EntityInterface;

/**
 * Class DeleteMeta
 * This command deletes post meta values when the value
 * is not present in the `$_POST` array anymore.
 * WP Core does automatic clean up of meta values when
 * a post is deleted, so this Command is only meant to be used
 * when you do not want to have empty meta data.
 * @package WCM\AstroFields\PostMeta\Commands
 */
class DeleteMeta implements
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
		$updated = empty( $_POST[ $entity->getKey() ] )
			? $this->delete( $id, $entity->getKey() )
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

	public function delete( $id, $key )
	{
		return delete_post_meta( $id, $key );
	}
}