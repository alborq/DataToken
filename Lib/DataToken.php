<?php
/**
 * Created by PhpStorm.
 * User: i74375
 * Date: 07/04/2015
 * Time: 10:29
 */

namespace Alborq\DataTokenBundle\Lib;


class DataToken {

    protected  $token = null;

    protected $dateCreate;

    protected $dateEnd;

    protected $type;

    protected $data;

    protected $error;


    public function __construct(\Alborq\DataTokenBundle\Entity\DataTokenEntity $token){
        $this->token = $token->getToken();
        $this->dateCreate = $token->getDateCreate();
        $this->dateEnd = $token->getDateEnd();
        $this->type = $token->getType();
        $this->data = $token->getUnserializedData();
        $this->error = $token->getError();
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
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
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
     * Get data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function getError()
    {
        return $this->error;
    }

}