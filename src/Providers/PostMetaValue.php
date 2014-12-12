<?php

namespace WCM\AstroFields\PostMeta\Providers;

use WCM\AstroFields\Core\Providers;

/**
 * Class PostMetaValue
 * @package WCM\AstroFields\PostMeta\Receivers
 */
class PostMetaValue implements
	Providers\EntityProviderInterface,
	Providers\AttributeAwareInterface,
	Providers\OptionAwareInterface
{
	/** @type Array */
	private $data;

	/**
	 * Set the data to deliver to the template
	 * @param array $data
	 */
	public function setData( Array $data )
	{
		$this->data = $data;
	}

	/**
	 * Retrieve the key used in `name` and (optional) the `id`
	 * @return string
	 */
	public function getKey()
	{
		return $this->data['key'];
	}

	/**
	 * Retrieve the meta value
	 * @return string
	 */
	public function getValue()
	{
		return get_post_meta(
			get_the_ID(),
			$this->data['key'],
			true
		);
	}

	/**
	 * Retrieve (optional) `attributes`
	 * If the `value` stays empty, only the `key` gets assigned
	 * Use this for i.e. `required`,  `disabled`, etc.
	 * @return string
	 */
	public function getAttributes()
	{
		if ( ! isset( $this->data['attributes'] ) )
			return '';

		$result = '';
		foreach ( $this->data['attributes'] as $key => $val )
		{
			$result .= " {$key}";
			! empty( $val ) AND $result .= sprintf( '="%s"', $val );
		}

		return $result;
	}

	/**
	 * Retrieve (optional) `options`
	 * @return array
	 */
	public function getOptions()
	{
		if ( ! isset( $this->data['options'] ) )
			return array();

		return $this->data['options'];
	}
}