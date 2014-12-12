<?php

namespace WCM\AstroFields\PostMeta\Test\Receivers;

use WCM\AstroFields\PostMeta\Receivers\PostMetaValue;

class PostMetaValueTest extends \PHPUnit_Framework_TestCase
{
	/** @var PostMetaValue */
	private $object;

	public function setup()
	{
		$this->object = new PostMetaValue;
		$data = $this->getTestData();
		$this->object->setData( $data[0] );
	}

	/**
	 * @covers PostMetaValue::getKey()
	 */
	public function testGetKey()
	{
		$this->assertSame( 'testkey', $this->object->getKey() );
	}

	/**
	 * @covers PostMetaValue::getAttributes()
	 */
	public function testGetAttributes()
	{
		$this->assertNotEmpty( $this->object->getAttributes() );

		$this->assertSame(
			' size="40" class="foo bar bazz"',
			$this->object->getAttributes()
		);

		$this->object->setData( array() );
		$this->assertEmpty( $this->object->getAttributes() );
	}

	/**
	 * @covers PostMetaValue::getOptions()
	 */
	public function testGetOptionsEmpty()
	{
		$this->assertInternalType( 'array', $this->object->getOptions() );

		$this->assertNotEmpty( 'options', $this->object->getOptions() );

		$this->object->setData( array() );
		$this->assertEmpty( $this->object->getOptions() );
	}

	public function getTestData()
	{
		return array(
			array(
				'attributes' => array(
					'size'  => 40,
					'class' => 'foo bar bazz',
				),
				'key'        => 'testkey',
				'types'      => array(
					'post',
					'page',
				),
				'options' => array(
					''        => '-- select --',
					'bar'     => 'Bar',
					'foo'     => 'Foo',
					'baz'     => 'Baz',
					'dragons' => 'Dragons',
				),
			),
		);
	}
}