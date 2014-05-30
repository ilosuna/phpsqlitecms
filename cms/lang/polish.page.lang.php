<?php
/*
Author of translation Lukasz Zyla
site: bicluc.net
e-mail: bicluc@gmail.com
*/

// Meta informaton:
$lang['lang'] =                          'pl';
$lang['charset'] =                       'utf-8';
$lang['locale'] =                        array('pl_PL.utf8','pl','pol');
$lang['dir'] =                           'ltr';

// General:
$lang['exception_title'] =               'Błąd';
$lang['exception_message'] =             'Wystąpił błąd podczas przetwarzania.';
$lang['error_headline'] =                'Błąd:';
$lang['page_time'] =                     '[time|%d.%m.%Y, %H:%M]'; //'[time|%A, %B %d, %Y, %H:%M]';
$lang['include_news_time'] =             '[time|%d.%m.%Y, %H:%M]'; //'[time|%B %e, %Y]';
$lang['submit_button_ok'] =              '&nbsp;OK&nbsp;';
$lang['page_last_modified'] =            '<!--Created: [created|%Y-%m-%d, %H:%M] - -->Last modified: [last_modified|%Y-%m-%d, %H:%M]';
$lang['no_comments'] =                   'brak komentarzy';
$lang['one_comment'] =                   '1 komentarz';
$lang['several_comments'] =              '[comments] komentarzy';
$lang['number_of_comments'][0] =         'brak komentarzy';
$lang['number_of_comments'][1] =         '1 komentarz';
$lang['number_of_comments'][2] =         '[comments] komentarzy';
$lang['pagination'] =                    'Strona [current_page] z [total_pages]';
$lang['edit'] =                          'edytuj';
$lang['delete'] =                        'usuń';
$lang['all_categories'] =                'pokaż wszystkie kategorie';

// Admin Menu:
$lang['admin_menu_home'] =               'Strona główna';
$lang['admin_menu_admin'] =              'Panel administracyjny';
$lang['admin_menu_page_overview'] =      'Podgląd strony';
$lang['admin_menu_new_page'] =           'Utwórz nową stronę';
$lang['admin_menu_logout'] =             'Wyloguj.';
$lang['admin_menu_act_page_actions'] =   'Strona:';
$lang['admin_menu_edit_page'] =          'Edytuj';
$lang['admin_menu_delete_page'] =        'Usuń';
$lang['admin_menu_delete_page_conf'] =   'Czy na pewno chcesz usunąć tą stronę?';

// Comments:
$lang['comment_headline'] =              'Komentarze';
$lang['pingback_headline'] =             'Pingbacks';
$lang['comment_no_comments'] =           'Brak komentarzy.';
$lang['comments_closed'] =               'Komentowanie nie jest możliwe.';
$lang['comment_time'] =                  '[time|%d.%m.%Y, %H:%M]'; //'[time|%A, %B %d, %Y, %H:%M]';
$lang['comments_pagination_info'] =      '[total_comments] komentarze, strona [current_page] z [total_pages]';
$lang['comments_add_comment'] =          'Dodaj komentarz';
$lang['comment_input_text'] =            'Dodaj komentarz:';
$lang['comment_edit_text'] =             'Edytuj komentarz:';
$lang['comment_input_name'] =            'Imię';
$lang['comment_input_email_hp'] =        'Adres e-mail lub strona domowa';
$lang['comment_input_submit'] =          '&nbsp;OK&nbsp;';
$lang['comment_input_preview'] =         'Podgląd';
$lang['comment_preview_hl'] =            'Podgląd:';
$lang['error_not_accepted_word'] =       'Nie akceptujemy słowa: [not_accepted_word]';
$lang['error_not_accepted_words'] =      'Nie akceptujemy słów: [not_accepted_words]';
$lang['comment_error_closed'] =          'Komentowanie zostało zabronione!';
$lang['comment_error_no_name'] =         'Nie podano Imienia';
$lang['comment_error_no_text'] =         'Komentarz nie został napisany';
$lang['comment_error_name_too_long'] =   'Imię jest zbyt długie';
$lang['comment_error_email_hp_too_long'] = 'Adres e-mail lub strona są za długie';
$lang['comment_error_email_hp_invalid'] = 'Adres e-mail lub strona są nieprawidłowe';
$lang['comment_error_text_too_long'] =   'Tekst jest za długi (zawiera [characters] znaków; maksymalnie: [max_characters] znaków)';
$lang['comment_error_too_long_word'] =   'Za długie słowo: [word]';
$lang['comment_error_too_long_words'] =  'Za długie słowa: [words]';
$lang['comment_error_entry_exists'] =    'Ten wpis już istnieje';
$lang['comment_error_repeated_post'] =   'Z tego IP niedawno został dodany wpis - proszę odczekać chwilę!';
$lang['comment_error_too_fast'] =        'Komentarz został dodany za wszcześnie proszę odczekać chwilę!';
$lang['comment_delete_link'] =           'usuń';
$lang['comment_delete_confirm'] =        'Czy na pewno chcesz usunąć ten komenatarz?';
$lang['comment_edit_link'] =             'edycja';
$lang['comment_note_email'] =            '(opcjonalnie)';
$lang['comments_open'] =                 'odblokuj możliwość komentowania';
$lang['comments_close'] =                'zablokuj możliwość komentowania';
$lang['comment_notification_subject'] =  'Komentarz do [page]';
$lang['comment_notification_message'] =  "[name]\n\n[comment]\n\n[link]";
$lang['pingback_notification_subject'] = 'Pingback to [page]';
$lang['pingback_notification_message'] = "[title]\n[url]\n[link]";

