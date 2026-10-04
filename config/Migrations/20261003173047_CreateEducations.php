<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateEducations extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/guides/writing-migrations/migration-methods.html#the-change-method
     *
     * @return void
     */
    public function change(): void
{
    $this->table('educations')
        ->addColumn('resume_id', 'integer', ['null' => false])
        ->addColumn('school', 'string', ['limit' => 150, 'null' => false])
        ->addColumn('degree', 'string', ['limit' => 150, 'null' => true])
        ->addColumn('start_year', 'string', ['limit' => 10, 'null' => true])
        ->addColumn('end_year', 'string', ['limit' => 10, 'null' => true])
        ->addIndex(['resume_id'])
        ->create();
}
}
