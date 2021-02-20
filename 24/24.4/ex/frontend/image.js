const PhImage = (function () {
    let __this, __id, __container, __data;

    function __refresh(response, status) {
        if (status != 200)
            showError(status);
        else {
            __data = JSON.parse(response);
            __this.refresh();
        }
    }

    function PhImage(id, container) {
        __this = this;
        __id = id;
        __container = container;
        this.ajax = new AJAXLoader();
        this.reload();
    }

    PhImage.prototype.reload = function () {
        this.ajax.load('api/images/' + __id, __refresh);
    }

    PhImage.prototype.refresh = function () {
        __container.innerHTML = '';
        const h1 = document.createElement('h1');
        h1.textContent = __data.title;
        __container.appendChild(h1);
        const img = document.createElement('img');
        img.className = 'image';
        img.src = __data.url;
        __container.appendChild(img);
        const p = document.createElement('p');
        p.textContent = __data.description;
        __container.appendChild(p);
        let div = document.createElement('div');
        __container.appendChild(div);
        if (!cLogin)
            cLogin = new PhLogin(div)
        div = document.createElement('div');
        __container.appendChild(div);
        if (!cComments)
            cComments = new PhComments(__id, div);
    }

    return PhImage;
})();
