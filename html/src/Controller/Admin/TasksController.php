<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AdminController;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 * @method \App\Model\Entity\Task[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TasksController extends AdminController
{
    public $paginate = ['sortableFields' => ['id', 'title', 'content', 'count']];
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $tasks = $this->Tasks->find('withLikeCount', [])->find('search', ['search' => $this->request->getQueryParams()]);
        $tasks = $this->paginate($tasks);
        
        $this->set(compact('tasks'));
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['Likes' => ['Users'], 'Users'],
        ]);
        $this->set(compact('task'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $task = $this->Tasks->newEmptyEntity();
        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(sprintf(__d('validation', 'successAdd'), 'タスク'));

                return $this->redirect(['action' => 'index']);
            }
            $errorMsg = sprintf(__d('validation', 'failedAdd'), 'タスク') ."\n". $this->flatten($task->getErrors());
            $this->Flash->error($errorMsg);
        }
        $this->set(compact('task'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['Likes' => ['Users']],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(sprintf(__d('validation', 'successEdit'), 'タスク'));

                return $this->redirect(['action' => 'index']);
            }
            $errorMsg = sprintf(__d('validation', 'failedEdit'), 'タスク') ."\n". $this->flatten($task->getErrors());
            $this->Flash->error($errorMsg);
        }
        
        $users = $this->Tasks->Users->find('list', [
            'valueField' => function ($users) {
                return 'ID'.$users->id.': '.$users->username;
            }
        ])->toArray();
        
        $this->set(compact('task', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->get($id);
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(sprintf(__d('validation', 'successDelete'), 'タスク'));
        } else {
            $errorMsg = sprintf(__d('validation', 'failedDelete'), 'タスク') ."\n". $this->flatten($task->getErrors());
            $this->Flash->error($errorMsg);
        }

        return $this->redirect(['action' => 'index']);
    }
}
