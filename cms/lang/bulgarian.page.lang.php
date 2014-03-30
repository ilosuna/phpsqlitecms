<?php
// phpSQLiteCMS Bulgarian language pack
// Created: 04.03.2014
// Last modified: 04.03.2014

// Meta informaton:
$lang['lang'] =                          'bg';
$lang['charset'] =                       'utf-8';
$lang['locale'] =                        array('bg_BG.utf8','bg','bul');
$lang['dir'] =                           'ltr';

// General:
$lang['exception_title'] =               'Грешка!';
$lang['exception_message'] =             'Грешка при изпълнение на операцията!';
$lang['error_headline'] =                'Грешка:';
$lang['page_time'] =                     '[time|%A, %B %d, %Y, %H:%M]';
$lang['include_news_time'] =             '[time|%B %e, %Y]';
$lang['submit_button_ok'] =              '&nbsp;OK&nbsp;';
$lang['page_last_modified'] =            '<!--Created: [created|%Y-%m-%d, %H:%M] - -->Last modified: [last_modified|%Y-%m-%d, %H:%M]';
$lang['no_comments'] =                   'Няма коментари.';
$lang['one_comment'] =                   '1 коментар';
$lang['several_comments'] =              'Коментари [comments]';
$lang['number_of_comments'][0] =         'Няма коментари.';
$lang['number_of_comments'][1] =         '1 коментар';
$lang['number_of_comments'][2] =         'Коментари [comments]';
$lang['pagination'] =                    'Страница [current_page] от общо [total_pages]';
$lang['edit'] =                          'редактиране';
$lang['delete'] =                        'изтриване';
$lang['all_categories'] =                'покажи всички категории';

// Admin Menu:
$lang['admin_menu_home'] =               'Начална';
$lang['admin_menu_admin'] =              'Администрация';
$lang['admin_menu_page_overview'] =      'Страници';
$lang['admin_menu_new_page'] =           'Нова страница';
$lang['admin_menu_logout'] =             'Излизане';
$lang['admin_menu_act_page_actions'] =   'Тази страница:';
$lang['admin_menu_edit_page'] =          'Редактиране';
$lang['admin_menu_delete_page'] =        'Изтриване';
$lang['admin_menu_delete_page_conf'] =   'Изтриване на тази страница?';

// Comments:
$lang['comment_headline'] =              'Коментари';
$lang['pingback_headline'] =             'Pingbacks';
$lang['comment_no_comments'] =           'Няма коментари.';
$lang['comments_closed'] =               'Коментарите са затворени.';
$lang['comment_time'] =                  '[time|%A, %B %d, %Y, %H:%M]';
$lang['comments_pagination_info'] =      'Коментари: [total_comments], Страница: [current_page] от общо [total_pages]';
$lang['comments_add_comment'] =          'Коментирай';
$lang['comment_input_text'] =            'Коментар*:';
$lang['comment_edit_text'] =             'Редактиране на коментар:';
$lang['comment_input_name'] =            'Име*';
$lang['comment_input_email_hp'] =        'Имейл/сайт - незадължително';
$lang['comment_input_submit'] =          '&nbsp;Публикувай&nbsp;';
$lang['comment_input_preview'] =         'Преглед';
$lang['comment_preview_hl'] =            'Преглед:';
$lang['error_not_accepted_word'] =       'Коментарът съдържа забранена дума: <b>[not_accepted_word]</b>!';
$lang['error_not_accepted_words'] =      'Коментарът съдържа забранени думи или изрази: <b>[not_accepted_words]</b>!';
$lang['comment_error_closed'] =          'Коментарите са затворени!';
$lang['comment_error_no_name'] =         'Липсва име!';
$lang['comment_error_no_text'] =         'Липсва коментар!';
$lang['comment_error_name_too_long'] =   'Името е твърде дълго!';
$lang['comment_error_email_hp_too_long'] = 'Имейлът/сайтът е твърде дълъг!';
$lang['comment_error_email_hp_invalid'] = 'Невалиден имейл/сайт!';
$lang['comment_error_text_too_long'] =   'Текстът е твърде дълъг (Въведеният текст е със: [characters] символа, при позволен максимум от: [max_characters] символа)!';
$lang['comment_error_too_long_word'] =   'Коментарът съдържа твърде дълга дума: <b>[word]</b>!';
$lang['comment_error_too_long_words'] =  'Коментарът съдържа твърде дълги думи или изрази: <b>[words]</b>!';
$lang['comment_error_entry_exists'] =    'Има такъв коментар!';
$lang['comment_error_repeated_post'] =   'Току-що беше публикуван коментар от Вашия IP адрес - моля опитайте по-късно!';
$lang['comment_error_too_fast'] =        'Коментарът беше публикуван твърде бързо - моля, опитайте отново!';
$lang['comment_delete_link'] =           'изтриване';
$lang['comment_delete_confirm'] =        'Изтриване на този коментар?';
$lang['comment_edit_link'] =             'редактиране';
$lang['comment_note_email'] =            '(незадължително)';
$lang['comments_open'] =                 'отваряне на коментарите';
$lang['comments_close'] =                'затваряне на коментарите';
$lang['comment_notification_subject'] =  'Публикуван коментар на страница: <b>[page]</b>.';
$lang['comment_notification_message'] =  "[name]\n\n[comment]\n\n[link]";
$lang['pingback_notification_subject'] = 'Pingback към страница: <b>[page]</b>.';
$lang['pingback_notification_message'] = "[title]\n[url]\n[link]";

