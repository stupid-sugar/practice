<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?= $this->Form->create($user, ['url' => ['controller' => 'Users', 'action' => 'edit', $user->id]]); ?>

<div class="row" style="flex-direction: column">
    <div class="column action">
        <div class="action">
            <?= $this->Html->link(__('一覧に戻る'), ['action' => 'index'], ['class' => 'button']) ?>
            <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $user->id], ['block' => true, 'confirm' => __('削除してよろしいですか'), 'class' => 'button']) ?>
            <?= $this->Form->button('保存', ['confirm' => __('編集を保存してよろしいですか')]) ?>
        </div>
    </div>
    <div class="column-responsive">
        <div class="users view content">
            <h3><?= 'ユーザーID: '.h($user->id) ?></h3>
            <td><?= $this->Form->control('id') ?></td>
            <table>
                <tr>
                    <th><?= __('Username') ?></th>
                    <td><?= $this->Form->control('username', ['label' => false]) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password') ?></th>
                    <td><?= $this->Form->control('password', ['label' => false]) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= $this->Form->control('role_id', ['label' => false, 'option' => $roles]) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= $this->Form->control('created', ['label' => false]) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= $this->Form->control('modified', ['label' => false]) ?></td>
                </tr>
            </table>
            <?= $this->element('admin/tasksView', ['data' => $user]) ?>
        </div>
    </div>    
</div>
<?= $this->Form->end(); ?>
<!-- solve nested form -->
<?= $this->fetch('postLink') ?>