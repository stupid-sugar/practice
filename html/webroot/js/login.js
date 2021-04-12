$(document).ready(function() {

    /*
    // ログインボタン押下 loginモーダルを開く
    $('#login').click(function(event) {
        $('#login_modal').modal();
        return false;
    });

    // ログインフォーム送信
    $('#modal_login_form').submit(function(event) {
        var username = $("#login_modal #username").val();
        var password = $("#login_modal #password").val();
        var csrf = $('input[name="_csrfToken"]').val();

        event.preventDefault();                                                                       
        event.stopPropagation();

        $.ajax({                                                                                      
            type: 'POST',
            //dataType: 'JSON',
            url: event.target.action,
            headers: {'X-CSRF-Token': csrf},
            //data: { data: $(this).serialize()},
            data: { 'username': username, 'password': password},   
        }).done(function(data) {
            alert(data.msg);
            if (data.success) {
                $('#isLoggedIn').val(1);
                $('#name').text(data.username);
                $('#login').hide();
                $('#logout').show();
                $.modal.close();
            }
        });
    });
    */
    
    // アカウント登録modalを開く
    $('.regist').click(function(event){
        event.preventDefault();                                                                       
        event.stopPropagation();

        $.modal.close();
        $('#regist_modal').modal();
    });

    // アカウント登録フォーム送信
    $('#modal_regist_form').submit(function(event) {
        var username = $("#regist_modal #username").val();
        var password = $("#regist_modal #password").val();
        var csrf = $('input[name="_csrfToken"]').val();

        event.preventDefault();                                                                       
        event.stopPropagation();

        $.ajax({                                                                                      
            type: 'POST',
            url: event.target.action,
            headers: {'X-CSRF-Token': csrf},
            data: { 'username': username, 'password': password},   
        }).done(function(data) {
            removeError($('#modal_regist_form'));
            if (data.length == 0) {
                $.modal.close();
                alert("アカウントを作成しました");
                return false;
            }
            setError($('#modal_regist_form'), data);
        });
    });
    
});

// ログインチェック
function checkAuth() {
    return $('#isLoggedIn').val();
}

// ログインモーダルを開く
function openLoginModal(msg) {
    $('#login_modal .msg').text(msg);
    $('#login_modal').modal();
}

// ログインモーダルを開く
function openNotifyModal(msg) {
    $('#notify_modal .msg').text(msg);
    $('#notify_modal').modal();
}

// バリデーションエラーのセット (Ajax)
function setError(form, data) {
    $.each(data, function(model, errors) {
        $.each(errors, function(errorType, msg) {
            var target = $(form).find('#' + model);
            target.after('<div class="error-message">' + msg + '</div>');
        });
    });
};

// バリデーションエラーを取り除く (Ajax)
function removeError(form)  {
    var target = $(form).find('.error-message');
    target.remove();
}
