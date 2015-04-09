<?php
/**
 * Created by PhpStorm.
 * User: i74375
 * Date: 07/04/2015
 * Time: 13:23
 */

namespace Alborq\DataTokenBundle\Request\ParamConverter;


use Alborq\DataTokenBundle\Service\DataTokenService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DataTokenConverter implements ParamConverterInterface{

    protected $dataTokenService;

    public function __construct(DataTokenService $dataTokenService){
        $this->dataTokenService = $dataTokenService;
    }
    /**
     * Stores the object in the request.
     *
     * @param Request $request The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        if(false === isset($configuration->getOptions()['url_param'])){
            throw new ParameterNotFoundException('url_param is not define for a paramConverter');
        }

        if(false === isset($configuration->getOptions()['type'])){
            throw new ParameterNotFoundException('type is not define for a paramConverter');
        }

        $url_param = $configuration->getOptions()['url_param'];
        $type = $configuration->getOptions()['type'];

        if(false === $tokenKey = $request->attributes->get($url_param, false)){
            throw new ParameterNotFoundException('url_param is not valide, no parameter with this name');
        }

        try{
            $token = $this->dataTokenService->get($tokenKey,$type);
        }
        catch(\InvalidArgumentException $e){
            throw new NotFoundHttpException($e->getMessage());
        }

        if(false === $configuration->isOptional() AND false !== $token->getError()) {
            throw new NotFoundHttpException($token->getError());
        }

        $request->attributes->set($configuration->getName(), $token);

        return true;
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return ("Alborq\\DataTokenBundle\\Lib\\DataToken" === $configuration->getClass());
    }
}