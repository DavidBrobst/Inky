<?php

namespace Inky\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class InkyUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
