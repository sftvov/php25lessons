const PhComments = (function () {
    let __this, __id, __container, __data;

    function editComment() {
        cAddEdit.addEditComment(this.data);
    }

    function deleteComment() {
        cDelete.deleteComment(this.data.id);
    }

    function __refresh(response, status) {
        if (status != 200)
            showError(status);
        else {
            __data = JSON.parse(response);
            __this.refresh();
        }
    }

    function addComment() {
        cAddEdit.addEditComment();
    }

    function PhComments(id, container) {
        __this = this;
        __id = id;
        __container = container;
        this.ajax = new AJAXLoader();
        this.reload();
    }

    PhComments.prototype.reload = function () {
        this.ajax.load('api/images/' + __id + '/comments/', __refresh);
    }

    PhComments.prototype.refresh = function () {
        const ud = cLogin.userData();
        __container.innerHTML = '';
        const h3 = document.createElement('h3');
        h3.textContent = 'Комментарии';
        __container.appendChild(h3);
        let input, h5, p;
        if (ud) {
            input = document.createElement('input');
            input.type = 'button';
            input.value = 'Добавить комментарий';
            input.src = '/api/images/' + __id + '/comments/';
            input.addEventListener('click', addComment);
            __container.appendChild(input);
        }
        for (let i = 0; i < __data.length; i++) {
            h5 = document.createElement('h5');
            h5.textContent = __data[i].user_name;
            __container.appendChild(h5);
            p = document.createElement('p');
            p.textContent = __data[i].contents;
            __container.appendChild(p);
            if (ud && __data[i].user_name == ud[0]) {
                input = document.createElement('input');
                input.type = 'button';
                input.value = 'Исправить';
                input.data = __data[i];
                input.addEventListener('click', editComment);
                __container.appendChild(input);
                input = document.createElement('input');
                input.type = 'button';
                input.value = 'Удалить';
                input.data = __data[i];
                input.addEventListener('click', deleteComment);
                __container.appendChild(input);
            }
            p = document.createElement('p');
            p.innerHTML = '&nbsp;';
            __container.appendChild(p);
        }
    }
    
    return PhComments;
})();
