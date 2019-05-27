<?php
// src/Entity/Oauth/AccessToken.php

namespace App\Entity\Oauth;

use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;
use Doctrine\ORM\Mapping as ORM;

/**
 */
class AccessToken extends BaseAccessToken
{
    /**
     */
    protected $id;

    /**
     */
    protected $client;

    /**
     */
    protected $user;
}