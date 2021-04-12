<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Like $like
 */
?>

<?= $this->Form->create($like) ?>
<div class="row" style="flex-direction: column">
    <div class="column action">
        <div class="action">
            <?= $this->Html->link(__('一覧に戻る'), ['action' => 'index'], ['class' => 'button']) ?>
            <?= $this->Form->button('保存', ['confirm' => __('追加してよろしいですか')]) ?>
        </div>
    </div>
    <div class="column-responsive">
        <div class="likes form content">
            <h4><?= __('イイネの追加') ?></h4>
            <td><?= $this->Form->control('id') ?></td>
            <table>
                <tr>
                    <th><?= __('イイネを付けるタスク') ?></th>
                    <td><?= $this->Form->control('task_id', ['options' => $tasks, 'label' => false, 'empty' => true]) ?></td>
                </tr>
                <tr>
                    <th><?= __('イイネを行うユーザー') ?></th>
                    <td><?= $this->Form->control('user_id', ['options' => $users, 'label' => false, 'empty' => true]) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?= $this->Form->end(); ?>