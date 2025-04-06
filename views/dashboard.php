<?php 
    $in_progress_task = $_SESSION['in_progress_tasks'];
    $complete_task = $_SESSION['complete_tasks'];
    $deadline_task = $_SESSION['deadline_tasks'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="/css/base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/base.js"></script>
</head>
<header>
    <div class="menu">
        <a class="menuButton " href="http://localhost:8000/todos">Список дел</a>
        <a class="menuButton active" href="/dashboard">Доска задач</a>
        <a class="menuButton" href="http://localhost:8000/profile">Мой профиль</a>
    </div>
</header>
<body>
    <? if($in_progress_task): ?>
        <div class="task-container">
            <div class="inProgress">
                <p>В работе</p>
                <?foreach($in_progress_task as $task):?>
                    <div class="task blue" style="width: 60%;" id="task<?php echo($task['id'])?>">
                        <p>ID задачи: <?php echo($task['id'])?></p>
                        <p>Название задачи: <?php echo($task['title'])?></p>
                        <button class="btn btn-warning" onclick="openTask(<?php echo($task['id']);?>)">подробнее</button>
                    </div>

                    <!--Всплывающее окно с полной информацией о задаче -->
                    <div class="task-popup-container no-display" id="task-popup<?php echo($task['id']);?>">
                        <div class="task-pop blue">
                            <p>ID задачи: <?php echo($task['id'])?></p>
                            <p>Название задачи: <?php echo($task['title'])?></p>
                            <p>Описание задачи: <?php echo($task['description'])?></p>
                            <p>Задача создана: <?php echo($task['created_at'])?>
                            <button class="btn btn-success" onclick="closeTask(<?php echo($task['id']);?>)">Закрыть</button>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
            <div class="complete">
            <p>Завершено</p>
                <?foreach($complete_task as $task):?>
                    <div class="task green" style="width: 70%;" id="task<?php echo($task['id'])?>">
                        <p>ID задачи: <?php echo($task['id'])?></p>
                        <p>Название задачи: <?php echo($task['title'])?></p>
                        <button class="btn btn-warning" onclick="openTask(<?php echo($task['id']);?>)">подробнее</button>
                    </div>

                    <!--Всплывающее окно с полной информацией о задаче -->
                    <div class="task-popup-container no-display" id="task-popup<?php echo($task['id']);?>">
                        <div class="task-pop green">
                            <p>ID задачи: <?php echo($task['id'])?></p>
                            <p>Название задачи: <?php echo($task['title'])?></p>
                            <p>Описание задачи: <?php echo($task['description'])?></p>
                            <p>Задача создана: <?php echo($task['created_at'])?>
                            <button class="btn btn-success" onclick="closeTask(<?php echo($task['id']);?>)">Закрыть</button>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
            <div class="deadline">
            <p>Дедлайн</p>
                <?foreach($deadline_task as $task):?>
                    <div class="task red" style="width: 70%;" id="task<?php echo($task['id'])?>">
                        <p>ID задачи: <?php echo($task['id'])?></p>
                        <p>Название задачи: <?php echo($task['title'])?></p>
                        <button class="btn btn-warning" onclick="openTask(<?php echo($task['id']);?>)">подробнее</button>
                    </div>

                    <!--Всплывающее окно с полной информацией о задаче -->
                    <div class="task-popup-container no-display" id="task-popup<?php echo($task['id']);?>">
                        <div class="task-pop red">
                            <p>ID задачи: <?php echo($task['id'])?></p>
                            <p>Название задачи: <?php echo($task['title'])?></p>
                            <p>Описание задачи: <?php echo($task['description'])?></p>
                            <p>Задача создана: <?php echo($task['created_at'])?>
                            <button class="btn btn-success" onclick="closeTask(<?php echo($task['id']);?>)">Закрыть</button>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    <? else: ?>
        <h1>У вас пока нет задач, создайте их на странице с задачами чтобы они появились здесь</h1>
    <? endif; ?>
</body>
<footer>
    
</footer>
</html>