<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Like $like
 */
?>

<?= $this->Form->create($like, ['url' => ['controller' => 'Likes', 'action' => 'edit', $like->id]]); ?>
<div class="row" style="flex-direction: column">
    <div class="column action">
        <div class="action">
            <?= $this->Html->link(__('一覧に戻る'), ['action' => 'index'], ['class' => 'button']) ?>
            <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $like->id], ['block' => true, 'confirm' => __('削除してよろしいですか'), 'class' => 'button']) ?>
            <?= $this->Form->button('保存', ['confirm' => __('編集を保存してよろしいですか')]) ?>
        </div>
    </div>
    <div class="column-responsive">
        <div class="likes form content">
            <h3><?= 'イイネID: '.h($like->id) ?></h3>
            <td><?= $this->Form->control('id') ?></td>
            <table>
                <tr>
                    <th><?= __('イイネが付いたタスク') ?></th>
                    <td><?= $this->Form->control('task_id', ['options' => $tasks, 'label' => false]) ?></td>
                </tr>
                <tr>
                    <th><?= __('イイネを付けたユーザー') ?></th>
                    <td><?= $this->Form->control('user_id', ['options' => $users, 'label' => false]) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?= $this->Form->end(); ?>
<!-- solve nested form -->
<?= $this->fetch('postLink');?>