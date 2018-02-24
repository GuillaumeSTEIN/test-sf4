<?php

namespace App\AdminBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\AdminBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column()
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $title;


    /**
     * @var string
     * @ORM\Column(length=1000)
     * @Assert\Length(max="1000")
     */
    private $description;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $postedAt;

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->postedAt = new DateTime();
    }

    /**
     * @return DateTime
     */
    public function getPostedAt()
    {
        return $this->postedAt;
    }

    /**
     * @param DateTime $postedAt
     */
    public function setPostedAt($postedAt)
    {
        $this->postedAt = $postedAt;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = strip_tags($description,'<a><img>');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = strip_tags($title);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
