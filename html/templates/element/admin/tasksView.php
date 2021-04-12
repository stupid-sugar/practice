<!-- User has Many Tasks -->
<div class="related">
    <h4><?= __('タスク一覧') ?></h4>
    <div class="table-responsive">
        <table>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('タイトル') ?></th>
                <th><?= __('イイネ数') ?></th>
                <th><?= __('作成日') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php if (!empty($data->tasks)) : ?>
            <?php foreach ($data->tasks as $tasks) : ?>
            <tr>
                <td><?= h($tasks->id) ?></td>
                <td><?= $this->Html->link(__($tasks->title), ['controller' => 'Tasks', 'action' => 'edit', $tasks->id]) ?></td>
                <td><?= h($tasks->count) ?></td>
                <td><?= h($tasks->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('編集'), ['controller' => 'Tasks', 'action' => 'edit', $tasks->id]) ?>
                    <?= $this->Form->postLink(__('削除'), ['controller' => 'Tasks', 'action' => 'delete', $tasks->id], ['confirm' => __('削除してよろしいですか # {0}?', $tasks->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</div>