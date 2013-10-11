<?php
// Meta informaton:
$lang['lang'] =                          'en';
$lang['charset'] =                       'utf-8';
$lang['locale'] =                        array('en_US.utf8','en','eng');
#$lang['time_format'] =                  '%Y-%m-%d, %H:%M';
#$lang['time_format_full'] =             '%A, %B %d, %Y, %H:%M';
$lang['dir'] =                           'ltr';

// General:
$lang['exception_title'] =               'Error';
$lang['exception_message'] =             'An error occurred while processing this directive.';
$lang['error_headline'] =                'Error:';
$lang['page_time'] =                     '[time|%A, %B %d, %Y, %H:%M]';
$lang['include_news_time'] =             '[time|%B %e, %Y]';
$lang['submit_button_ok'] =              '&nbsp;OK&nbsp;';
$lang['page_last_modified'] =            '<!--Created: [created|%Y-%m-%d, %H:%M] - -->Last modified: [last_modified|%Y-%m-%d, %H:%M]';
$lang['no_comments'] =                   'no comments';
$lang['one_comment'] =                   '1 comment';
$lang['several_comments'] =              '[comments] comments';
$lang['number_of_comments'][0] =         'no comments';
$lang['number_of_comments'][1] =         '1 comment';
$lang['number_of_comments'][2] =         '[comments] comments';
$lang['pagination'] =                    'Page [current_page] of [total_pages]';
$lang['edit'] =                          'edit';
$lang['delete'] =                        'delete';
$lang['all_categories'] =                'show all categories';

// Admin Menu:
$lang['admin_menu_home'] =               'Home';
$lang['admin_menu_admin'] =              'Administration';
$lang['admin_menu_page_overview'] =      'Page overview';
$lang['admin_menu_new_page'] =           'Create new page';
$lang['admin_menu_logout'] =             'Log out';
$lang['admin_menu_act_page_actions'] =   'This page:';
$lang['admin_menu_edit_page'] =          'Edit';
$lang['admin_menu_delete_page'] =        'Delete';
$lang['admin_menu_delete_page_conf'] =   'Do you really want to delete this page?';

// Comments:
$lang['comment_headline'] =              'Comments';
$lang['pingback_headline'] =             'Pingbacks';
$lang['comment_no_comments'] =           'No comments yet.';
$lang['comments_closed'] =               'Comments are closed.';
$lang['comment_time'] =                  '[time|%A, %B %d, %Y, %H:%M]';
$lang['comments_pagination_info'] =      '[total_comments] comments, page [current_page] of [total_pages]';
$lang['comments_add_comment'] =          'Add comment';
$lang['comment_input_text'] =            'Add comment:';
$lang['comment_edit_text'] =             'Edit comment:';
$lang['comment_input_name'] =            'Name:';
$lang['comment_input_email_hp'] =        'E-mail or homepage:';
$lang['comment_input_submit'] =          '&nbsp;OK&nbsp;';
$lang['comment_input_preview'] =         'Preview';
$lang['comment_preview_hl'] =            'Preview:';
$lang['error_not_accepted_word'] =       'Not accepted word: [not_accepted_word]';
$lang['error_not_accepted_words'] =      'Not accepted words: [not_accepted_words]';
$lang['comment_error_closed'] =          'Comments are closed!';
$lang['comment_error_no_name'] =         'No name entered';
$lang['comment_error_no_text'] =         'No comment entered';
$lang['comment_error_name_too_long'] =   'The name is too long';
$lang['comment_error_email_hp_too_long'] = 'E-mail/homepage is too long';
$lang['comment_error_email_hp_invalid'] = 'E-mail/homepage invalid';
$lang['comment_error_text_too_long'] =   'The text is too long ([characters] charcters; maximum: [max_characters] characters)';
$lang['comment_error_too_long_word'] =   'Too long word: [word]';
$lang['comment_error_too_long_words'] =  'Too long words: [words]';
$lang['comment_error_entry_exists'] =    'This entry already exists';
$lang['comment_error_repeated_post'] =   'There has just been entered an entry with this IP - please wait a moment!';
$lang['comment_error_too_fast'] =        'Form was submitted too fast - please try again!';
$lang['comment_delete_link'] =           'delete';
$lang['comment_delete_confirm'] =        'Do you really want to delete this comment?';
$lang['comment_edit_link'] =             'edit';
$lang['comment_note_email'] =            '(optional)';
$lang['comments_open'] =                 'open';
$lang['comments_close'] =                'Close comments';
$lang['comment_notification_subject'] =  'Comment to [page]';
$lang['comment_notification_message'] =  "[name]\n\n[comment]\n\n[link]";
$lang['pingback_notification_subject'] = 'Pingback to [page]';
$lang['pingback_notification_message'] = "[title]\n[url]\n[link]";

// News:
$lang['news_time'] =                     '[time|%A, %B %d, %Y, %H:%M]';
$lang['no_news'] =                       'No news availble';

// Notes:
$lang['note_time'] =                     '[time|%A, %B %d, %Y, %H:%M]';
$lang['no_notes'] =                      'No notes availble';

