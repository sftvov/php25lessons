const PhLogin = (function () {
    let __this, __container, __overlay, __name, __password,
        __nameError, __passwordError;

    function saveUserData(response, status) {
        if (status == 200) {
            const data = JSON.parse(response);
            sessionStorage.setItem('userName', data.name);
            sessionStorage.setItem('userToken', data.token);
            hideForm();
            __this.refresh();
        } else if (status == 400) {
            const data = JSON.parse(response);
            __nameError.textContent = data.errors.name || '';
            __passwordError.textContent = data.errors.password || '';
        } else
            showError(status);
    }

    function login() {
        const fd = new FormData();
        fd.append('name', __name.value);
        fd.append('password', __password.value);
        __this.ajax.load('api/login/', saveUserData, 'POST', fd);
    }

    function hideForm() {
        document.body.removeChild(__overlay);
    }

    function showForm() {
        __overlay = document.createElement('div');
        __overlay.id = 'overlay';
        const form = document.createElement('form');
        let p = document.createElement('p');
        let label = document.createElement('label');
        label.textContent = 'Имя';
        p.appendChild(label);
        let br = document.createElement('br');
        p.appendChild(br);
        __name = document.createElement('input');
        __name.type = 'text';
        p.appendChild(__name);
        br = document.createElement('br');
        p.appendChild(br);
        __nameError = document.createElement('span');
        __nameError.className = 'error';
        p.appendChild(__nameError);
        form.appendChild(p);
        p = document.createElement('p');
        label = document.createElement('label');
        label.textContent = 'Пароль';
        p.appendChild(label);
        br = document.createElement('br');
        p.appendChild(br);
        __password = document.createElement('input');
        __password.type = 'password';
        p.appendChild(__password);
        br = document.createElement('br');
        p.appendChild(br);
        __passwordError = document.createElement('span');
        __passwordError.className = 'error';
        p.appendChild(__passwordError);
        form.appendChild(p);
        p = document.createElement('p');
        input = document.createElement('input');
        input.type = 'button';
        input.value = 'Войти';
        p.appendChild(input);
        input.addEventListener('click', login);
        input = document.createElement('input');
        input.type = 'button';
        input.value = 'Отмена';
        p.appendChild(input);
        input.addEventListener('click', hideForm);
        form.appendChild(p);
        __overlay.appendChild(form);
        document.body.appendChild(__overlay);
        __name.focus();
    }

    function logout () {
        sessionStorage.removeItem('userName');
        sessionStorage.removeItem('userToken');
        __this.refresh();
    }

    function PhLogin(container) {
        __this = this;
        __container = container;
        this.ajax = new AJAXLoader();
        this.refresh();
    }

    PhLogin.prototype.userData = function () {
        const name = sessionStorage.getItem('userName');
        const token = sessionStorage.getItem('userToken');
        if (name && token)
            return [name, token];
        else
            return false;
    }

    PhLogin.prototype.refresh = function () {
        __container.innerHTML = '';
        if (ud = this.userData()) {
            const p = document.createElement('p');
            p.textContent = 'Вы выполнили вход как ' + ud[0] + '.';
            __container.appendChild(p);
            const input = document.createElement('input');
            input.type = 'button';
            input.value = 'Выйти';
            input.addEventListener('click', logout);
            __container.appendChild(input);
        } else {
            const p = document.createElement('p');
            p.textContent = 'Чтобы оставить комментарий, выполните вход.';
            __container.appendChild(p);
            const input = document.createElement('input');
            input.type = 'button';
            input.value = 'Войти';
            input.addEventListener('click', showForm);
            __container.appendChild(input);
        }
        if (cComments)
            cComments.refresh();
}

    return PhLogin;
})();
