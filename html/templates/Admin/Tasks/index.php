<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task[]|\Cake\Collection\CollectionInterface $tasks
 */
?>
<div class="tasks index content">
    <!-- 検索フォーム -->
    <?= $this->Form->create(null, ['valueSources' => 'query']); ?>
    <?= $this->Form->hidden('finder', ['value' => 1]) ?>
    <div class="table-responsive search">
        <table>
            <tbody>
                <tr>
                    <td>ユーザー名</td>
                    <td><?= $this->Form->control('username', ['label' => false]); ?></td>
                </tr>
                <tr>
                    <td>イイネ数</td>
                    <td><?= $this->Form->control('count_from', ['label' => false]); ?></td>
                    <td>～</td>
                    <td><?= $this->Form->control('count_to', ['label' => false]); ?></td>
                </tr>
                <tr>
                    <td>登録日</td>
                    <td><?= $this->Form->dateTime('created_from', ['label' => false]); ?></td>
                    <td>～</td>
                    <td><?= $this->Form->dateTime('created_to', ['label' => false]); ?></td>
                </tr>
                <tr>
                    <td><?= $this->Form->button('検索', ['type' => 'submit']); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?= $this->Form->end(); ?>
    
    <?= $this->Html->link(__('タスクを追加する'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tasks') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th>ユーザー名</th>
                    <th><?= $this->Paginator->sort('title', 'タイトル') ?></th>
                    <th><?= $this->Paginator->sort('content', '内容') ?></th>
                    <th><?= $this->Paginator->sort('count', 'イイネ数') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= $this->Number->format($task->id) ?></td>
                    <td><?= $this->Html->link(__($task->user->username), ['controller' => 'Users', 'action' => 'edit', $task->user_id]) ?></td>
                    <td><?= h($task->title) ?></td>
                    <td class="break_all"><?= h($task->content) ?></td>
                    <td><?= $this->Number->format($task->count) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('編集'), ['action' => 'edit', $task->id]) ?>
                        <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $task->id], ['confirm' => __('削除してよろしいですか # {0}?', $task->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
