<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\View\AjaxView;
use Cake\Http\Exception\NotFoundException;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 * @method \App\Model\Entity\Task[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TasksController extends AppController
{
    
    // 現状、縦幅が大きい場合に追加で読み込みができない(ダウンスクロールを読み込みのトリガーにしているため)
    public $paginate = ['limit' => 5, 'finder' => ['withLikeCount' => []]];
    
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // ログインページは認証しなくてもアクセスできる
        $this->Authentication->addUnauthenticatedActions(['login', 'index', 'loadTask']);
        $this->loadComponent('Paginator');
        $this->view = new AjaxView();
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $tasks = $this->paginate($this->Tasks);
        $mytasks = [];
        if (!empty($this->request->getAttribute('identity')->id)) {
            $finderOption = ['withLikeCount' => ['user_id' => $this->request->getAttribute('identity')->id]];
            $mytasks = $this->paginate($this->Tasks, ['finder' => $finderOption]);
        }
        $this->set(compact('tasks', 'mytasks'));
    }

    /**
     * ajaxDelete
     */
    public function delete()
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->autoRender = false;
        
        $success = $this->_deleteProcess($this->request->getData());

        $this->response = $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(['success' => $success]));

        return $this->response;
    }
    
    private function _deleteProcess($data)
    {
        if (empty($this->request->getAttribute('identity')->id)) {
            $this->log('未ログインのため削除できません');
            return false;
        }
        if (empty($data['id'])) {
            $this->log('idが指定されていないため削除できません');
            return false;
        }

        $task = $this->Tasks->get($data['id']);
        if (empty($task)) {
            return false;
        }

        if ($task->user_id!=$this->request->getAttribute('identity')->id) {
            $this->log(sprintf('他者タスクの削除を検知 タスクID: %s ユーザーID: %s', $data['id'], $this->request->getAttribute('identity')->id));
            return false;
        }
        
        return $this->Tasks->delete($task);
    }
    
    /**
     * ajaxSave
     */
    public function save()
    {
        $this->autoRender = false;
        parse_str($this->request->getData()['data'], $data);
        
        $isLoggedIn = !empty($this->request->getAttribute('identity')->id);
        $isNew = empty($data['id']);
        $content = '';
        if ($isLoggedIn) {
            $entity = $isNew ? $this->Tasks->newEmptyEntity() : $this->Tasks->get($data['id']);
            $entity->user_id = $this->request->getAttribute('identity')->id;
            $entity = $this->Tasks->patchEntity($entity, $data);
            $success = $this->Tasks->save($entity);
            // 新規タスクの保存に成功
            if ($success && $isNew) {
                $entity->count = 0;
                $content = $this->view->element('tasks/card', array('row' => $entity));
            }
        }
        
        $this->response = $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(['entity' => $entity, 'errors' => $entity->getErrors(), 'isNew' => $isNew, 'content' => $content]));

        return $this->response;
    }

    /**
     * ajaxViewCreate
     * タスクを取得する
     */
    public function loadTask()
    {
        $this->autoRender = false;
        
        $content = $this->_getTaskBlockView([]);
        
        $this->response = $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($content));

        return $this->response;
    }

    /**
     * ajaxViewCreate
     * 自分のタスクを取得する
     */
    public function loadMyTask()
    {
        $this->autoRender = false;
        
        $content = '';
        if (!empty($this->request->getAttribute('identity')->id)) {
            $option = ['finder' => ['withLikeCount' => ['user_id' => $this->request->getAttribute('identity')->id]]];
            $content = $this->_getTaskBlockView($option);
        }
        
        $this->response = $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($content));

        return $this->response;
    }
    
    /**
     * ajaxViewCreate
     * タスクリストのHTMLを生成して返す
     * 取得件数は$paginateのlimitに依存
     */
    private function _getTaskBlockView($option = [])
    {
        $content = '';
        $settings = ['page' => $this->request->getQuery('page')];
        if (!empty($option)) {
            $settings += $option;
        }
        
        try {
            $tasks = $this->paginate($this->Tasks, $settings);
            foreach ($tasks as $row) {
                $content .= $this->view->element('tasks/card', array('row' => $row));
            }
        } catch (NotFoundException $e) {
            // $this->log('Pagination Out of Range');
        }
        
        return $content;
    }
    
}
