<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="users index content">
    <!-- 検索フォーム -->
    <?= $this->Form->create(null, ['valueSources' => 'query']); ?>
    <div class="table-responsive search">
        <table>
            <tbody>
                <tr>
                    <td>ユーザー名</td>
                    <td><?= $this->Form->control('username', ['label' => false]); ?></td>
                </tr>
                <tr>
                    <td>役職</td>
                    <td><?= $this->Form->control('role', ['label' => false, 'option' => $roles, 'empty' => true]); ?></td>
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
    
    <?= $this->Html->link(__('ユーザーの追加'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('username', 'ユーザー名') ?></th>
                    <th><?= $this->Paginator->sort('role_id', '役職') ?></th>
                    <th><?= $this->Paginator->sort('created', '登録日') ?></th>
                    <th><?= $this->Paginator->sort('modified', '更新日') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->username) ?></td>
                    <td><?= h($user->role->name) ?></td>
                    <td><?= h($user->created) ?></td>
                    <td><?= h($user->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('編集'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $user->id], ['confirm' => __('削除してよろしいですか # {0}?', $user->id)]) ?>
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
