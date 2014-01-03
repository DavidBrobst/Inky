<?php

namespace Inky\CourseBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * LessonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LessonRepository extends EntityRepository
{
public function getLessons($courseId, $user = null)
	{
		$query = 	$this->createQueryBuilder('l')
					->leftJoin('l.tags', 't')
						->addSelect('t');
		if ($user)
		{
		$query =$query	->leftJoin('l.lessonStatus', 'lS')
							->addSelect('lS')
							->where('lS.user ='.$user);
		}
		$query =$query	->where('l.isPublic = 1')
						->where('l.course ='.$courseId)
						->orderBy('l.orderid', 'ASC')
						->getQuery()
						->getResult();
		
		return $query;
	}
	

}