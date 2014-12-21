<?php

namespace Stc\Bundle\PerformanceTwoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

use JMS\Serializer\Annotation as JMS;

use OroCRM\Bundle\ContactBundle\Entity\Contact;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

use Oro\Bundle\DataAuditBundle\Metadata\Annotation as Oro;

use Oro\Bundle\UserBundle\Entity\User;

use Stc\Bundle\PerformanceTwoBundle\Model\ExtendPerformanceTwo;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * PerformanceTwo
 *
 * @ORM\Table(name="stc_performancetwos", indexes={
 * @ORM\Index(name="stc_performancetwos_name_idx", columns={"name"})
 * })
 * @ORM\HasLifecycleCallbacks()
 * @Oro\Loggable
 * @ORM\Entity(repositoryClass="Stc\Bundle\PerformanceTwoBundle\Entity\Repository\PerformanceTwoRepository")
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
class PerformanceTwo extends ExtendPerformanceTwo
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
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
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime")
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $createdAt;

    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $updatedAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="assignee_id", referencedColumnName="id", onDelete="SET NULL")
     * @Oro\Versioned("getUsername")
     * @JMS\Type("integer")
     * @JMS\Accessor(getter="getAssigneeId")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $assignee;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @Oro\Versioned("getUsername")
     * @JMS\Type("integer")
     * @JMS\Accessor(getter="getOwnerId")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Oro\Versioned
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )+
     * @JMS\Type("string")
     */
    protected $description;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @JMS\Type("boolean")
     */
    protected $deleted;

    /**
     * @var string
     *
     * @ORM\Column(name="profileType", type="string", length=50, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $profileType;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $website;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer",nullable=true)
     * @JMS\Type("integer")
     */
    protected $annualReperformancetwo;

    /**
     * @var string
     *
     * @ORM\Column(name="performanceType", type="string", length=15, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $performanceType;

    /**
     * @var string
     *
     * @ORM\Column(name="leadSource", type="string", length=255)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $leadSource;

    /**
     * @var string
     *
     * @ORM\Column(name="nextStep", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $nextStep;

    /**
     * @var string
     *
     * @ORM\Column(name="salesStage", type="string", length=25, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $salesStage;

    /**
     * @var string
     *
     * @ORM\Column(name="probability", type="float", nullable=true)
     * @Oro\Versioned
     * @JMS\Type("double")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $probability;


    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $closedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Stc\Bundle\VenueBundle\Entity\Venue")
     * @ORM\JoinColumn(name="venue_id", referencedColumnName="id")
     */
    protected $venue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $performanceDate;

    /**
     * @var string
     *
     * @ORM\Column(name="performanceLength", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $performanceLength;

    /**
     * @var string
     *
     * @ORM\Column(name="loadInAt", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $loadInAt;

    /**
     * @var string
     *
     * @ORM\Column(name="performanceEndAt", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $performanceEndAt;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     * @JMS\Type("boolean")
     */
    protected $mealsIncluded;

    /**
     *
     * @ORM\Column(name="performanceFee", type="float", nullable=true)
     * @Oro\Versioned
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $performanceFee;

    /**
     *
     * @ORM\Column(name="budget", type="float", nullable=true)
     * @Oro\Versioned
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $budget;

    /**
     *
     * @ORM\Column(name="flightBudget", type="float", nullable=true)
     * @Oro\Versioned
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $flightBudget;

    /**
     *
     * @ORM\Column(name="rentalCarBudget", type="float", nullable=true)
     * @Oro\Versioned
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $rentalCarBudget;

    /**
     *
     * @ORM\Column(name="hotelBudget", type="float", nullable=true)
     * @Oro\Versioned
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $hotelBudget;

    /**
     * @var string
     *
     * @ORM\Column(name="estimatedAttendance", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $estimatedAttendance;

    /**
     * @var string
     *
     * @ORM\Column(name="actualAttendance", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $actualAttendance;

    /**
     * @var string
     *
     * @ORM\Column(name="postShowComments", type="text", nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $postShowComments;

    /**
     * @var string
     *
     * @ORM\Column(name="travelComments", type="text", nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $travelComments;

    /**
     * @var string
     *
     * @ORM\Column(name="soundCheckAt", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $soundCheckAt;

    /**
     * @var string
     *
     * @ORM\Column(name="performanceHostStatus", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $performanceHostStatus;

    /**
     * @ORM\ManyToMany(targetEntity="Stc\Bundle\BandBundle\Entity\Band")
     * @ORM\JoinTable(
     *     name="stc_performancetwo_to_band",
     *     joinColumns={@ORM\JoinColumn(name="Performance_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="Band_id", referencedColumnName="id")}
     * )
     */
    protected $bands;

    /**
     * @ORM\ManyToMany(targetEntity="Stc\Bundle\ContractBundle\Entity\Contract", inversedBy="performance")
     * @ORM\JoinTable(
     *     name="stc_performancetwo_to_contracts",
     *     joinColumns={@ORM\JoinColumn(name="performance_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="contract_id", referencedColumnName="id")}
     * )
     */
    protected $contracts;

    /**
     * Constructor
     */
    public function __construct()
    {
        //$this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->bands = new ArrayCollection();
        $this->contracts = new ArrayCollection();
    }


    /**
     * @return int
     */
    public function getActualAttendance()
    {
        return $this->actualAttendance;
    }

    /**
     * @param int $actualAttendance
     */
    public function setActualAttendance($actualAttendance)
    {
        $this->actualAttendance = $actualAttendance;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @param \Oro\Bundle\UserBundle\Entity\User $assignee
     */
    public function setAssignee($assignee)
    {
        $this->assignee = $assignee;
    }


    /**
     * @return ArrayCollection
     */
    public function getBands()
    {
        return $this->bands;
    }

    /**
     * @param ArrayCollection $bands
     */
    public function setBands($bands)
    {
        $this->bands = $bands;
        $iterator = $this->bands->getIterator();
        foreach ($iterator as $band) {
            $this->addBand($band);
        }
    }

    public function addBand($band)
    {
        if (!$this->bands->contains($band)) {
            $this->bands->add($band);
        }
    }

    public function removeBand($band)
    {
        if ($this->bands->contains($band)) {
            $this->bands->removeElement($band);
        }
    }

    /**
     * @return string
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param string $budget
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }

    /**
     * @return \DateTime
     */
    public function getClosedAt()
    {
        return $this->closedAt;
    }

    /**
     * @param \DateTime $closedAt
     */
    public function setClosedAt($closedAt)
    {
        if (!$closedAt instanceof \DateTime) {
            $closedAt = new \DateTime($closedAt);
        } else {
            $closedAt = $closedAt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        }
        $this->closedAt = $closedAt;
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        $array = $this->contacts->toArray();
        if (!empty($array)) {
            return $array[0];
        }
    }

    /**
     * @param mixed $contacts
     */
    public function setContacts($contacts)
    {
        if (is_array($contacts)) {
            foreach ($contacts as $contact) {
                $this->addContact($contact);
            }
        } else {
            $this->addContact($contacts);
        }
    }

    /**
     * @return $this
     */
    public function addContact($contact)
    {
        $contactsToArray = $this->contacts->toArray();
        if (!in_array($contact, $contactsToArray)) {
            $this->contacts->add($contact);
        }
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        //$createdAtString = $createdAt->format('Y-m-d');
        //$datetime = $createdAt->createFromFormat('Y-m-d',$createdAtString,new \DateTimeZone('America/Los_Angeles'));
        $createdAt = $createdAt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        $this->createdAt = $createdAt;
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
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
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getEstimatedAttendance()
    {
        return $this->estimatedAttendance;
    }

    /**
     * @param int $estimatedAttendance
     */
    public function setEstimatedAttendance($estimatedAttendance)
    {
        $this->estimatedAttendance = $estimatedAttendance;
    }

    /**
     * @return string
     */
    public function getFlightBudget()
    {
        return $this->flightBudget;
    }

    /**
     * @param string $flightBudget
     */
    public function setFlightBudget($flightBudget)
    {
        $this->flightBudget = $flightBudget;
    }

    /**
     * @return string
     */
    public function getHotelBudget()
    {
        return $this->hotelBudget;
    }

    /**
     * @param string $hotelBudget
     */
    public function setHotelBudget($hotelBudget)
    {
        $this->hotelBudget = $hotelBudget;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLeadSource()
    {
        return $this->leadSource;
    }

    /**
     * @param string $leadSource
     */
    public function setLeadSource($leadSource)
    {
        $this->leadSource = $leadSource;
    }

    /**
     * @return
     */
    public function getLoadInAt()
    {
        return $this->loadInAt;
    }

    /**
     * @param  $loadInAt
     */
    public function setLoadInAt($loadInAt)
    {
        $this->loadInAt = $loadInAt;
    }

    /**
     * @return boolean
     */
    public function isMealsIncluded()
    {
        return $this->mealsIncluded;
    }

    /**
     * @param boolean $mealsIncluded
     */
    public function setMealsIncluded($mealsIncluded)
    {
        $this->mealsIncluded = $mealsIncluded;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
    public function getNextStep()
    {
        return $this->nextStep;
    }

    /**
     * @param string $nextStep
     */
    public function setNextStep($nextStep)
    {
        $this->nextStep = $nextStep;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param \Oro\Bundle\UserBundle\Entity\User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return \DateTime
     */
    public function getPerformanceDate()
    {
        return $this->performanceDate;
    }

    /**
     * @param \DateTime $performanceDate
     */
    public function setPerformanceDate($performanceDate)
    {
        //$datetime = $performanceDate->createFromFormat('Y-m-d',$performanceDate->('string'),new \DateTimeZone('America/Los_Angeles'));
        if (null !== $performanceDate) {
            if (!$performanceDate instanceof \DateTime) {
                $performanceDate = new \DateTime($performanceDate);
            } else {
                $performanceDate = $performanceDate->setTimezone(new \DateTimeZone('America/Los_Angeles'));
            }
            $this->performanceDate = $performanceDate;
        } else {
            $this->performanceDate = new \DateTime('now');
        }
    }

    /**
     * @return
     */
    public function getPerformanceEndAt()
    {
        return $this->performanceEndAt;
    }

    /**
     * @param  $performanceEndAt
     */
    public function setPerformanceEndAt($performanceEndAt)
    {
        $this->performanceEndAt = $performanceEndAt;
    }

    /**
     * @return string
     */
    public function getPerformanceFee()
    {
        return $this->performanceFee;
    }

    /**
     * @param string $performanceFee
     */
    public function setPerformanceFee($performanceFee)
    {
        $this->performanceFee = $performanceFee;
    }

    /**
     * @return string
     */
    public function getPerformanceHostStatus()
    {
        return $this->performanceHostStatus;
    }

    /**
     * @param string $performanceHostStatus
     */
    public function setPerformanceHostStatus($performanceHostStatus)
    {
        $this->performanceHostStatus = $performanceHostStatus;
    }

    /**
     * @return string
     */
    public function getPerformanceLength()
    {
        return $this->performanceLength;
    }

    /**
     * @param string $performanceLength
     */
    public function setPerformanceLength($performanceLength)
    {
        $this->performanceLength = $performanceLength;
    }

    /**
     * @return string
     */
    public function getPerformanceType()
    {
        return $this->performanceType;
    }

    /**
     * @param string $performanceType
     */
    public function setPerformanceType($performanceType)
    {
        $this->performanceType = $performanceType;
    }

    /**
     * @return string
     */
    public function getPostShowComments()
    {
        return $this->postShowComments;
    }

    /**
     * @param string $postShowComments
     */
    public function setPostShowComments($postShowComments)
    {
        $this->postShowComments = $postShowComments;
    }

    /**
     * @return string
     */
    public function getProbability()
    {
        return $this->probability;
    }

    /**
     * @param string $probability
     */
    public function setProbability($probability)
    {
        $this->probability = $probability;
    }

    /**
     * @return string
     */
    public function getProfileType()
    {
        return $this->profileType;
    }

    /**
     * @param string $profileType
     */
    public function setProfileType($profileType)
    {
        $this->profileType = $profileType;
    }

    /**
     * @return string
     */
    public function getRentalCarBudget()
    {
        return $this->rentalCarBudget;
    }

    /**
     * @param string $rentalCarBudget
     */
    public function setRentalCarBudget($rentalCarBudget)
    {
        $this->rentalCarBudget = $rentalCarBudget;
    }

    /**
     * @return string
     */
    public function getSalesStage()
    {
        return $this->salesStage;
    }

    /**
     * @param string $salesStage
     */
    public function setSalesStage($salesStage)
    {
        $this->salesStage = $salesStage;
    }

    /**
     * @return
     */
    public function getSoundCheckAt()
    {
        return $this->soundCheckAt;
    }

    /**
     * @param  $soundCheckAt
     */
    public function setSoundCheckAt($soundCheckAt)
    {
        $this->soundCheckAt = $soundCheckAt;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getTravelComments()
    {
        return $this->travelComments;
    }

    /**
     * @param string $travelComments
     */
    public function setTravelComments($travelComments)
    {
        $this->travelComments = $travelComments;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return Venue
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * @param Venue $venue
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return string
     */
    public function getAssigneeId()
    {
        $assignee = $this->getAssignee();

        if (is_object($assignee)) {
            return $assignee->getId();
        }
    }

    /**
     * @return string
     */
    public function getOwnerId()
    {
        $owner = $this->getOwner();

        if (is_object($owner)) {
            return $owner->getId();
        }
    }

    public function getVenueId()
    {
        return $this->getVenue()->getId();
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
     * @param mixed $contract
     */
    public function addContract($contract)
    {
        $this->contracts->add($contract);
    }

    /**
     * @return mixed
     */
    public function getContracts()
    {
        return $this->contracts;
    }

    /**
     * @return collection
     */
    public function getRelatedContactId()
    {
    }

    public function __toString()
    {
        return $this->name;
    }

}
