<?php

namespace Inky\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Thread
 *
 * @ORM\Table(name="forum_thread")
 * @ORM\Entity(repositoryClass="Inky\ForumBundle\Entity\ThreadRepository")
 */
class Thread
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slugFirstMessage", type="string", length=255)
     */
    private $slugFirstMessage;

    /**
     * @var integer
     *
     * @ORM\Column(name="voteFirstMessage", type="integer")
     */
    private $voteFirstMessage = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isDeleted", type="boolean")
     */
    private $isDeleted = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isLocked", type="boolean")
     */
    private $isLocked = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isFlagged", type="boolean")
     */
    private $isFlagged = 0;

	/**
     * @var boolean
     *
     * @ORM\Column(name="isAnswered", type="boolean")
     */
    private $isAnswered = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="views", type="integer")
     */
    private $views = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="replies", type="integer")
     */
    private $replies = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last", type="datetime")
     */
    private $last;

	/**
	 * @ORM\ManyToOne(targetEntity="Inky\ForumBundle\Entity\Topic",cascade={"persist"}, inversedBy="thread")
	 */
	private $topic;
	
	/**
	 * @ORM\OneToMany(targetEntity="Inky\ForumBundle\Entity\Message",cascade={"persist","remove"}, mappedBy="thread")
	 */
	private $message;
	
	/**
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\User")
	*/
	private $user;
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Thread
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slugFirstMessage
     *
     * @param string $slugFirstMessage
     * @return Thread
     */
    public function setSlugFirstMessage($slugFirstMessage)
    {
        $this->slugFirstMessage = $slugFirstMessage;
    
        return $this;
    }

    /**
     * Get slugFirstMessage
     *
     * @return string 
     */
    public function getSlugFirstMessage()
    {
        return $this->slugFirstMessage;
    }

    /**
     * Set voteFirstMessage
     *
     * @param integer $voteFirstMessage
     * @return Thread
     */
    public function setVoteFirstMessage($voteFirstMessage)
    {
        $this->voteFirstMessage = $voteFirstMessage;
    
        return $this;
    }

    /**
     * Get voteFirstMessage
     *
     * @return integer 
     */
    public function getVoteFirstMessage()
    {
        return $this->voteFirstMessage;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return Thread
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    
        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean 
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set isLocked
     *
     * @param boolean $isLocked
     * @return Thread
     */
    public function setIsLocked($isLocked)
    {
        $this->isLocked = $isLocked;
    
        return $this;
    }

    /**
     * Get isLocked
     *
     * @return boolean 
     */
    public function getIsLocked()
    {
        return $this->isLocked;
    }

    /**
     * Set isFlagged
     *
     * @param boolean $isFlagged
     * @return Thread
     */
    public function setIsFlagged($isFlagged)
    {
        $this->isFlagged = $isFlagged;
    
        return $this;
    }

    /**
     * Get isFlagged
     *
     * @return boolean 
     */
    public function getIsFlagged()
    {
        return $this->isFlagged;
    }

    /**
     * Set views
     *
     * @param integer $views
     * @return Thread
     */
    public function setViews($views)
    {
        $this->views = $views;
    
        return $this;
    }

    /**
     * Get views
     *
     * @return integer 
     */
    public function getViews()
    {
        return $this->views;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->message = new \Doctrine\Common\Collections\ArrayCollection();
        $this->last = new \Datetime();
    }
    
    /**
     * Set topic
     *
     * @param \Inky\ForumBundle\Entity\Topic $topic
     * @return Thread
     */
    public function setTopic(\Inky\ForumBundle\Entity\Topic $topic = null)
    {
        $this->topic = $topic;
    
        return $this;
    }

    /**
     * Get topic
     *
     * @return \Inky\ForumBundle\Entity\Topic 
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Add message
     *
     * @param \Inky\ForumBundle\Entity\Message $message
     * @return Thread
     */
    public function addMessage(\Inky\ForumBundle\Entity\Message $message)
    {
        $this->message[] = $message;
		$message->setThread($this);
        return $this;
    }

    /**
     * Remove message
     *
     * @param \Inky\ForumBundle\Entity\Message $message
     */
    public function removeMessage(\Inky\ForumBundle\Entity\Message $message)
    {
        $this->message->removeElement($message);
    }

    /**
     * Get message
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return Thread
     */
    public function setUser(\Inky\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Inky\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set isAnswered
     *
     * @param boolean $isAnswered
     * @return Thread
     */
    public function setIsAnswered($isAnswered)
    {
        $this->isAnswered = $isAnswered;
    
        return $this;
    }

    /**
     * Get isAnswered
     *
     * @return boolean 
     */
    public function getIsAnswered()
    {
        return $this->isAnswered;
    }

    /**
     * Set replies
     *
     * @param integer $replies
     * @return Thread
     */
    public function setReplies($replies)
    {
        $this->replies = $replies;
    
        return $this;
    }

    /**
     * Get replies
     *
     * @return integer 
     */
    public function getReplies()
    {
        return $this->replies;
    }

    /**
     * Set last
     *
     * @param \DateTime $last
     * @return Thread
     */
    public function setLast($last)
    {
        $this->last = $last;
    
        return $this;
    }

    /**
     * Get last
     *
     * @return \DateTime 
     */
    public function getLast()
    {
        return $this->last;
    }
}