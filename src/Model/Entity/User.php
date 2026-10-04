<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{
    protected array $_accessible = ['email' => true, 'password' => true];
    protected array $_hidden = ['password'];

    // Runs whenever "password" is set: stores a hash, never plain text.
    protected function _setPassword(string $password): ?string
    {
        return strlen($password) > 0
            ? (new DefaultPasswordHasher())->hash($password)
            : null;
    }
}