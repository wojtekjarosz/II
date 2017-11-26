<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trail
 *
 * @ORM\Table(name="trail")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrailRepository")
 */
class Trail
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="startPoint", type="string", length=255)
     */
    private $startPoint;

    /**
     * @var string
     *
     * @ORM\Column(name="finalPoint", type="string", length=255)
     */
    private $finalPoint;

    /**
     * @var string
     *
     * @ORM\Column(name="colour", type="string", length=255)
     */
    private $colour;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulty", type="string", length=255)
     */
    private $difficulty;

    /**
     * @var Photo
     *
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="trail")
     */
    private $photos;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Trail
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startPoint
     *
     * @param string $startPoint
     *
     * @return Trail
     */
    public function setStartPoint($startPoint)
    {
        $this->startPoint = $startPoint;

        return $this;
    }

    /**
     * Get startPoint
     *
     * @return string
     */
    public function getStartPoint()
    {
        return $this->startPoint;
    }

    /**
     * Set finalPoint
     *
     * @param string $finalPoint
     *
     * @return Trail
     */
    public function setFinalPoint($finalPoint)
    {
        $this->finalPoint = $finalPoint;

        return $this;
    }

    /**
     * Get finalPoint
     *
     * @return string
     */
    public function getFinalPoint()
    {
        return $this->finalPoint;
    }

    /**
     * Set colour
     *
     * @param string $colour
     *
     * @return Trail
     */
    public function setColour($colour)
    {
        $this->colour = $colour;

        return $this;
    }

    /**
     * Get colour
     *
     * @return string
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * Set difficulty
     *
     * @param string $difficulty
     *
     * @return Trail
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return string
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add photo
     *
     * @param \AppBundle\Entity\Photo $photo
     *
     * @return Trail
     */
    public function addPhoto(\AppBundle\Entity\Photo $photo)
    {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \AppBundle\Entity\Photo $photo
     */
    public function removePaper(\AppBundle\Entity\Photo $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    public function __toString()
    {
        return $this->name;
    }

}

