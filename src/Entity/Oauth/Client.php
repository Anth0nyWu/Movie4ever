<?php
// src/Entity/Oauth/Client.php

namespace App\Entity\Oauth;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Client
 */
class Client extends BaseClient
{
    /**
     * @var int
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}