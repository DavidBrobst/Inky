<?php

namespace Inky\UserBundle\Controller ;

use Doctrine\ORM\EntityManager as EntityManager;

use Inky\UserBundle\Entity\User as User;
use Inky\UserBundle\Entity\PointAction as Action;
use Inky\UserBundle\Entity\Point as Point;

class InkyPoint
{
	protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
	
	// Here we associate a user with an action (ex: post on the forum, create a course, learnt a chapter...)
	// Each action is worth points that we add to the log of our user
	public function addPoint(User $user, $actionId)
	{
		$action = $this->em->getRepository('InkyUserBundle:PointAction')->findOneById($actionId);
		
		// We can now create the log specific to our user
		$newPoint = new Point();
		$newPoint->setAction($action);
		$newPoint->setUser($user);
		
		$this->em->persist($newPoint);
		$this->em->flush();
		
		
		return true;
	}
	public function retrievePoint(User $user, $action)
	{
		// Here we need to know what the user did
		// If he deleted a course for example we will have to take away the points he gained with the creation of the course
		// If we don't, creating and deleting courses for example will be an aberant source of point
		return true;
	}
	
	public function showPoint(User $user)
	{
		// We start by getting the 'Action' info via its Id
		$user_points = $this->em->getRepository('InkyUserBundle:Point')->getUserPoint($user);
		return $user_points;
	}
	
}
