<?php

namespace Inky\ForumBundle\Controller ;

use Doctrine\ORM\EntityManager as EntityManager;

class forumService
{
	public function ago($initialDateTime)
		{
			$obj_interval = $initialDateTime->diff(new \Datetime());

			$int = array();
			$int['year'] = intval($obj_interval->format('%y%'));
			$int['month'] = intval($obj_interval->format('%m%'));
			$int['day'] = intval($obj_interval->format('%d%'));
			$int['hour'] = intval($obj_interval->format('%h%'));
			$int['minute'] = intval($obj_interval->format('%i%'));
			$int['second'] = intval($obj_interval->format('%s%'));		
			foreach ($int as $key => $value) 
			{
				if($value>0)
				{
					return $interval = array($value,$key);
				}
			}
		}
}
