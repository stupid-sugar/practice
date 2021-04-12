<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset=="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>ToDoApp</title>
    
    <link href="https://fonts.googleapis.com/css?family=Noto+sans+JP:400,700,900&display=swap&subset=japanese" rel="stylesheet">
    <link rel="stylesheet" href="css/tasks/tasks.css">
    <script type="text/javascript" src="js/tasks.js"></script>

</head>

<body>


<header class="header">
<div class="box">
  <div class="all_todo item">ToDo一覧</div>
  <div class="my_todo item">MyToDo一覧</div>
</div>
</header>


<!-- All ToDoブロック -->
<div class="wrap task_block all">
    <?php
        foreach ($tasks as $row) {
            echo $this->element('tasks/card', array('row' => $row));
        }
    ?>
</div>
<!---------------------->

<!-- My ToDoブロック -->
<div class="wrap task_block my" style="display: none">
    <?php
        foreach ($mytasks as $row) {
            echo $this->element('tasks/card', array('row' => $row));
        }
    ?>
</div>
<!---------------------->

<section>
    <div class="right">
        <a id="add_task" class="button button-outline">タスクを追加</a>
    </div>
</section>

<?= $this->element('modal/todo');?>

</body>
</html>