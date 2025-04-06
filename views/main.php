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

</header>
<body>
    <h1>Добро пожаловать в приложение "Список задач"</h1>
    <p><button class="btn" style="color:blue;" onclick="openRegister()">Зарегистрируйтесь</button> или <button class="btn" style="color:blue;" onclick="openLogin()">войдите</button>, чтобы начать пользоваться приложением!</p>
    
    <form method="post" action="/login" class="loginForm no-display" novalidate>
        <div class="mb-3 d-flex ms-5 me-5 gap-5">
            <b class="login" onclick="OpenLogin()">Вход</b>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <div onclick="CloseLogin()"><img src="https://avatars.mds.yandex.net/i?id=ec82793b85025256988f19dbb57003acde864c01-5232615-images-thumbs&n=13" width="30" height="30"/></div>
        </div>
        <div class="mb-3 d-flex flex-column">
            <label for="email" class="form-label">email</label>
            <input type="email" name="email" id="email" placeholder="example@mail.ru"/>
            <?php if (!empty($errors['email'])): ?>
                <div class="error"><?= implode('<br>', $errors['email']) ?></div>
            <?php endif; ?>
        </div>    
        <div class="mb-3 d-flex flex-column">
            <label for="username" class="form-label">Пароль</label>
            <input type="password" name="password" id="password" placeholder="Ваш пароль"/>
            <?php if (!empty($errors['password'])): ?>
                <div class="error"><?= implode('<br>', $errors['password']) ?></div>
            <?php endif; ?>
        </div> 
        <button type="submit" class="btn btn-success mt-5">Войти</button>
    </form>

    <form method="post" action="/register" class="registerForm no-display" novalidate>
        <div class="mb-3 d-flex ms-5 me-5 gap-5">
            <span></span>
            <span></span>
            <b class="register active" onclick="OpenRegister()">Регистрация</b>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <div onclick="CloseRegister()"><img src="https://avatars.mds.yandex.net/i?id=ec82793b85025256988f19dbb57003acde864c01-5232615-images-thumbs&n=13" width="30" height="30"/></div>
        </div>
        <div class="mb-3 d-flex flex-column">
            <label for="email" class="form-label">email</label>
            <input type="email" name="email" id="email" placeholder="example@mail.ru"/>
            <?php if (!empty($errors['email'])): ?>
                <div class="error"><?= implode('<br>', $errors['email']) ?></div>
            <?php endif; ?>
          </div>
          <div class="mb-3 d-flex flex-column">
            <label for="username" class="form-label">Никнейм</label>
            <input type="text" name="username" id="username" placeholder="напишите ваш псевдоним"/>
            <?php if (!empty($errors['username'])): ?>
                <div class="error"><?= implode('<br>', $errors['username']) ?></div>
            <?php endif; ?>
          </div>            
          <div class="mb-3 d-flex flex-column">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" name="password" id="password" placeholder="Ваш пароль"/>
            <?php if (!empty($errors['password'])): ?>
                <div class="error"><?= implode('<br>', $errors['password']) ?></div>
            <?php endif; ?>
          </div> 
          <div class="mb-3 d-flex flex-column">
            <label for="password_confirmation" class="form-label">Подтвердить пароль</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Подтвердите пароль"/>
            <?php if (!empty($errors['password_confirmation'])): ?>
                <div class="error"><?= implode('<br>', $errors['password_confirmation']) ?></div>
            <?php endif; ?>
          </div> 
        <button type="submit" class="btn btn-success mt-5">Зарегистрироваться</button>
    </form>
</body>
<footer>
    
</footer>
</html>