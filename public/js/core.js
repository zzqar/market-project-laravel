$(document).ready(function () {
    $('.favorite-btn').click(function () {
        const button = $(this);
        const changedID = button.data('id');
        const buttonText = button.data('updated-text');
        const href = button.data('href');

        // Отправка запроса на сервер
        $.ajax({
            url: href,
            method: 'POST',
            data: {changedID: changedID},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    // Успешный ответ от сервера, изменяем внешний вид кнопки
                    button.text(buttonText);
                    button.removeClass('btn-secondary').addClass('btn-outline-success');
                    button.off('click');
                }
            },
            error: function () {
                // Ошибка при обращении к серверу
                alert('Произошла ошибка. Повторите попытку позже.');
            }
        });
    });
});
