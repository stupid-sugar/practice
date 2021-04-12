<!-- Task has Many Likes -->
<div class="related">
    <h4><?= __('イイネ一覧') ?></h4>
    <div class="table-responsive">
        <table>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('イイネを付けたユーザー') ?></th>
                <th><?= __('作成日') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php if (!empty($data->likes)) : ?>
            <?php foreach ($data->likes as $likes) : ?>
            <tr>
                <td><?= h($likes->id) ?></td>
                <td><?= $this->Html->link(__($likes->user->username), ['controller' => 'Users', 'action' => 'edit', $likes->user_id]) ?></td>
                <td><?= h($likes->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('編集'), ['controller' => 'Likes', 'action' => 'edit', $likes->id]) ?>
                    <?= $this->Form->postLink(__('削除'), ['controller' => 'Likes', 'action' => 'delete', $likes->id], ['confirm' => __('削除してよろしいですか # {0}?', $likes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</div>