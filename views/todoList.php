<?php 
    error_reporting(E_ALL | ~E_NOTICE | ~E_WARNING | ~E_NOTICE);
    session_start();
    $user = $_SESSION['user']; 
?>
<?php $task = $_SESSION['tasks']; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="/css/base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<header>
    <div class="menu">
        <a class="menuButton active" href="/todos">Список дел</a>
        <a class="menuItem" href="/dashboard">Доска задач</a>
        <a class="menuButton" href="/profile">Мой профиль</a>
    </div>
</header>
<body>
    <?php if($task):?> 
        <p>Список задач<p>
        <form class="createTaskForm" method="post" action="/create-task">
            <p>создайте новую задачу!<p>
            <input type="number" value="<?php echo($user['id']);?>" name="id" id="id" hidden/>
            <div class="mb-3 d-flex flex-column">
                <p>Название</p>
                <input type="text" name="title" id="title" placeholder="Название задачи"/>
                <?php if (!empty($errors['title'])): ?>
                    <div class="error"><?= implode('<br>', $errors['title']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 d-flex flex-column">
                <p>Описание</p>
                <input type="text" name="description" id="description" placeholder="Описание задачи"/>
                <?php if (!empty($errors['description'])): ?>
                    <div class="error"><?= implode('<br>', $errors['description']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 d-flex flex-column">
                <select id="status" name="status">
                    <option value="">--Выберите статус задачи--</option>
                    <option value="В работе">В работе</option>
                    <option value="Завершено">Завершено</option>
                    <option value="Дедлайн">Дедлайн</option>
                </select>
                <?php if (!empty($errors['status'])): ?>
                    <div class="error"><?= implode('<br>', $errors['status']) ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-success mt-5">Создать</button>
        </form>
        <form class="sortForms" method="post" action="/sort-by-status">
            <p>Отфильтровать по статусу:</p>
            <select id="status" name="status">
                    <option value="in_progress">В работе</option>
                    <option value="complete">Завершено</option>
                    <option value="deadline">Дедлайн</option>
            </select>
            <button type="submit" class="btn btn-success">Отфильтровать</button>
        </form>
        <form class="sortForms" method="post" action="/sort-by-data">
            <p>сортировка по дате:</p>
            <select id="date" name="date">
                    <option value="newer">сначала новые</option>
                    <option value="older">сначала старые</option>
            </select>
            <button type="submit" class="btn btn-success">сортировать</button>
        </form>
        <? if(count($task) > 1):?>
            <?php foreach($task as $taskItem): ?>
                <?php switch($taskItem['status']){
                    case 'В работе': 
                        $color = 'blue';
                        break;
                    case 'Завершено':
                        $color = 'green';
                        break;
                    case 'Дедлайн':
                        $color = "red";
                        break;
                    default:
                        $color = 'gray';
                        break;
                }?>
                <div class="task <?echo($color);?>">
                    <p>ID задачи: <?php echo($taskItem['id'])?></p>
                    <p>Название задачи: <?php echo($taskItem['title'])?></p>
                    <p>Описание задачи: <?php echo($taskItem['description'])?></p>
                    <p>Статус задачи: <?php echo($taskItem['status'])?></p>
                    <button class="btn btn-warning" onclick="showForm(<?php echo($taskItem['id']);?>)">Редактировать</button>
                    <form class="delete-task" action="/delete-task" method="post">
                        <input type="number" value="<?php echo($taskItem['id']);?>" id="id" name="id" hidden/>
                        <input type="number" value="<?php echo($user['id']);?>" name="user_id" id="user_id" hidden/>
                        <button class="btn btn-danger" style="margin-top: 10px;">Удалить задачу</button>
                    </form>
                    <form class="updateTaskForm no-display" id="updateTaskForm<?php echo($taskItem['id']);?>" method="post" action="/update-task">
                        <input type="number" value="<?php echo($taskItem['id']);?>" name="id" id="id" hidden/>
                        <input type="number" value="<?php echo($user['id']);?>" name="user_id" id="user_id" hidden/>
                        <div class="mb-3 d-flex flex-column">
                            <p>Название</p>
                            <input type="text" name="title" id="title" placeholder="Название задачи" value="<?php echo($taskItem['title']);?>"/>
                            <?php if (!empty($errors['title'])): ?>
                                <div class="error"><?= implode('<br>', $errors['title']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 d-flex flex-column">
                            <p>Описание</p>
                            <input type="text" name="description" id="description" placeholder="Описание задачи" value="<?php echo($taskItem['description']);?>"/>
                            <?php if (!empty($errors['description'])): ?>
                                <div class="error"><?= implode('<br>', $errors['description']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 d-flex flex-column">
                            <select id="status" name="status">
                                <option value="">--Выберите статус задачи--</option>
                                <option value="В работе">В работе</option>
                                <option value="Завершено">Завершено</option>
                                <option value="Дедлайн">Дедлайн</option>
                            </select>
                            <?php if (!empty($errors['status'])): ?>
                                <div class="error"><?= implode('<br>', $errors['status']) ?></div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Редактировать</button>
                        <a class="btn btn-warning" style="margin-top: 10px;" onclick="hideForm(<?php echo($taskItem['id']);?>)">отмена</a>
                    </form>
                </div>
            <? endforeach;?>
        <? else: ?>
            <?php switch($task[0]['status']){
                case 'В работе': 
                    $color = 'blue';
                    break;
                case 'Завершено':
                    $color = 'green';
                    break;
                case 'Дедлайн':
                    $color = "red";
                    break;
                default:
                    $color = 'gray';
                    break;
            }?>
            <div class="task <?echo($color);?>">
                <p>ID задачи: <?php echo($task[0]['id'])?></p>
                <p>Название задачи: <?php echo($task[0]['title'])?></p>
                <p>Описание задачи: <?php echo($task[0]['description'])?></p>
                <p>Статус задачи: <?php echo($task[0]['status'])?></p>
                <button class="btn btn-warning" onclick="showForm(<?php echo($task[0]['id']);?>)">Редактировать</button>
                <form class="delete-task" action="/delete-task" method="post">
                    <input type="number" value="<?php echo($task[0]['id']);?>" id="id" name="id" hidden/>
                    <input type="number" value="<?php echo($user['id']);?>" name="user_id" id="user_id" hidden/>
                    <button class="btn btn-danger" style="margin-top: 10px;">Удалить задачу</button>
                </form>
                <form class="updateTaskForm no-display" id="updateTaskForm<?php echo($task[0]['id']);?>" method="post" action="/update-task">
                        <input type="number" value="<?php echo($task[0]['id']);?>" name="id" id="id" hidden/>
                        <input type="number" value="<?php echo($user['id']);?>" name="user_id" id="user_id" hidden/>
                        <div class="mb-3 d-flex flex-column">
                            <p>Название</p>
                            <input type="text" name="title" id="title" placeholder="Название задачи" value="<?php echo($task[0]['title']);?>"/>
                            <?php if (!empty($errors['title'])): ?>
                                <div class="error"><?= implode('<br>', $errors['title']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 d-flex flex-column">
                            <p>Описание</p>
                            <input type="text" name="description" id="description" placeholder="Описание задачи" value="<?php echo($task[0]['description']);?>"/>
                            <?php if (!empty($errors['description'])): ?>
                                <div class="error"><?= implode('<br>', $errors['description']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 d-flex flex-column">
                            <select id="status" name="status">
                                <option value="">--Выберите статус задачи--</option>
                                <option value="В работе">В работе</option>
                                <option value="Завершено">Завершено</option>
                                <option value="Дедлайн">Дедлайн</option>
                            </select>
                            <?php if (!empty($errors['status'])): ?>
                                <div class="error"><?= implode('<br>', $errors['status']) ?></div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Редактировать</button>
                        <a class="btn btn-warning" style="margin-top: 10px;" onclick="hideForm(<?php echo($task[0]['id']);?>)">отмена</a>
                    </form>
                    <form class="updateTaskForm no-display" id="updateTaskForm<?php echo($task[0]['id']);?>" method="post" action="/update-task">
                        <input type="number" value="<?php echo($task[0]['id']);?>" name="id" id="id" hidden/>
                        <input type="number" value="<?php echo($user['id']);?>" name="user_id" id="user_id" hidden/>
                        <div class="mb-3 d-flex flex-column">
                            <p>Название</p>
                            <input type="text" name="title" id="title" placeholder="Название задачи" value="<?php echo($task[0]['title']);?>"/>
                            <?php if (!empty($errors['title'])): ?>
                                <div class="error"><?= implode('<br>', $errors['title']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 d-flex flex-column">
                            <p>Описание</p>
                            <input type="text" name="description" id="description" placeholder="Описание задачи" value="<?php echo($task[0]['description']);?>"/>
                            <?php if (!empty($errors['description'])): ?>
                                <div class="error"><?= implode('<br>', $errors['description']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 d-flex flex-column">
                            <select id="status" name="status">
                                <option value="">--Выберите статус задачи--</option>
                                <option value="В работе">В работе</option>
                                <option value="Завершено">Завершено</option>
                                <option value="Дедлайн">Дедлайн</option>
                            </select>
                            <?php if (!empty($errors['status'])): ?>
                                <div class="error"><?= implode('<br>', $errors['status']) ?></div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Редактировать</button>
                        <a class="btn btn-warning" style="margin-top: 10px;" onclick="hideForm(<?php echo($taskItem['id']);?>)">отмена</a>
                    </form>
            </div>
        <? endif; ?>
    <? else: ?>
        <p>У вас пока нет задач, создайте новую задачу!<p>
        <form class="createTaskForm" method="post" action="/create-task">
            <input type="number" value="<?php echo($user['id']);?>" name="id" id="id" hidden/>
            <div class="mb-3 d-flex flex-column">
                <p>Название</p>
                <input type="text" name="title" id="title" placeholder="Название задачи"/>
                <?php if (!empty($errors['title'])): ?>
                    <div class="error"><?= implode('<br>', $errors['title']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 d-flex flex-column">
                <p>Описание</p>
                <input type="text" name="description" id="description" placeholder="Описание задачи"/>
                <?php if (!empty($errors['description'])): ?>
                    <div class="error"><?= implode('<br>', $errors['description']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 d-flex flex-column">
                <select id="status" name="status">
                    <option value="">--Выберите статус задачи--</option>
                    <option value="В работе">В работе</option>
                    <option value="Завершено">Завершено</option>
                    <option value="Дедлайн">Дедлайн</option>
                </select>
                <?php if (!empty($errors['status'])): ?>
                    <div class="error"><?= implode('<br>', $errors['status']) ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-success mt-5">Создать</button>
        </form>
    <? endif; ?>
</body>
<footer>
    
</footer>
</html>

<script>
    function showForm(id){
        let form = document.querySelector(`#updateTaskForm${id}`);
        form.classList.remove("no-display");
    }
</script>

<script>
    function hideForm(id){
        let form = document.querySelector(`#updateTaskForm${id}`);
        form.classList.add("no-display");
    }
</script>