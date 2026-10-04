<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ResumesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('resumes');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', ['foreignKey' => 'user_id']);
        $this->hasMany('Experiences', ['foreignKey' => 'resume_id', 'dependent' => true]);
        $this->hasMany('Educations', ['foreignKey' => 'resume_id', 'dependent' => true]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        return $validator
            ->notEmptyString('full_name', 'Please enter your name')
            ->notEmptyString('email', 'Please enter your email')
            ->email('email', false, 'Please enter a valid email')
            ->inList('template', ['classic', 'modern', 'minimal'], 'Unknown design');
    }
}