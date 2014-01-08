<?php

namespace Inky\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="forum_message")
 * @ORM\Entity(repositoryClass="Inky\ForumBundle\Entity\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModified", type="datetime")
     */
    private $dateModified;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isDeleted", type="boolean")
     */
    private $isDeleted = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isFlagged", type="boolean")
     */
    private $isFlagged = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isFirstMessage", type="boolean", nullable=true )
     */
    private $isFirstMessage;

    /**
     * @var integer
     *
     * @ORM\Column(name="cachedVote", type="integer")
     */
    private $cachedVote = 0;

	/**
	 * @ORM\ManyToOne(targetEntity="Inky\ForumBundle\Entity\Thread",cascade={"persist"}, inversedBy="message")
	 */
	private $thread;

	/**
	 * @ORM\OneToMany(targetEntity="Inky\ForumBundle\Entity\Flag",cascade={"persist"}, mappedBy="message")
	 */
	private $flag;

	/**
	 * @ORM\OneToMany(targetEntity="Inky\ForumBundle\Entity\Comment",cascade={"persist"}, mappedBy="message")
	 */
	private $comment;

	/**
	 * @ORM\OneToMany(targetEntity="Inky\ForumBundle\Entity\Vote",cascade={"persist"}, mappedBy="message")
	 */
	private $vote = 0;

	/**
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\User")
	*/
	private $user;
		
   /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreated = new \Datetime;
        $this->dateModified = new \Datetime;
        $this->flag = new \Doctrine\Common\Collections\ArrayCollection();
        $this->vote = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set content
     *
     * @param string $content
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Message
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return Message
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;
    
        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime 
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return Message
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
     * Set isFlagged
     *
     * @param boolean $isFlagged
     * @return Message
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
     * Set isFirstMessage
     *
     * @param boolean $isFirstMessage
     * @return Message
     */
    public function setIsFirstMessage($isFirstMessage)
    {
        $this->isFirstMessage = $isFirstMessage;
    
        return $this;
    }

    /**
     * Get isFirstMessage
     *
     * @return boolean 
     */
    public function getIsFirstMessage()
    {
        return $this->isFirstMessage;
    }

    /**
     * Set cachedVote
     *
     * @param integer $cachedVote
     * @return Message
     */
    public function setCachedVote($cachedVote)
    {
        $this->cachedVote = $cachedVote;
    
        return $this;
    }

    /**
     * Get cachedVote
     *
     * @return integer 
     */
    public function getCachedVote()
    {
        return $this->cachedVote;
    }
 
    
    /**
     * Set thread
     *
     * @param \Inky\ForumBundle\Entity\Thread $thread
     * @return Message
     */
    public function setThread(\Inky\ForumBundle\Entity\Thread $thread = null)
    {
        $this->thread = $thread;
    
        return $this;
    }

    /**
     * Get thread
     *
     * @return \Inky\ForumBundle\Entity\Thread 
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Add flag
     *
     * @param \Inky\ForumBundle\Entity\Flag $flag
     * @return Message
     */
    public function addFlag(\Inky\ForumBundle\Entity\Flag $flag)
    {
        $this->flag[] = $flag;
    
        return $this;
    }

    /**
     * Remove flag
     *
     * @param \Inky\ForumBundle\Entity\Flag $flag
     */
    public function removeFlag(\Inky\ForumBundle\Entity\Flag $flag)
    {
        $this->flag->removeElement($flag);
    }

    /**
     * Get flag
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * Add vote
     *
     * @param \Inky\ForumBundle\Entity\Votes $vote
     * @return Message
     */
    public function addVote(\Inky\ForumBundle\Entity\Votes $vote)
    {
        $this->vote[] = $vote;
    
        return $this;
    }

    /**
     * Remove vote
     *
     * @param \Inky\ForumBundle\Entity\Votes $vote
     */
    public function removeVote(\Inky\ForumBundle\Entity\Votes $vote)
    {
        $this->vote->removeElement($vote);
    }

    /**
     * Get vote
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return Message
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
     * Add comment
     *
     * @param \Inky\ForumBundle\Entity\Comment $comment
     * @return Message
     */
    public function addComment(\Inky\ForumBundle\Entity\Comment $comment)
    {
        $this->comment[] = $comment;
    
        return $this;
    }

    /**
     * Remove comment
     *
     * @param \Inky\ForumBundle\Entity\Comment $comment
     */
    public function removeComment(\Inky\ForumBundle\Entity\Comment $comment)
    {
        $this->comment->removeElement($comment);
    }

    /**
     * Get comment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComment()
    {
        return $this->comment;
    }
}