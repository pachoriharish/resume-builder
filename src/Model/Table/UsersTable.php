<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('users');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');                       // fills created/modified
        $this->hasMany('Resumes', ['foreignKey' => 'user_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        return $validator
            ->email('email')
            ->notEmptyString('email')
            ->add('email', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'This email is already registered',
            ])
            ->notEmptyString('password')
            ->minLength('password', 6);
    }
}