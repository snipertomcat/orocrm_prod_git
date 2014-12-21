<?php

namespace Stc\Bundle\GoogleMapBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

use JMS\Serializer\Annotation as JMS;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\TagBundle\Entity\Taggable;
use Oro\Bundle\DataAuditBundle\Metadata\Annotation as Oro;
use Oro\Bundle\UserBundle\Entity\User;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;

use Stc\Bundle\PerformanceBundle\Entity\Performance;
use Stc\Bundle\GoogleMapBundle\Model\ExtendCoordinate;

use Ivory\GoogleMapBundle\Entity\Coordinate as GMapsCoordinate;

/**
 * Coordinate
 *
 * @ORM\Table(name="stc_coordinate", indexes={@ORM\Index(name="stc_googlemap_name_idx", columns={"name"})})
 *
 * @Oro\Loggable
 * @ORM\Entity(repositoryClass="Stc\Bundle\GoogleMapBundle\Entity\Repository\CoordinateRepository")
 * @Config(
 * defaultValues={
 * "ownership"={
 * "owner_type"="USER",
 * "owner_field_name"="owner",
 * "owner_column_name"="owner_id"
 * },
 * "security"={
 * "type"="ACL"
 * },
 * "dataaudit"={"auditable"=true}
 * }
 * )
 */
class Coordinate extends ExtendCoordinate implements Taggable
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Type("integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     *
     */
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="name")
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $name;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     * @JMS\Type("double")
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     * @JMS\Type("double")
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @JMS\Type("string")
     */
    private $entityType;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @JMS\Type("integer")
     */
    private $entityId;

    public function __construct($lat = null, $lng = null)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLatitude($lat)
    {
        $this->latitude = $lat;
    }

    public function setLongitude($lng)
    {
        $this->longitude = $lng;
    }

    public function __toString()
    {
        return '(' . $this->latitude . ', ' . $this->longitude . ')';
    }

    public function createFromString($string)
    {
        if (strlen($string) < 1) {
            return new self;
        }
        $string = str_replace(['(', ')', ' '], '', $string);
        $data = explode(',', $string);
        if ($data[0] === "" || $data[1] === "") {
            return new self;
        }
        return new self($data[0], $data[1]);
    }

    public function toGmaps()
    {
        return new GMapsCoordinate($this->latitude, $this->longitude);
    }

    /*
     * @return ArrayCollection
    */
    public function getTags()
    {
        if (null === $this->tags) {
            $this->tags = new ArrayCollection();
        }

        return $this->tags;
    }

    /*
    * @param $tags
    * @return Performance
    */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return int
     */
    public function getTaggableId()
    {
        return $this->getId();
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $entityType
     */
    public function setEntityType($entityType)
    {
        $this->entityType = $entityType;
    }

    /**
     * @return mixed
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

    /**
     * @param mixed $entityId
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
    }

    /**
     * @return mixed
     */
    public function getEntityId()
    {
        return $this->entityId;
    }



}