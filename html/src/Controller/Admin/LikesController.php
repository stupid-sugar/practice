<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AdminController;

/**
 * Likes Controller
 *
 * @property \App\Model\Table\LikesTable $Likes
 * @method \App\Model\Entity\Like[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LikesController extends AdminController
{
    public $paginate = ['contain' => ['Tasks', 'Users']];
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $likes = $this->Likes->find('search', ['search' => $this->request->getQueryParams()]);
        $likes = $this->paginate($likes);

        $this->set(compact('likes'));
    }

    /**
     * View method
     *
     * @param string|null $id Like id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $like = $this->Likes->get($id, [
            'contain' => ['Tasks', 'Users'],
        ]);

        $this->set(compact('like'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $like = $this->Likes->newEmptyEntity();
        if ($this->request->is('post')) {
            $like = $this->Likes->patchEntity($like, $this->request->getData());
            if ($this->Likes->save($like)) {
                $this->Flash->success(sprintf(__d('validation', 'successAdd'), 'イイネ'));

                return $this->redirect(['action' => 'index']);
            }
            $errorMsg = sprintf(__d('validation', 'failedAdd'), 'イイネ') ."\n". $this->flatten($like->getErrors());
            $this->Flash->error($errorMsg);
        }
        
        // 数は膨れ上がるはずなので、直接入力が望ましいと思われる
        $tasks = $this->Likes->Tasks->find('list', [
            'limit' => 200, 
            'valueField' => function ($tasks) {
                return 'ID'.$tasks->id.': '.$tasks->title;
            }
        ])->toArray();
        
        $users = $this->Likes->Users->find('list', [
            'limit' => 200,
            'valueField' => function ($users) {
                return 'ID'.$users->id.': '.$users->username;
            }
        ])->toArray();
        
        $this->set(compact('like', 'tasks', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Like id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $like = $this->Likes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $like = $this->Likes->patchEntity($like, $this->request->getData());
            if ($this->Likes->save($like)) {
                $this->Flash->success(sprintf(__d('validation', 'successEdit'), 'イイネ'));

                return $this->redirect(['action' => 'edit', $id]);
            }
            $errorMsg = sprintf(__d('validation', 'failedEdit'), 'イイネ') ."\n". $this->flatten($like->getErrors());
            $this->Flash->error($errorMsg);
        }
        
        // 数は膨れ上がるはずなので、直接入力が望ましいと思われる
        $tasks = $this->Likes->Tasks->find('list', [
            'limit' => 200, 
            'valueField' => function ($tasks) {
                return 'ID'.$tasks->id.': '.$tasks->title;
            }
        ]);
        $users = $this->Likes->Users->find('list', [
            'limit' => 200,
            'valueField' => function ($users) {
                return 'ID'.$users->id.': '.$users->username;
            }
        ]);
        $this->set(compact('like', 'tasks', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Like id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $like = $this->Likes->get($id);
        if ($this->Likes->delete($like)) {
            $this->Flash->success(sprintf(__d('validation', 'successDelete'), 'イイネ'));
        } else {
            $errorMsg = sprintf(__d('validation', 'failedDelete'), 'イイネ') ."\n". $this->flatten($like->getErrors());
            $this->Flash->error($errorMsg);
        }

        return $this->redirect(['action' => 'index']);
    }
}
