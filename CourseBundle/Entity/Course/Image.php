<?php

namespace Inky\CourseBundle\Entity\Course;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\CourseBundle\Entity\Course\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
	 
    private $date;

	/**
	*  * @Assert\Image(
     *     	minWidth = 100,
	 *		minWidth = "Votre image doit etre plus large",
     *     	maxSize="3000k",
	 *		maxSizeMessage = "Votre image est trop lourde, ell doit faire au maximum 3Mo"
     * )
	*/
	private $file;
	
	private $tempFilename;
	
	/**
	* @ORM\PrePersist()
	* @ORM\PreUpdate()
	*/
	public function preUpload()
	{
		// Si jamais il n'y a pas de fichier (champ facultatif)
		if (null === $this->file) {
			return;
		}
		// Le nom du fichier est son id, on doit juste stocker �galement son extension
		$this->url = $this->file->guessExtension();
		// Et on g�n�re l'attribut alt de la balise <img>, �  la valeur du nom du fichier sur le PC de l'internaute
		$this->alt = $this->file->getClientOriginalName();
	}
	/**
	* @ORM\PostPersist()
	* @ORM\PostUpdate()
	*/
	public function upload()
	{
		
		if (null === $this->file) {
			// Si jamais il n'y a pas de fichier (champ facultatif)
			return;
		}
		// Si on avait un ancien fichier, on le supprime
		if (null !== $this->tempFilename) {
			$oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
			if (file_exists($oldFile)) 
			{
				unlink($oldFile);
			}
		}
		// On d�place le fichier envoyé dans le répertoire de notre choix
		$this->file->move(
			$this->getUploadRootDir(),
			$this->id.'.'.$this->url // Le nom du fichier � cr�er, ici "id.extension"
		);
	}
	
	public function __construct()
    {
		$this->date = new \Datetime;
	}
	/**
	* @ORM\PreRemove()
	*/
	public function preRemoveUpload()
	{
	// On sauvegarde temporairement le nom du fichier car il dépend de l'id
	$this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
	}
	/**
	* @ORM\PostRemove()
	*/
	public function removeUpload()
	{
		// En PostRemove, on n'a pas acc�s � l'id, on utilise notre nom sauvegard�
		if (file_exists($this->tempFilename)) {
		// On supprime le fichier
		unlink($this->tempFilename);
		}
	}
	public function getUploadDir()
	{
		// On retourne le chemin relatif vers l'image pour un navigateur
		return 'uploads/img';
	}
	protected function getUploadRootDir()
	{
		// On retourne le chemin absolu vers l'image pour notre code PHP
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}
	public function getWebPath()
	{
		return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
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
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    
        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Image
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
	
	public function setFile($file)
	{
		$this->file = $file;
		// On v�rifie si on avait d�j�  un fichier pour cette entit�
		if (null !== $this->url) 
		{
			// On sauvegarde l'extension du fichier pour le supprimer plus tard
			$this->tempFilename = $this->url;
			// On r�initialise les valeurs des attributs url et alt
			$this->url = null;
			$this->alt = null;
		}
	}
	public function getFile()
	{
		return $this->file;
	}
}
