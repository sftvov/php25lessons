const PhAddEdit = (function () {
    let __this, __id, __overlay, __comment, __contents,
        __contentsError;

    function hideForm() {
        document.body.removeChild(__overlay);
    }

    function send() {
        const ud = cLogin.userData();
        const fd = new FormData();
        fd.append('contents', __contents.value);
        fd.append('name', ud[0]);
        fd.append('token', ud[1]);
        if (__comment) {
            fd.append('__method', 'PATCH');
            __this.ajax.load('api/images/' + __id + '/comments/' + __comment['id'],
                done, 'POST', fd);
        } else
            __this.ajax.load('api/images/' + __id + '/comments/',
                done, 'POST', fd);
}

    function done(response, status) {
        st = (__comment) ? 200 : 201;
        if (status == st) {
            hideForm();
            cComments.reload();
        } else if (status == 400) {
            const data = JSON.parse(response);
            __contentsError.textContent = data.errors.contents || '';
        } else
            showError(status);
    }

    function PhAddEdit(id) {
        __this = this;
        __id = id;
        this.ajax = new AJAXLoader();
    }

    PhAddEdit.prototype.addEditComment = function (commentData = null) {
        __comment = commentData;
        __overlay = document.createElement('div');
        __overlay.id = 'overlay';
        const form = document.createElement('form');
        let p = document.createElement('p');
        let label = document.createElement('label');
        label.textContent = 'Содержание';
        p.appendChild(label);
        let br = document.createElement('br');
        p.appendChild(br);
        __contents = document.createElement('textarea');
        if (__comment)
            __contents.textContent = __comment['contents'];
        p.appendChild(__contents);
        br = document.createElement('br');
        p.appendChild(br);
        __contentsError = document.createElement('span');
        __contentsError.className = 'error';
        p.appendChild(__contentsError);
        form.appendChild(p);
        p = document.createElement('p');
        input = document.createElement('input');
        input.type = 'button';
        input.value = 'Отправить';
        p.appendChild(input);
        input.addEventListener('click', send);
        input = document.createElement('input');
        input.type = 'button';
        input.value = 'Отмена';
        p.appendChild(input);
        input.addEventListener('click', hideForm);
        form.appendChild(p);
        __overlay.appendChild(form);
        document.body.appendChild(__overlay);
        __contents.focus();
}

    return PhAddEdit;
})();
