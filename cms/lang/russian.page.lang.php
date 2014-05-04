<?php
// phpSQLiteCMS Russian Language pack
// translated by Valery votintsev, codersclub.org

// Meta informaton:
$lang['lang'] =                          'ru';
$lang['charset'] =                       'utf-8';
$lang['locale'] =                        array('ru_RU.utf8','ru','rus');
$lang['dir'] =                           'ltr';

// General:
$lang['exception_title'] =               'Ошибка';
$lang['exception_message'] =             'Ошибка выполнения операции.';
$lang['error_headline'] =                'Ошибка:';
$lang['page_time'] =                     '[time|%A, %B %d, %Y, %H:%M]';
$lang['include_news_time'] =             '[time|%B %e, %Y]';
$lang['submit_button_ok'] =              '&nbsp;OK&nbsp;';
$lang['page_last_modified'] =            '<!--Created: [created|%Y-%m-%d, %H:%M] - -->Last modified: [last_modified|%Y-%m-%d, %H:%M]';
$lang['no_comments'] =                   'Нет комментариев';
$lang['one_comment'] =                   '1 комментарий';
$lang['several_comments'] =              'Комментарии: [comments]';
$lang['number_of_comments'][0] =         'нет комментариев';
$lang['number_of_comments'][1] =         '1 комментарий';
$lang['number_of_comments'][2] =         'Комментарии: [comments]';
$lang['pagination'] =                    'Страница: [current_page] / [total_pages]';
$lang['edit'] =                          'Изменить';
$lang['delete'] =                        'Удалить';
$lang['all_categories'] =                'Показать все категории';

// Admin Menu:
$lang['admin_menu_home'] =               'Главная';
$lang['admin_menu_admin'] =              'Админ-Центр';
$lang['admin_menu_page_overview'] =      'Страницы';
$lang['admin_menu_new_page'] =           'Добавить страницу';
$lang['admin_menu_logout'] =             'Выход';
$lang['admin_menu_act_page_actions'] =   'Эта страница:';
$lang['admin_menu_edit_page'] =          'Изменить';
$lang['admin_menu_delete_page'] =        'Удалить';
$lang['admin_menu_delete_page_conf'] =   'Вы уверены, что следует удалить данную страницу?';

// Comments:
$lang['comment_headline'] =              'Комментарии';
$lang['pingback_headline'] =             'Pingbacks';
$lang['comment_no_comments'] =           'Пока ещё нет комментариев.';
$lang['comments_closed'] =               'Комментарии запрещены.';
$lang['comment_time'] =                  '[time|%A, %B %d, %Y, %H:%M]';
$lang['comments_pagination_info'] =      'Комментариев: [total_comments], Страница: [current_page] / [total_pages]';
$lang['comments_add_comment'] =          'Добавить комментарий';
$lang['comment_input_text'] =            'Комментарий:';
$lang['comment_edit_text'] =             'Изменить комментарий:';
$lang['comment_input_name'] =            'Имя';
$lang['comment_input_email_hp'] =        'E-mail или URL';
$lang['comment_input_submit'] =          '&nbsp;OK&nbsp;';
$lang['comment_input_preview'] =         'Предпросмотр';
$lang['comment_preview_hl'] =            'Предпросмотр:';
$lang['error_not_accepted_word'] =       'Запрещённое слово: [not_accepted_word]';
$lang['error_not_accepted_words'] =      'Запрещённые слова: [not_accepted_words]';
$lang['comment_error_closed'] =          'Комментарии запрещены!';
$lang['comment_error_no_name'] =         'Не указано имя';
$lang['comment_error_no_text'] =         'Не введён текст комментария';
$lang['comment_error_name_too_long'] =   'Имя слишком длинное';
$lang['comment_error_email_hp_too_long'] = 'E-mail/URL слишком длинный';
$lang['comment_error_email_hp_invalid'] = 'Недопустимый E-mail/URL';
$lang['comment_error_text_too_long'] =   'Текст слишком длинный (Введено: [characters] символов, Максимум: [max_characters] символов)';
$lang['comment_error_too_long_word'] =   'Слишком длинное слово: [word]';
$lang['comment_error_too_long_words'] =  'Слишком длинные слова: [words]';
$lang['comment_error_entry_exists'] =    'Такой комментарий уже существует';
$lang['comment_error_repeated_post'] =   'С данного IP уже отправлен комментарий - подождите немного!';
$lang['comment_error_too_fast'] =        'Вы отправляете комментарии слишком часто - подождите немного!';
$lang['comment_delete_link'] =           'Удалить';
$lang['comment_delete_confirm'] =        'Вы уверены, что следует удалить этот комментарий?';
$lang['comment_edit_link'] =             'Изменить';
$lang['comment_note_email'] =            '(не обязательно)';
$lang['comments_open'] =                 'Разрешить комментарии';
$lang['comments_close'] =                'Запретить комментарии';
$lang['comment_notification_subject'] =  'Комментарий к странице [page]';
$lang['comment_notification_message'] =  "[name]\n\n[comment]\n\n[link]";
$lang['pingback_notification_subject'] = 'Pingback к странице [page]';
$lang['pingback_notification_message'] = "[title]\n[url]\n[link]";

