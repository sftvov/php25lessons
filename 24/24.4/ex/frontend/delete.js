const PhDelete = (function () {
    let __id;

    function done(response, status) {
        if (status == 204)
            cComments.reload();
        else
            showError(status);
    }

    function PhDelete(id) {
        __id = id;
        this.ajax = new AJAXLoader();
    }

    PhDelete.prototype.deleteComment = function (commentId) {
        if (window.confirm('Удалить комментарий?')) {
            const ud = cLogin.userData();
            const fd = new FormData();
            fd.append('name', ud[0]);
            fd.append('token', ud[1]);
            fd.append('__method', 'DELETE');
            this.ajax.load('api/images/' + __id + '/comments/' + commentId,
                done, 'POST', fd);
        }
    }

    return PhDelete;
})();
