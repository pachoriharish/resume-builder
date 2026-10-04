<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Resume extends Entity
{
    protected array $_accessible = [
        'template' => true, 'full_name' => true, 'email' => true,
        'phone' => true, 'address' => true, 'summary' => true, 'skills' => true,
        'experiences' => true, 'educations' => true,
        // user_id is NOT listed on purpose: the controller sets it from the login session.
    ];
}