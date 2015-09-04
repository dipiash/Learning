(function () {
    var countFilesUpl = 0, // "id" загруженного файла
        block = false; // признак загрузки файла

    $('#csvF').submit(function (e) {
        if (!block && $('#file')[0].files.length !== 0) {
            block = true;
            e.stopPropagation();
            e.preventDefault();

            $.ajax({
                type: 'POST',
                data: new FormData(this),
                url: '/uplcsv',
                processData: false,
                contentType: false,
                dataType: 'json',
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener('progress', function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                        }

                        if (percentComplete === 1) {
                            var uplInf = '<p class="msg_inf"> #' + countFilesUpl + ' Файл загружен. Идет обработка. Подождите...<\p>';
                            $('#info').append(uplInf);
                        }
                    }, false);
                    return xhr;
                },
                success: function (data) {
                    var prepInf = '<p class="msg_inf_add"> #' + countFilesUpl + ' Добавлено ' + data.add + ' / обновлено ' + data.update + '<\p>';
                    $('#info').append(prepInf);
                    block = false;
                },
                error: function () {
                    var errInf = '<p class="msg_inf_err"> #' + countFilesUpl + ' Возможно файл не выбран или ошибка загрузки файла.<\p>';
                    $('#info').append(errInf);
                    block = false;
                }
            });

            $('#file').val('');
            ++countFilesUpl;

        } else {
            var waitInf = '<p class="msg_inf_wait"> #' + countFilesUpl + ' Возможно вы не выбрали файл. Либо файл еще загружается или обрабатывается. Подождите...<\p>';
            $('#info').append(waitInf);
            block = false;
        }

        return false;
    });
})();