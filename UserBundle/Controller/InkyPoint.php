<?php

namespace Inky\UserBundle\Controller ;

use Doctrine\ORM\EntityManager as EntityManager;

use Inky\UserBundle\Entity\User as User;
use Inky\UserBundle\Entity\Point as Point;

class InkyPoint
{
	protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
	
	// We add a certain number of point, the date and the user to POINT.PHP
	public function addPoint(User $user, $point)
	{
		$newPoint = new Point();
		$newPoint->setPoint($point);
		$newPoint->setUser($user);
		
		$this->em->persist($newPoint);
		$this->em->flush();
		
		return true;
	}
	
}
