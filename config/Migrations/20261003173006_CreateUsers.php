<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateUsers extends BaseMigration
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
    $this->table('users')                                            // work on a table named "users"
        ->addColumn('email', 'string', ['limit' => 191, 'null' => false])     // 191 keeps the unique index safe on older MySQL
        ->addColumn('password', 'string', ['limit' => 255, 'null' => false])  // 255 because hashes are long
        ->addColumn('created', 'datetime', ['null' => true])         // CakePHP fills these two automatically
        ->addColumn('modified', 'datetime', ['null' => true])
        ->addIndex(['email'], ['unique' => true])                    // no two users can share an email
        ->create();                                                  // actually build the table
}
}