// Formmailer:
$lang['formmailer_label_email'] =        'E-mail:';
$lang['formmailer_label_subject'] =      'Subject:';
$lang['formmailer_label_message'] =      'Message:';
$lang['formmailer_button_send'] =        'OK - Send';
$lang['formmail_error_email_invalid'] =  'E-mail address invalid or empty';
$lang['formmail_error_no_message'] =     'No message entered';
$lang['formmail_error_text_too_long'] =  'The message is too long';
$lang['formmail_error_subj_too_long'] =  'The subject is too long';
$lang['formmail_error_mailserver'] =     'Mailserver error - please try again later!';
$lang['formmailer_mail_sent'] =          'The message has been sent successfully.';
$lang['formmailer_no_subject'] =         'No subject';

// Gallery:
$lang['gallery_no_photo'] =              'No photo in this gallery';

// Photo:
$lang['photo_headline'] =                'Photo';
$lang['previous_photo'] =                'Previous image';
$lang['next_photo'] =                    'Next image';
$lang['enlarge_photo'] =                 'Enlarge';
$lang['reduce_photo'] =                  'Reduce';
$lang['show_large_photo'] =              'Large';
$lang['show_large_photo_title'] =        'Show large photo';
$lang['back_link'] =                     'back';
$lang['back_title'] =                    'Back to &quot;[page]&quot;';
$lang['photo_comment_link_title'] =      'Read or write comments to this photo';

// Simple news:
$lang['simple_news_time'] =              '[time|%A, %B %e, %Y]';
$lang['simple_news_edit_title'] =        'Title:';
$lang['simple_news_edit_teaser'] =       'Teaser:';
$lang['simple_news_edit_text'] =         'Text:';
$lang['simple_news_edit_text_format'] =  'auto formatting';
$lang['simple_news_edit_linkname'] =     'Link name:';
$lang['simple_news_default_linkname'] =  'more…';
$lang['simple_news_edit_time'] =         'Date/time:';
$lang['simple_news_edit_time_format'] =  '(YYYY-MM-DD HH:MM:SS)';
$lang['simple_news_add_item'] =          'Add entry';
$lang['simple_news_edit_item'] =         'Edit item';
$lang['simple_news_delete_confirm'] =    'Do you really want to delete this entry?';
$lang['error_news_no_title'] =           'No title specified';
$lang['error_news_no_text'] =            'No text entered';
$lang['error_news_time_invalid'] =       'invalid date/time format';
$lang['delete_news_title'] =             'Delete entry';
$lang['delete_news_confirm_submit'] =    'OK - Delete';

// Newsletter:
$lang['newsletter_subscr_email'] =       'E-mail address:';
$lang['newsletter_subscribe'] =          'subscribe';
$lang['newsletter_unsubscribe'] =        'unsubscribe';
$lang['newsletter_email'] =              'E-mail';
$lang['newsletter_subscribe_time'] =     'Subscribed';
$lang['newsletter_subscribe_time_format'] = '[time|%d.%m.%Y, %H:%M]';
$lang['newsletter_error_invalid_email'] = 'E-mail address invalid';
$lang['newsletter_error_email_exists'] = 'This e-mail address already exists';
$lang['newsletter_error_email_not_exist'] = 'The e-mail address doesn\'t exist';
$lang['newsletter_error_mail'] =         'Error while sending e-mail - please try again later';
$lang['newsletter_conf_ok'] =            'Thank you! Your e-mail address has been confirmed.';
$lang['newsletter_delete_ok'] =          'You have successfully unsubscribed from the newsletter!';
$lang['newsletter_conf_failed'] =        '<b>Error:</b> Invalid confirmation link (e.g. time period expired)!';
$lang['newsletter_conf_mail_sent'] =     'An e-mail with a confirmation link has been sent to the specified e-mail address. Please confirm this link within one hour!';
$lang['newsletter_email_delete'] =       'delete';
$lang['newsletter_no_emails'] =          'No e-mail addresses available.';
$lang['newsletter_add_email'] =          'Add e-mail address:';
$lang['newsletter_email_list'] =         'E-mail list';
$lang['newsletter_edit_emails'] =        'Edit e-mail addresses';
$lang['newsletter_email_count'] =        '[number] e-mail addresses';
$lang['newsletter_subscribe_subj'] =     'Subscribe to newsletter';
$lang['newsletter_subscribe_text'] =     "Your e-mail address has been added to our mailing list. Please click the link below to confirm your request. If this e-mail has been sent in error (either by you or someone else) please ignore this e-mail.\n\nLink to confirm the subscription:\n[link]";
$lang['newsletter_unsubscribe_subj'] =   'Unsubscribe to newsletter';
$lang['newsletter_unsubscribe_text'] =   "Please click the following link to unsubscribe to the newsletter:\n[link]";
$lang['newsletter_checkall'] =           'check all';
$lang['newsletter_uncheckall'] =         'uncheck all';
$lang['newsletter_delete_checked'] =     'Delete checked';
$lang['newsletter_delete_confirm'] =     'Delete e-mail(s)?';
$lang['newsletter_delete_confirm_submit'] = 'OK - Delete';

// Search:
$lang['search_submit'] =                 'Search';
$lang['search_number_of_results'][0] =   'No pages found';
$lang['search_number_of_results'][1] =   '1 page found:';
$lang['search_number_of_results'][2] =   '[pages] pages found:';
$lang['search_pagination'] =             '[total_results] results, page [current_page] of [total_pages]';
$lang['search_photo'] =                  'Photo';
$lang['search_no_results'] =             'No pages found';

// Akismet:
$lang['akismet_error_api_key'] =         'Invalid akismet api key';
$lang['akismet_error_connection'] =      'Server connection error - please try again later';
$lang['akismet_spam_suspicion'] =        'Spam suspicion!'
?>