// News:
$lang['news_time'] =                     '[time|%A, %B %d, %Y, %H:%M]';
$lang['no_news'] =                       'Нет новостей';

// Notes:
$lang['note_time'] =                     '[time|%A, %B %d, %Y, %H:%M]';
$lang['no_notes'] =                      'Нет заметок';

// Formmailer:
$lang['formmailer_label_email'] =        'E-mail:';
$lang['formmailer_label_subject'] =      'Тема:';
$lang['formmailer_label_message'] =      'Сообщение:';
$lang['formmailer_button_send'] =        'Отправить сообщение';
$lang['formmail_error_email_invalid'] =  'Недопустимый или пустой E-mail';
$lang['formmail_error_no_message'] =     'Не введён текст сообщения';
$lang['formmail_error_text_too_long'] =  'Сообщение слишком длинное';
$lang['formmail_error_subj_too_long'] =  'Сообщение слишком короткое';
$lang['formmail_error_mailserver'] =     'Ошибка отправки сообщения - попробуйте повторить позже!';
$lang['formmailer_mail_sent'] =          'Сообщение успешно отправлено.';
$lang['formmailer_no_subject'] =         'Не указана тема';

// Gallery:
$lang['gallery_no_photo'] =              'В данной галерее нет изображений';

// Photo:
$lang['photo_headline'] =                'Изображение';
$lang['previous_photo'] =                'Пред. изображение';
$lang['next_photo'] =                    'След. изображение';
$lang['enlarge_photo'] =                 'Увеличить';
$lang['reduce_photo'] =                  'Уменьшить';
$lang['show_large_photo'] =              'Больше';
$lang['show_large_photo_title'] =        'Показать изображение большего размера';
$lang['back_link'] =                     'Назад';
$lang['back_title'] =                    'Назад к &quot;[page]&quot;';
$lang['photo_comment_link_title'] =      'Просмотр/Добавление комментариев к данному изображению';

// Simple news:
$lang['simple_news_time'] =              '[time|%A, %B %e, %Y]';
$lang['simple_news_edit_title'] =        'Заголовок:';
$lang['simple_news_edit_teaser'] =       'Анонс:';
$lang['simple_news_edit_text'] =         'Текст:';
$lang['simple_news_edit_text_format'] =  'Авто-форматирование';
$lang['simple_news_edit_linkname'] =     'Имя ссылки:';
$lang['simple_news_default_linkname'] =  'Подробнее...';
$lang['simple_news_edit_time'] =         'Дата/Время:';
$lang['simple_news_edit_time_format'] =  'YYYY-MM-DD HH:MM:SS';
$lang['simple_news_add_item'] =          'Добавить новость';
$lang['simple_news_edit_item'] =         'Изменить новость';
$lang['simple_news_delete_confirm'] =    'Удалить данную новость?';
$lang['error_news_no_title'] =           'Не указан заголовок';
$lang['error_news_no_text'] =            'Не введён текст новости';
$lang['error_news_time_invalid'] =       'Неверный формат даты/времени';
$lang['delete_news_title'] =             'Удалить новость';
$lang['delete_news_confirm_submit'] =    'OK - Удалить';

// Search:
$lang['search_submit'] =                 'Поиск';
$lang['search_number_of_results'][0] =   'Не найдено страниц';
$lang['search_number_of_results'][1] =   'Найдена 1 страница:';
$lang['search_number_of_results'][2] =   'Найдено [pages] страниц:';
$lang['search_pagination'] =             '[total_results] результатов, Страница [current_page] / [total_pages]';
$lang['search_photo'] =                  'Изображения';
$lang['search_no_results'] =             'Не найдено страниц';

// Akismet:
$lang['akismet_error_api_key'] =         'Недопустимый ключ akismet api';
$lang['akismet_error_connection'] =      'Ошибка подключения к серверу akismet - попробуйте повторить позже';
$lang['akismet_spam_suspicion'] =        'Похоже на спам!';

