<section class="task wrap">
    <input type="hidden" class="todo_id" value=<?= $row->id ?>>
    <h2 class="todo_title"><?= $row->title ?></h2>
    <p class="todo_content"><?= $row->content ?></p>
    <?= $this->Form->create(null, ['class' => 'like_form', 'url' => ['controller' => 'Likes', 'action' => 'add']]); ?>
    <?= $this->Form->hidden('task_id', ['value' => $row->id]); ?>
    <div class="right"><?= $this->Form->button('イイネ ' . $row->count, ['class' => 'like']); ?></div>
    <?= $this->Form->end(); ?>
    <div class="user_info">
        <span>作成者: <?= $row->user->username ?>さん</span>
        <span>作成日: <?= $row->created ?></span>
    </div>
</section>