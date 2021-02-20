const AJAXLoader = (function () {
    function onResponse() {
        if (this.readyState == 4)
            this.handler(this.response, this.status);
    }

    function AJAXLoader() {
        this.ajax = new XMLHttpRequest();
        this.ajax.addEventListener('readystatechange', onResponse);
    }

    AJAXLoader.prototype.load = function (url, handler, method = 'GET',
        data = null) {
        this.ajax.handler = handler;
        this.ajax.open(method, domain + url, true);
        this.ajax.send(data);
    };

    return AJAXLoader;
})();
