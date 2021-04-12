<?php
namespace App\Controller\Admin;
 
use Cake\Controller\Controller;
use Cake\Core\Configure;

class AdminController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
 
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Search.Search', ['actions' => ['index']]);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        $isLoggedIn = !empty($this->request->getAttribute('identity'));
        if ($isLoggedIn) {
            $this->_checkAuth();
        }
    }

    public function flatten(array $array) {
        $msg = '';
        array_walk_recursive($array, function($a) use (&$msg) { $msg = $a; });
        return $msg;
    }

    /**
     * ユーザーの権限を確認
     * ログイン中の情報変更を考慮に入れる
     */
    private function _checkAuth()
    {
        $user = $this->Users->find()->where(['id' => $this->request->getAttribute('identity')->id])->first();
        
        if(empty($user)) {
            $this->Flash->error(sprintf(__d('validation', 'exist'), 'ユーザー'));
            return $this->redirect('/');
        }

        if($user->role_id != Configure::read('role_admin')) {
            $this->Flash->error(sprintf(__d('validation', 'exist'), '管理者権限'));
            return $this->redirect('/');
        }        
    }
    
}