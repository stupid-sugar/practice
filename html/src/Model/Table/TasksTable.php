<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tasks Model
 *
 * @method \App\Model\Entity\Task newEmptyEntity()
 * @method \App\Model\Entity\Task newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Task[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Task get($primaryKey, $options = [])
 * @method \App\Model\Entity\Task findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Task patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Task[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Task|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Task saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Task[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Task[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Task[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Task[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TasksTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('tasks');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
        
        $this->hasMany('Likes', [
            'foreignKey' => 'task_id',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);

        $this->addBehavior('Search.Search');
        // Setup search filter using search manager
        $this->searchManager()
            ->add('username', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fields' => [$this->Users->aliasField('username')]
            ])
            ->add('count_from', 'Search.Callback', [
                'fields' => ['count'],
                'callback' => function ($query, $args, $filter) {
                    $query->having(['count >=' => $args['count_from']]);
                },
            ])
            ->add('count_to', 'Search.Callback', [
                    'fields' => ['count'],
                    'callback' => function ($query, $args, $filter) {
                        $query->having(['count <=' => $args['count_to']]);
                    },
            ])
            ->add('created_from', 'Search.Compare', [
                    'operator' => '>=',
                    'fields' => ['created']
            ])
            ->add('created_to', 'Search.Compare', [
                    'operator' => '<=',
                    'fields' => ['created']
            ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 20, sprintf(__d('validation', 'length'), '20'))
            ->allowEmptyString('title');

        $validator
            ->scalar('content')
            ->maxLength('content', 500, sprintf(__d('validation', 'length'), '500'))
            ->allowEmptyString('content');

        return $validator;
    }
    
    public function findWithLikeCount(Query $query, array $options)
    {
        // ユーザーが保有するものに絞って取得
        if (!empty($options['user_id'])) {
            $query = $query->where(['Tasks.user_id' => $options['user_id']]);
        }

        $query = $query
            ->contain(['Users'])
            ->select($this)
            ->select($this->Users)
            ->select(['count' => $query->func()->count('Likes.task_id')])
            ->leftJoinWith('Likes')
            ->group(['Tasks.id']);

        return $query;
    }
}
