<?php 
$user = $_SESSION['user']; ?>

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
        <a class="menuButton" href="/todos">Список дел</a>
        <a class="menuButton" href="/dashboard">Доска задач</a>
        <a class="menuButton active" href="/profile">Мой профиль</a>
        </form>
    </div>
</header>
<body>
    <form class="updateProfileForm" method="post" action="/update-profile">
        <div class="profileInfo">
            <p class="profileItem">Информация о пользователе</p>
            <p class="profileItem">ID: <?php echo($user['id']);?></p>
            <p class="profileItem">Email: <?php echo($user['email']);?></p>
            <p class="profileItem">Никнейм: <?php echo($user['username']);?></p>
        </div>
        <input type="number" value="<?php echo($user['id']);?>" name="id" id="id" hidden />
        <div class="mb-3 d-flex flex-column">
            <label for="email" class="form-label">email</label>
            <input type="email" name="email" id="email" value="<?php echo($user['email']);?>"/>
            <?php if (!empty($errors['email'])): ?>
                <div class="error"><?= implode('<br>', $errors['email']) ?></div>
            <?php endif; ?>
        </div>    
        <div class="mb-3 d-flex flex-column">
            <label for="username" class="form-label">никнейм</label>
            <input type="username" name="username" id="username" value="<?php echo($user['username']);?>"/>
            <?php if (!empty($errors['username'])): ?>
                <div class="error"><?= implode('<br>', $errors['username']) ?></div>
            <?php endif; ?>
        </div> 
        <button type="submit" class="btn btn-success mt-5">Сохранить</button>
        <a class="btn btn-danger" style="margin-top:10px;" href="/logout">Выйти из аккаунта</button>
    </form>
    
</body>
<footer>
    
</footer>
</html>