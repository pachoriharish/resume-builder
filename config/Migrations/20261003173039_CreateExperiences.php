<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateExperiences extends BaseMigration
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
    $this->table('experiences')
        ->addColumn('resume_id', 'integer', ['null' => false])       // links the job to its resume
        ->addColumn('company', 'string', ['limit' => 150, 'null' => false])
        ->addColumn('job_title', 'string', ['limit' => 150, 'null' => true])
        ->addColumn('start_date', 'string', ['limit' => 30, 'null' => true])  // string so users can type "Jan 2020"
        ->addColumn('end_date', 'string', ['limit' => 30, 'null' => true])    // or "Present"
        ->addColumn('description', 'text', ['null' => true])
        ->addIndex(['resume_id'])
        ->create();
}
}
