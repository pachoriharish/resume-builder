<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Education extends Entity
{
    protected array $_accessible = [
        'school' => true, 'degree' => true, 'start_year' => true, 'end_year' => true,
    ];
}