<?php
// src/Entity/Oauth/RefreshToken.php

namespace App\Entity\Oauth;

use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;
use Doctrine\ORM\Mapping as ORM;

/**
 */
class RefreshToken extends BaseRefreshToken
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