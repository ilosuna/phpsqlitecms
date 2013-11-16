<?php
// Meta informaton:
$lang['lang'] =                          'es';
$lang['charset'] =                       'utf-8';
$lang['locale'] =                        array('es_ES.utf8','es','esp');
$lang['dir'] =                           'ltr';

// General:
$lang['exception_title'] =               'Error';
$lang['exception_message'] =             'Se ha producido un error procesando esta directiva.';
$lang['error_headline'] =                'Error:';
$lang['page_time'] =                     '[time|%d/%m/%y, %H:%M]';
$lang['include_news_time'] =             '[time|%d/%m/%y, %H:%M]';
$lang['submit_button_ok'] =              '&nbsp;OK&nbsp;';
$lang['page_last_modified'] =            '<!--Creada: [created|%d/%m/%y, %H:%M] - -->Última modificación: [last_modified|%d/%m/%y, %H:%M]';
$lang['no_comments'] =                   'sin comentarios';
$lang['one_comment'] =                   '1 comentario';
$lang['several_comments'] =              '[comments] comentarios';
$lang['number_of_comments'][0] =         'sin comentarios';
$lang['number_of_comments'][1] =         '1 comentario';
$lang['number_of_comments'][2] =         '[comments] comentarios';
$lang['pagination'] =                    'Página [current_page] de [total_pages]';
$lang['edit'] =                          'editar';
$lang['delete'] =                        'borrar';
$lang['all_categories'] =                'mostrar todas las categorías';

// Admin Menu:
$lang['admin_menu_home'] =               'Inicio';
$lang['admin_menu_admin'] =              'Administración';
$lang['admin_menu_page_overview'] =      'Relación de páginas';
$lang['admin_menu_new_page'] =           'Crear una nueva página';
$lang['admin_menu_logout'] =             'Cerrar sesión';
$lang['admin_menu_act_page_actions'] =   'Esta página:';
$lang['admin_menu_edit_page'] =          'Editar';
$lang['admin_menu_delete_page'] =        'Borrar';
$lang['admin_menu_delete_page_conf'] =   '¿Está seguro de que desea borrar esta página?';

// Comments:
$lang['comment_headline'] =              'Comentarios';
$lang['pingback_headline'] =             'Pingbacks';
$lang['comment_no_comments'] =           'Sin comentarios por el momento.';
$lang['comments_closed'] =               'No se permite añadir nuevos comentarios.';
$lang['comment_time'] =                  '[time|%d/%m/%y, %H:%M]';
$lang['comments_pagination_info'] =      '[total_comments] comentarios, página [current_page] de [total_pages]';
$lang['comments_add_comment'] =          'Añadir comentario';
$lang['comment_input_text'] =            'Comentario:';
$lang['comment_edit_text'] =             'Editar comentario:';
$lang['comment_input_name'] =            'Nombre:';
$lang['comment_input_email_hp'] =        'Correo electrónico o página web:';
$lang['comment_input_submit'] =          '&nbsp;OK&nbsp;';
$lang['comment_input_preview'] =         'Vista previa';
$lang['comment_preview_hl'] =            'Vista previa:';
$lang['error_not_accepted_word'] =       'No se acepta la palabra: [not_accepted_word]';
$lang['error_not_accepted_words'] =      'No se aceptan las palabras: [not_accepted_words]';
$lang['comment_error_closed'] =          '¡No se permite añadir nuevos comentarios!';
$lang['comment_error_no_name'] =         'No ha introducido el nombre';
$lang['comment_error_no_text'] =         'No ha introducido el comentario';
$lang['comment_error_name_too_long'] =   'El nombre es demasiado largo';
$lang['comment_error_email_hp_too_long'] = 'La dirección de correo electrónico o la URL de la página web es demasiado larga';
$lang['comment_error_email_hp_invalid'] = 'La dirección de correo electrónico o la URL de la página web no es válida';
$lang['comment_error_text_too_long'] =   'El texto es demasiado largo ([characters] caracteres; máximo: [max_characters] caracteres)';
$lang['comment_error_too_long_word'] =   'Esta palabra es demasiado larga: [word]';
$lang['comment_error_too_long_words'] =  'Estas palabras son demasiado largas: [words]';
$lang['comment_error_entry_exists'] =    'Esta entrada ya existe';
$lang['comment_error_repeated_post'] =   'Acaba de introducir una entrada con la misma dirección IP - por favor ¡espere un momento!';
$lang['comment_error_too_fast'] =        'El formulario se ha enviado demasiado rápido - por favor ¡inténtelo de nuevo!';
$lang['comment_delete_link'] =           'borrar';
$lang['comment_delete_confirm'] =        '¿Está seguro de que desea borrar este comentario?';
$lang['comment_edit_link'] =             'editar';
$lang['comment_note_email'] =            '(opcional)';
$lang['comments_open'] =                 'abrir';
$lang['comments_close'] =                'Cerrar los comentarios';
$lang['comment_notification_subject'] =  'Comentario a [page]';
$lang['comment_notification_message'] =  "[name]\n\n[comment]\n\n[link]";
$lang['pingback_notification_subject'] = 'Pingback a [page]';
$lang['pingback_notification_message'] = "[title]\n[url]\n[link]";

