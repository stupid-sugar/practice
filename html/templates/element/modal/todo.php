<?php
    $isLoggedIn = !empty($this->request->getAttribute('identity')->id);
?>
<!-- ToDo Modal -->
<div id="task_modal" class="modal">
    <p class="msg">To Do</p>
    <?= $this->Form->create(null, ['id' => 'modal_task_form']); ?>
    <?= $this->Form->hidden('id'); ?>
    <?= $this->Form->control('title', ['label' => false, 'placeholder' => 'Title', 'readonly' => !$isLoggedIn]); ?>
    <?= $this->Form->textarea('content', ['id' => 'content', 'placeholder' => 'Content', 'readonly' => !$isLoggedIn]); ?>
    <?php if($isLoggedIn):?>
        <div class="right">
            <?= $this->Form->button('削除', ['class' => 'delete']); ?>
            <?= $this->Form->button('保存', ['class' => 'save']); ?>
        </div>
    <?php endif;?>
    <?= $this->Form->end(); ?>
</div>