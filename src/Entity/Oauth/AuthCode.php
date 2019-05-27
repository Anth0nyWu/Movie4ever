<?php
// src/Entity/Oauth/AuthCode.php

namespace App\Entity\Oauth;

use FOS\OAuthServerBundle\Entity\AuthCode as BaseAuthCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 */
class AuthCode extends BaseAuthCode
{
    /**
     * @var int
     */
    protected $id;

    /**
     *
     */
    protected $client;

    /**
     *
     */
    protected $user;
}