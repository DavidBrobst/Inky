<?php

namespace Inky\ForumBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Inky\ForumBundle\Entity\Message;

class ArrayToMessageTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function transform($message)
    {
        return new Message;
    }
	
	public function reverseTransform($messageId)
    {
        if (!$number) {
            return null;
        }

        $message = $this->om
            ->getRepository('InkyForumBundle:Message')
            ->findOneBy(array('id' => $messageId))
        ;

        if (null === $message) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $messsageId
            ));
        }

        return $message;
    }
}