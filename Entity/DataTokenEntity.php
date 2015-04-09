<?php

namespace Alborq\DataTokenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Process\Exception\LogicException;

/**
 * DataTokenEntity
 *
 * @ORM\Table(name="DataToken")
 * @ORM\Entity(repositoryClass="Alborq\DataTokenBundle\Repository\DataTokenEntityRepository")
 * @UniqueEntity("token")
 */
class DataTokenEntity
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
     * @ORM\Column(name="token", type="string", length=40)
     */
    private $token = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreate", type="datetime")
     */
    private $dateCreate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="datetime")
     */
    private $dateEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="blob")
     */
    private $data;

    protected $error = false;
    protected $unserializedData = null;

    public function __construct(){
        $this->dateCreate = new \DateTime();
        $this->dateEnd = new \DateTime();
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
     * Set token
     *
     * @param string $token
     * @return DataTokenEntity
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime 
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return DataTokenEntity
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return DataTokenEntity
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set data
     *
     * @param string $data
     * @return DataTokenEntity
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Add Interval to endDate
     *
     * @param \DateInterval $interval
     * @return $this
     */
    public function addInterval(\DateInterval $interval)
    {
        $this->dateEnd->add($interval);

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setUnserializedData($data)
    {
        $this->unserializedData = $data;

        return $this;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setError($LastError)
    {
        $this->error = $LastError;
        return $this;
    }

    public function getUnserializedData()
    {
        return $this->unserializedData;
    }
}
