<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AdminController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AdminController
{   
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // ログインページは認証しなくてもアクセスできる
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // ログインした場合はリダイレクト
        if ($result->isValid()) {
            return $this->redirect('/admin');
        }
        // 認証失敗した場合はエラーを表示
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('ユーザー名かパスワードが正しくありません。');
        }
    }
 
    public function logout()
    {
        $result = $this->Authentication->getResult();
        // ログインした場合はリダイレクト
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $users = $this->Users->find('search', ['search' => $this->request->getQueryParams(), 'contain' => ['Roles']]);
        $users = $this->paginate($users);
        
        $this->set(compact('users'));
        $this->_setRoles();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(sprintf(__d('validation', 'successAdd'), 'ユーザー'));
                return $this->redirect(['action' => 'index']);
            }
            $errorMsg = sprintf(__d('validation', 'failedAdd'), 'ユーザー') ."\n". $this->flatten($user->getErrors());
            $this->Flash->error($errorMsg);
        }

        $this->set(compact('user'));
        $this->_setRoles();
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        
        $user = $this->Users->get($id, [
            'contain' => ['Tasks' => ['finder' => ['withLikeCount' => []]]],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(sprintf(__d('validation', 'successEdit'), 'ユーザー'));
            } else {
                $errorMsg = sprintf(__d('validation', 'failedEdit'), 'ユーザー') ."\n". $this->flatten($user->getErrors());
                $this->Flash->error($errorMsg);
            }
        }
        
        $this->set(compact('user'));
        $this->_setRoles();
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(sprintf(__d('validation', 'successDelete'), 'ユーザー'));
        } else {
            $errorMsg = sprintf(__d('validation', 'failedDelete'), 'ユーザー') ."\n". $this->flatten($user->getErrors());
            $this->Flash->error($errorMsg);
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * Roles一覧をセット
     */
    private function _setRoles()
    {
        $roles = $this->Users->Roles->find('list', [
            'valueField' => function ($roles) {
                return 'ID'.$roles->id.': '.$roles->name;
            }
        ])->toArray();

        $this->set(compact('roles'));        
    }
    
}
