<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Likes Controller
 *
 * @property \App\Model\Table\LikesTable $Likes
 * @method \App\Model\Entity\Like[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LikesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tasks', 'Users'],
        ];
        $likes = $this->paginate($this->Likes);

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
        $this->autoRender = false;
        parse_str($this->request->getData()['data'], $data);
        
        $like = $this->Likes->newEmptyEntity();
        if ($this->request->is('post') && !empty($this->request->getAttribute('identity')->id)) {
            $like->user_id = $this->request->getAttribute('identity')->id;
            $like = $this->Likes->patchEntity($like, $data);
            $success = $this->Likes->save($like);
        }
        
        // 既にレコードが存在している場合、いいねを取り消す
        $errors = $like->getErrors();
        if (!empty($errors['id']['_isUnique'])) {
            $likes = $this->Likes->find()->where(['task_id' => $data['task_id'], 'user_id' => $this->request->getAttribute('identity')->id]);
            foreach ($likes->all() as $row) {
                $success = $this->delete($row->id);
            }
        }
        
        // 今のイイネ数を集計
        $likeCnt = $this->Likes->find()->where(['task_id' => $data['task_id']])->count();
        $this->response = $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(['success' => $success, 'likeCnt' => $likeCnt]));

        return $this->response;

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
                $this->Flash->success(__('The like has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The like could not be saved. Please, try again.'));
        }
        $tasks = $this->Likes->Tasks->find('list', ['limit' => 200]);
        $users = $this->Likes->Users->find('list', ['limit' => 200]);
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
        return $this->Likes->delete($like);
    }
    
}