// News:
//$lang['news_time'] =                     '[time|%A, %B %d, %Y, %H:%M]';
$lang['news_time'] =                     '[time|%d.%m.%Y, %H:%M]';
$lang['no_news'] =                       'Brak nowości';

// Notes:
//$lang['note_time'] =                     '[time|%A, %B %d, %Y, %H:%M]';
$lang['note_time'] =                     '[time|%d.%m.%Y, %H:%M]';
$lang['no_notes'] =                      'Brak notatek';

// Formmailer:
$lang['formmailer_label_email'] =        'E-mail:';
$lang['formmailer_label_subject'] =      'Temat:';
$lang['formmailer_label_message'] =      'Wiadomość:';
$lang['formmailer_button_send'] =        'Wyślij wiadomość';
$lang['formmail_error_email_invalid'] =  'Adres e-mail jest nie prawidłowy lub pusty';
$lang['formmail_error_no_message'] =     'Nie napisano wiadomości';
$lang['formmail_error_text_too_long'] =  'Wiadomość jest za długa';
$lang['formmail_error_subj_too_long'] =  'Temat jest za długi';
$lang['formmail_error_mailserver'] =     'Problem z serwerem poczty - proszę spróbować później!';
$lang['formmailer_mail_sent'] =          'Wiadomość została wysłana.';
$lang['formmailer_no_subject'] =         'brak tematu';

// Gallery:
$lang['gallery_no_photo'] =              'Brak zdjęć w galerii';

// Photo:
$lang['photo_headline'] =                'Galeria';
$lang['previous_photo'] =                'Poprzednie zdjęcie';
$lang['next_photo'] =                    'Następne zdjęcie';
$lang['enlarge_photo'] =                 'Powiększ';
$lang['reduce_photo'] =                  'Zmniejsz';
$lang['show_large_photo'] =              'Duże';
$lang['show_large_photo_title'] =        'Pokaż duże zdjęcie';
$lang['back_link'] =                     'wstecz';
$lang['back_title'] =                    'Wróć do &quot;[page]&quot;';
$lang['photo_comment_link_title'] =      'Przeczytaj albo napisz komentarz do tego zdjęcia';

// Simple news:
//$lang['simple_news_time'] =              '[time|%A, %B %e, %Y]';
$lang['simple_news_time'] =              '[time|%d.%m.%Y]';
$lang['simple_news_edit_title'] =        'Tytuł:';
$lang['simple_news_edit_teaser'] =       'Krótki tekst:';
$lang['simple_news_edit_text'] =         'Tekst:';
$lang['simple_news_edit_text_format'] =  'auto formatowanie';
$lang['simple_news_edit_linkname'] =     'Nazwa linku:';
$lang['simple_news_default_linkname'] =  'więcej…';
$lang['simple_news_edit_time'] =         'Data/godzina:';
$lang['simple_news_edit_time_format'] =  'd.m.Y H:i:s';
$lang['simple_news_add_item'] =          'Dodaj wpis';
$lang['simple_news_edit_item'] =         'Edytuj wpis';
$lang['simple_news_delete_confirm'] =    'Usunąć ten wpis?';
$lang['error_news_no_title'] =           'Nie podano tytułu';
$lang['error_news_no_text'] =            'Nie podano tekstu';
$lang['error_news_time_invalid'] =       'Błędny format daty/czasu';
$lang['delete_news_title'] =             'Usuń wpis';
$lang['delete_news_confirm_submit'] =    'OK - Usuń';

// Search:
$lang['search_submit'] =                 'Szukaj';
$lang['search_number_of_results'][0] =   'Nie znaleziono stron';
$lang['search_number_of_results'][1] =   '1 strona znaleziona:';
$lang['search_number_of_results'][2] =   'Znaleziono [pages] stron:';
$lang['search_pagination'] =             '[total_results] wyników, strona [current_page] z [total_pages]';
$lang['search_photo'] =                  'Zdjęcie';
$lang['search_no_results'] =             'Nie znaleziono stron';

// Akismet:
$lang['akismet_error_api_key'] =         'Błędny klucz api akismet (api key)';
$lang['akismet_error_connection'] =      'Błąd połączenia z serwerem akismet - proszę spróbować później';
$lang['akismet_spam_suspicion'] =        'Podejrzenie spamu!';
?>
