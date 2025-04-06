function openLogin(){
    let form = document.querySelector('.loginForm');
    form.classList.remove('no-display');
}

function openRegister(){
    let form = document.querySelector('.registerForm');
    form.classList.remove('no-display');
}

function CloseRegister(){
    let form = document.querySelector('.registerForm');
    form.classList.add('no-display');
}

function CloseLogin(){
    let form = document.querySelector('.loginForm');
    form.classList.add('no-display');
}

function openTask(id){
    let task = document.querySelector(`#task-popup${id}`);
    task.classList.remove('no-display');
}

function closeTask(id){
    let task = document.querySelector(`#task-popup${id}`);
    task.classList.add('no-display');
}