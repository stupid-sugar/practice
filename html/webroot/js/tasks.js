$(document).ready(function() {
    // todoモーダルを開く(閲覧・編集)
    $(document).on('click', '.task', function(event) {
        // いいねボタンをクリックしていた場合
        if (event.target.className == 'like') {
            $(this).find('.like_form').submit();
            return false;
        }
        
        // 選択したtodoの情報をモーダルに反映
        initTaskModal(this);

        // モーダルを開く
        $('#task_modal').modal();
        return false;
    });

    // todoモーダルを開く(新規追加)
    $('#add_task').click(function(event) {
        // モーダルを開く
        if (!checkAuth()) {
            openNotifyModal("ToDoリスト作成するために、ログインしましょう");
            return false;
        }
        initTaskModal();
        $('#task_modal').modal();
    });

    // 削除ボタンをクリック
    $(document).on('click', '.delete', function(event) {
        var csrf = $('input[name="_csrfToken"]').val();
        var id = $(this).parents('#modal_task_form').find('input[name="id"]').val();
        
        event.preventDefault();                                                                       
        event.stopPropagation();
        if(!confirm('削除してよろしいですか')){
            return false;
        }

        $.ajax({                                                                                      
            type: 'POST',
            dataType: 'JSON',
            url: '/tasks/delete',
            headers: {'X-CSRF-Token': csrf},
            data: {'id': id},                                                      
        }).done(function(data) {
            if (data.success) {
                removeTask(id);
                $.modal.close();
                alert('削除しました');
            }
        });
        
    });
    
    // タスクの変更をsubmit
    $('#modal_task_form').submit(function(event) {
        var csrf = $('input[name="_csrfToken"]').val();
        
        event.preventDefault();                                                                       
        event.stopPropagation();

        $.ajax({                                                                                      
            type: 'POST',
            dataType: 'JSON',
            url: '/tasks/save',
            headers: {'X-CSRF-Token': csrf},
            data: { data: $(this).serialize()},                                                      
        }).done(function(data) {
            if (data.entity.length==0) {
                alert('編集するために、ログインしてください');
                return false;
            }
            
            removeError($('#modal_task_form'));
            setError($('#modal_task_form'), data.errors);
            
            if (data.errors.length == 0) {
                if (data.isNew) {
                    window.location.reload();
                    //$('.all').prepend(data.content);
                    //$('.my').prepend(data.content);
                }
                // 編集したToDoのIdを持つカードを同期
                var target = $("input:hidden[class='todo_id'][value='"+data.entity.id+"']").parent();
                target.children('.todo_title').text(data.entity.title);
                target.children('.todo_content').text(data.entity.content);
                $.modal.close();
            }
        });
    });

    // いいねボタンをクリック
    $(document).on('submit', '.like_form', function(event) {
        var url = '/likes/add';
        var csrf = $('input[name="_csrfToken"]').val();
        
        event.preventDefault();                                                                       
        event.stopPropagation();
        
        if (!checkAuth()) {
            openNotifyModal("いいねするために、ログインしましょう");
            return false;
        }

        $.ajax({                                                                                      
            type: 'POST',
            dataType: 'JSON',
            url: url,
            headers: {'X-CSRF-Token': csrf},
            data: { data: $(this).serialize()},                                                      
        }).done(function(data) {
            var target = $(event.target).find('.like');
            target.text('イイネ ' + data.likeCnt);
        });
    });
    
    // 表示タブの切り替え
    $('.all_todo').click(function(){
        $('.task_block.all').show();
        $('.task_block.my').hide();
        $('.all_todo').css('opacity', 1.0);
        $('.my_todo').css('opacity', 0.5);
    });

    $('.my_todo').click(function(){
        $('.task_block.all').hide();
        $('.task_block.my').show();
        $('.all_todo').css('opacity', 0.5);
        $('.my_todo').css('opacity', 1.0);
    });
    
    // Ajax 追加読込
    var page = 2; // デフォルトが1のため、次ページは2から始まる
    $('.task_block.all').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            loadTask(page);
            page+=1;
        }
    })

    // Ajax 追加読込
    var mypage = 2; // デフォルトが1のため、次ページは2から始まる
    $('.task_block.my').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            loadMyTask(mypage);
            mypage+=1;
        }
    })

    // タスクモーダルの初期化
    function initTaskModal(elem = '') {
        var id = title = content = '';
        if ($(elem).length > 0) {
            id = $(elem).children('.todo_id').val();
            title = $(elem).children('.todo_title').text();
            content = $(elem).children('.todo_content').text();
        }
        $('#task_modal input[name="id"]').val(id);
        $('#task_modal #title').val(title);
        $('#task_modal #content').val(content);
        
        // 削除ボタンの表示切替(mytaskの場合表示)
        var isShow = $(elem).parent('.my').length!=0;
        $('#task_modal .delete').toggle(isShow);
    }
    
    // タスクを追加で読み込む
    function loadTask(page) {
        $.ajax({                                                                                      
            type: 'GET',
            dataType: 'JSON',
            url: '/tasks/loadTask?page='+page,
        }).done(function(data) {
            $('.all').append(data);
        });
    }
    
    // マイタスクを追加で読み込む
    function loadMyTask(page) {
        $.ajax({                                                                                      
            type: 'GET',
            dataType: 'JSON',
            url: '/tasks/loadMyTask?page='+page,
        }).done(function(data) {
            $('.my').append(data);
        });
    }
    
    // タスクを一覧から削除
    function removeTask(id) {
        // 全てのタスク一覧から削除
        $('.all .todo_id[value="'+id+'"]').parent().remove();
        // 自分のタスク一覧から削除
        $('.my .todo_id[value="'+id+'"]').parent().remove();
    }
    
});