// News:
$lang['news_time'] =                     '[time|%d/%m/%y, %H:%M]';
$lang['no_news'] =                       'No hay noticias';

// Notes:
$lang['note_time'] =                     '[time|%d/%m/%y, %H:%M]';
$lang['no_notes'] =                      'No hay notas';

// Formmailer:
$lang['formmailer_label_email'] =        'Dirección de correo electrónico:';
$lang['formmailer_label_subject'] =      'Asunto:';
$lang['formmailer_label_message'] =      'Mensaje:';
$lang['formmailer_button_send'] =        'OK - Enviar';
$lang['formmail_error_email_invalid'] =  'La dirección de correo electrónico no es válida';
$lang['formmail_error_no_message'] =     'No ha introducido el mensaje';
$lang['formmail_error_text_too_long'] =  'El mensaje es demasiado largo';
$lang['formmail_error_subj_too_long'] =  'El asunto es demasiado largo';
$lang['formmail_error_mailserver'] =     'Se ha producido un error en el servidor de correo - por favor ¡inténtelo de nuevo más tarde!';
$lang['formmailer_mail_sent'] =          'El mensaje se ha enviado correctamente.';
$lang['formmailer_no_subject'] =         'sin asunto';

// Gallery:
$lang['gallery_no_photo'] =              'No hay ninguna foto en este álbum';

// Photo:
$lang['photo_headline'] =                'Foto';
$lang['previous_photo'] =                'Imagen anterior';
$lang['next_photo'] =                    'Imagen siguiente';
$lang['enlarge_photo'] =                 'Aumentar';
$lang['reduce_photo'] =                  'Reducir';
$lang['show_large_photo'] =              'Grande';
$lang['show_large_photo_title'] =        'Mostrar foto grande';
$lang['back_link'] =                     'atrás';
$lang['back_title'] =                    'Ir a &quot;[page]&quot;';
$lang['photo_comment_link_title'] =      'Ver los comentarios de esta foto o escribir un nuevo comentario';

// Simple news:
$lang['simple_news_time'] =              '[time|%d/%m/%y, %H:%M]';
$lang['simple_news_edit_title'] =        'Título de la noticia:';
$lang['simple_news_edit_teaser'] =       'Entradilla:';
$lang['simple_news_edit_text'] =         'Texto:';
$lang['simple_news_edit_text_format'] =  'auto formato';
$lang['simple_news_edit_linkname'] =     'Texto del enlace para leer artículo completo:';
$lang['simple_news_default_linkname'] =  'Leer más…';
$lang['simple_news_edit_time'] =         'Fecha/hora:';
$lang['simple_news_edit_time_format'] =  '(AAAA-MM-DD HH:MM:SS)';
$lang['simple_news_add_item'] =          'Añadir entrada';
$lang['simple_news_edit_item'] =         'Editar ítem';
$lang['simple_news_delete_confirm'] =    '¿Está seguro de que desea borrar esta noticia?';
$lang['error_news_no_title'] =           'No se ha introducido el título';
$lang['error_news_no_text'] =            'No se ha introducido el texto';
$lang['error_news_time_invalid'] =       'la fecha y/o la hora no tienen el formato correcto';
$lang['delete_news_title'] =             'Borrar entrada';
$lang['delete_news_confirm_submit'] =    'OK - Borrar';

// Search:
$lang['search_submit'] =                 'Buscar';
$lang['search_number_of_results'][0] =   'No se ha encontrado ninguna página';
$lang['search_number_of_results'][1] =   'Se ha encontrado 1 página:';
$lang['search_number_of_results'][2] =   'Se ha encontrado [pages] páginas:';
$lang['search_pagination'] =             '[total_results] resultados, página [current_page] de [total_pages]';
$lang['search_photo'] =                  'Foto';
$lang['search_no_results'] =             'No se ha encontrado ninguna página';

// Akismet:
$lang['akismet_error_api_key'] =         'La clave del API Akismet es incorrecta';
$lang['akismet_error_connection'] =      'Error de conexión al servidor - por favor, inténtelo de nuevo más tarde';
$lang['akismet_spam_suspicion'] =        '¡Sospecha de Spam!';
?>
