<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Like[]|\Cake\Collection\CollectionInterface $likes
 */
?>
<div class="likes index content">
    <!-- 検索フォーム -->
    <?= $this->Form->create(null, ['valueSources' => 'query']); ?>
    <div class="table-responsive search">
        <table>
            <tbody>
                <tr>
                    <td>イイネを付けたユーザー名</td>
                    <td><?= $this->Form->control('username', ['label' => false]); ?></td>
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
    
    <?= $this->Html->link(__('イイネを追加する'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Likes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('task_id', 'イイネが付いたタスク') ?></th>
                    <th><?= $this->Paginator->sort('user_id', 'イイネを付けたユーザー') ?></th>
                    <th><?= $this->Paginator->sort('created', '作成日') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($likes as $like): ?>
                <tr>
                    <td><?= $this->Number->format($like->id) ?></td>
                    <td><?= $like->has('task') ? $this->Html->link($like->task->title, ['controller' => 'Tasks', 'action' => 'view', $like->task->id]) : '' ?></td>
                    <td><?= $like->has('user') ? $this->Html->link($like->user->username, ['controller' => 'Users', 'action' => 'edit', $like->user->id]) : '' ?></td>
                    <td><?= h($like->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('編集'), ['action' => 'edit', $like->id]) ?>
                        <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $like->id], ['confirm' => __('削除してよろしいですか # {0}?', $like->id)]) ?>
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
