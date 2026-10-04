<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class EducationsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('educations');
        $this->setPrimaryKey('id');
        $this->belongsTo('Resumes', ['foreignKey' => 'resume_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        return $validator->notEmptyString('school');
    }
}