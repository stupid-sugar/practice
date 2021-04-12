<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
?>
<div class="row" style="flex-direction: column">
    <div class="column action">
        <div class="action">
            <?= $this->Html->link(__('一覧に戻る'), ['action' => 'index'], ['class' => 'button']) ?>
        </div>
    </div>
    <div class="column-responsive">
        <div class="tasks view content">
            <h3>タスク</h3>
            <table>
                <tr>
                    <th><?= __('所有者') ?></th>
                    <td><?= $this->Html->link(__($task->user->username), ['controller' => 'Users', 'action' => 'edit', $task->user_id]) ?></td>
                </tr>
                <tr>
                    <th><?= __('タイトル') ?></th>
                    <td><?= $this->Html->link(__($task->title), ['controller' => 'Tasks', 'action' => 'edit', $task->id]) ?></td>
                </tr>
                <tr>
                    <th><?= __('内容') ?></th>
                    <td><?= h($task->content) ?></td>
                </tr>
            </table>
            <?= $this->element('admin/likesView', ['data' => $task]) ?>
            </div>
        </div>
    </div>
</div>
