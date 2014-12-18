<?php

namespace Astro;

use WCM\AstroFields\Core\Mediators\Entity;
use WCM\AstroFields\Core\Commands\ViewCmd;
use WCM\AstroFields\Core\Templates\TemplateInterface;
use WCM\AstroFields\PostMeta\Commands;
use WCM\AstroFields\PostMeta\Providers;

class PostMetaBundle implements BundleProviderInterface
{
	private $template;

	public function template( TemplateInterface $template )
	{
		$this->template = $template;
	}

	public function register( Entity &$entity )
	{
		$entity->attach( new Commands\SaveMeta );
		$entity->attach( new Commands\UpdateMeta );
		$entity->attach( new Commands\DeleteMeta );
		if ( ! empty( $this->template ) )
		{
			$entity->attach( new ViewCmd(
				new Providers\PostMetaValue,
				$this->template
			) );
		}

		#return $entity;
	}
}