// News:
$lang['news_time'] =                     '[time|%A, %B %d, %Y, %H:%M]';
$lang['no_news'] =                       'Няма новини.';

// Notes:
$lang['note_time'] =                     '[time|%A, %B %d, %Y, %H:%M]';
$lang['no_notes'] =                      'Няма бележки.';

// Formmailer:
$lang['formmailer_label_email'] =        'Имейл*:';
$lang['formmailer_label_subject'] =      'Тема:';
$lang['formmailer_label_message'] =      'Съобщение*:';
$lang['formmailer_button_send'] =        'Изпращане';
$lang['formmail_error_email_invalid'] =  'Имейлът е невалиден или липсва!';
$lang['formmail_error_no_message'] =     'Липсва съобщение!';
$lang['formmail_error_text_too_long'] =  'Съобщението е твърде дълго!';
$lang['formmail_error_subj_too_long'] =  'Темата на съобщението е твърде дълга!';
$lang['formmail_error_mailserver'] =     'Грешка на имейл сървъра - моля, опитайте по-късно!';
$lang['formmailer_mail_sent'] =          'Съобщението беше изпратено успешно.';
$lang['formmailer_no_subject'] =         'Липсва тема!';

// Gallery:
$lang['gallery_no_photo'] =              'В галерията няма снимки.';

// Photo:
$lang['photo_headline'] =                'Снимка';
$lang['previous_photo'] =                'Предишна снимка';
$lang['next_photo'] =                    'Следваща снимка';
$lang['enlarge_photo'] =                 'Увеличи';
$lang['reduce_photo'] =                  'Намали';
$lang['show_large_photo'] =              'Голяма снимка';
$lang['show_large_photo_title'] =        'Покажи голямата снимка';
$lang['back_link'] =                     'назад';
$lang['back_title'] =                    'Назад към &quot;<b>[page]</b>&quot;';
$lang['photo_comment_link_title'] =      'Прочети или напиши коментар към тази снимка.';

// Simple news:
$lang['simple_news_time'] =              '[time|%A, %B %e, %Y]';
$lang['simple_news_edit_title'] =        'Заглавие:';
$lang['simple_news_edit_teaser'] =       'Тийзър:';
$lang['simple_news_edit_text'] =         'Текст:';
$lang['simple_news_edit_text_format'] =  'автоформатиране';
$lang['simple_news_edit_linkname'] =     'Текст на линка:';
$lang['simple_news_default_linkname'] =  'повече…';
$lang['simple_news_edit_time'] =         'Дата/Време:';
$lang['simple_news_edit_time_format'] =  'YYYY-MM-DD HH:MM:SS';
$lang['simple_news_add_item'] =          'Добави новина';
$lang['simple_news_edit_item'] =         'Редактиране на новина';
$lang['simple_news_delete_confirm'] =    'Изтриване на тази новина?';
$lang['error_news_no_title'] =           'Липсва заглавие!';
$lang['error_news_no_text'] =            'Липсва текст!';
$lang['error_news_time_invalid'] =       'Невалиден формат на дата/време!';
$lang['delete_news_title'] =             'Изтриване на новина';
$lang['delete_news_confirm_submit'] =    'OK - Изтрий';

// Search:
$lang['search_submit'] =                 'Търсене';
$lang['search_number_of_results'][0] =   'Не са намерени страници, съдържащи търсената информация.';
$lang['search_number_of_results'][1] =   'Намерена е 1 страница, съдържаща търсената информация:';
$lang['search_number_of_results'][2] =   'Намерени са [pages] страници, съдържащи търсената информация:';
$lang['search_pagination'] =             '[total_results] резултата, Страница [current_page] от общо [total_pages]';
$lang['search_photo'] =                  'Изображения';
$lang['search_no_results'] =             'Не са намерени страници, съдържащи търсената информация.';

// Akismet:
$lang['akismet_error_api_key'] =         'Невалиден Akismet API ключ!';
$lang['akismet_error_connection'] =      'Грешка при свързването със сървъра - моля, опитайте по-късно!';
$lang['akismet_spam_suspicion'] =        'Съмнение за Спам!';
?>
