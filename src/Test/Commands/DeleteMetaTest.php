<?php

namespace WCM\AstroFields\PostMeta\Test\Commands;

use WCM\AstroFields\PostMeta\Commands;

class DeleteMetaTest extends \PHPUnit_Framework_TestCase
{
	/** @var Commands\DeleteMeta */
	private $object;

	public function setup()
	{
		$this->object = new Commands\DeleteMeta;
	}

	/**
	 * Allowed context string characters: a-z, underscore, curly braces
	 * @covers Commands\DeleteMeta::getContext()
	 */
	public function testHasValidDefaultContext()
	{
		$this->assertRegExp( '/^([_a-z\{\}]*+)$/i', $this->object->getContext() );
		$this->assertInternalType( 'string', $this->object->getContext() );
	}

	/**
	 * @covers DeleteMeta::setContext()
	 */
	public function testSetContext()
	{
		$context = 'save_post_{type}';
		$this->object->setContext( $context );

		$this->assertNotEmpty( $this->object->getContext() );
		$this->assertInternalType( 'string', $this->object->getContext() );
		$this->assertEquals( $context, $this->object->getContext() );
	}
}
