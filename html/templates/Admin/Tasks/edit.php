<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
?>

<?= $this->Form->create($task) ?>
<div class="row" style="flex-direction: column">
    <div class="column action">
        <div class="action">
            <?= $this->Html->link(__('一覧に戻る'), ['action' => 'index'], ['class' => 'button']) ?>
            <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $task->id], ['block' => true, 'confirm' => __('削除してよろしいですか'), 'class' => 'button']) ?>
            <?= $this->Form->button('保存', ['confirm' => __('編集を保存してよろしいですか')]) ?>
        </div>
    </div>
    <div class="column-responsive">
        <div class="tasks form content">
            <h3><?= 'タスクID: '.h($task->id) ?></h3>
            <td><?= $this->Form->control('id') ?></td>
            <table>
                <tr>
                    <th><?= __('所有者') ?></th>
                    <td><?= $this->Form->control('user_id', ['label' => false, 'option' => $users]) ?></td>
                </tr>
                <tr>
                    <th><?= __('タイトル') ?></th>
                    <td><?= $this->Form->control('title', ['label' => false]) ?></td>
                </tr>
                <tr>
                    <th><?= __('内容') ?></th>
                    <td><?= $this->Form->control('content', ['label' => false]) ?></td>
                </tr>
            </table>
            <?= $this->element('admin/likesView', ['data' => $task]) ?>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>
<!-- solve nested form -->
<?= $this->fetch('postLink') ?>