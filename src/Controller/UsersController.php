<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        // These pages must work without being logged in.
        $this->Authentication->allowUnauthenticated(['login', 'register']);
    }

    public function login()
    {
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            $target = $this->Authentication->getLoginRedirect()
                ?? ['controller' => 'Resumes', 'action' => 'index'];
            return $this->redirect($target);
        }

        if ($this->request->is('post')) {
            $this->Flash->error('Wrong email or password.');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['action' => 'login']);
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success('Account created. Please log in.');
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error('Could not create the account.');
        }

        $this->set(compact('user'));
    }
}