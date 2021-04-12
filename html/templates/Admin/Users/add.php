<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?= $this->Form->create($user, ['url' => ['controller' => 'Users', 'action' => 'add']]); ?>

<div class="row" style="flex-direction: column">
    <div class="column action">
        <div class="action">
            <?= $this->Html->link(__('一覧に戻る'), ['action' => 'index'], ['class' => 'button']) ?>
            <?= $this->Form->button('保存', ['confirm' => __('ユーザーを追加してよろしいですか')]) ?>
        </div>
    </div>
    <div class="column-responsive">
        <div class="users add content">
            <h3>ユーザー追加</h3>
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
                    <td><?= $this->Form->control('role_id', ['label' => false]) ?></td>
                </tr>
            </table>
        </div>
    </div>    
</div>
<?= $this->Form->end(); ?>