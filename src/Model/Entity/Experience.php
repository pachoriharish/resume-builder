<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Experience extends Entity
{
    protected array $_accessible = [
        'company' => true, 'job_title' => true,
        'start_date' => true, 'end_date' => true, 'description' => true,
    ];
}