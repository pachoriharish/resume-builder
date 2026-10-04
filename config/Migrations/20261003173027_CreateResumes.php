<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateResumes extends BaseMigration
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
    $this->table('resumes')
        ->addColumn('user_id', 'integer', ['null' => false])         // which user owns this resume
        ->addColumn('template', 'string', ['limit' => 20, 'default' => 'classic']) // chosen PDF design
        ->addColumn('full_name', 'string', ['limit' => 150, 'null' => false])
        ->addColumn('email', 'string', ['limit' => 191, 'null' => false])
        ->addColumn('phone', 'string', ['limit' => 50, 'null' => true])       // optional fields allow NULL
        ->addColumn('address', 'string', ['limit' => 255, 'null' => true])
        ->addColumn('summary', 'text', ['null' => true])             // "text" = long text
        ->addColumn('skills', 'text', ['null' => true])
        ->addColumn('created', 'datetime', ['null' => true])
        ->addColumn('modified', 'datetime', ['null' => true])
        ->addIndex(['user_id'])                                      // speeds up "show my resumes"
        ->create();
}
}
