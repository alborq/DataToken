<?php
namespace Alborq\DataTokenBundle\Service;

use Alborq\DataTokenBundle\Entity\DataTokenEntity;
use Alborq\DataTokenBundle\Lib\DataToken as token;
use Doctrine\ORM\EntityManager;

class DataTokenService {
    const ERR_NULL = "DataToken is a NULL value";
    const ERR_OUTDATED = "DataToken is outdated";
    const ERR_TYPE_MISMATCH = "DataToken isn't same type as request";

    /** @var  EntityManager */
    protected $em;

    /** @var  string */
    protected $error;

    /** @var \DateTime */
    protected $now;

    /** @var \Alborq\DataTokenBundle\Repository\DataTokenEntityRepository  */
    protected $repo;


    public function __construct($em){
        $this->em = $em;
        $this->repo = $this->em->getRepository('AlborqDataTokenBundle:DataTokenEntity');
        $this->now = new \DateTime();
    }

    public function get($tokenKey,$type){
        if(null === $tokenKey){
            return null;
        }

        if(40 !== strlen($tokenKey)){
            throw new \InvalidArgumentException("tokenKey is invalid");
        }

        $token = $this->getTokenByTokenKey($tokenKey);

        if(null === $token){
            return null;
        }

        if(false === $this->isValid($token,$type)){
            $token->setError($this->getLastError());
        }
        else {
            $token->setUnserializedData(
                $this->unSerialize(
                    stream_get_contents($token->getData())
                )
            );
        }

        return new token($token);
    }

    public function create($data, $type, \DateInterval $interval){
        $token = new DataTokenEntity();
        $token  ->setData($this->serialize($data))
                ->setUnserializedData($data)
                ->setType($type)
                ->addInterval($interval);

        $this->generateToken($token);
        $this->em->persist($token);
        $this->em->flush($token);
        return new token($token);
    }

    public function delete(token $token){

        $this->em->remove(
            $this->getTokenByTokenKey(
                $token->getToken()
            )
        );

        $this->em->flush();

    }

    public function isValid(DataTokenEntity $token = null,$type ){
        if(null === $token){
            $this->error = DataTokenService::ERR_NULL;
            return false;
        }

        if($token->getDateEnd() <= $this->now){
            $this->error = DataTokenService::ERR_OUTDATED;
            return false;
        }

        if($token->getType() !== $type){
            $this->error = DataTokenService::ERR_TYPE_MISMATCH;
            return false;
        }

        return true;
    }

    public function getLastError(){
        return $this->error;
    }

    private function getTokenByTokenKey($tokenKey){
        $token = $this->repo->findOneBy(array(
            'token' => $tokenKey
        ));
        return $token;
    }

    private function serialize($data){

        return serialize($data);
    }

    private function unSerialize($data){
        return unserialize($data);
    }

    private function generateToken(DataTokenEntity $token){
        $data = $token->getType()."#".
                $token->getDateCreate()->format("m.d.y").'#'.
                microtime();

        $token->setToken(sha1($data));
    }

    public function findOutdatedToken()
    {
        return $this->repo->findOutdatedToken();
    }

    public function countToken()
    {
        return $this->repo->countToken();
    }
} 
