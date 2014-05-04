<?php if (isset($invalid_request)): ?>

    <p class="caution"><?php if (isset($lang[$invalid_request])) echo $lang[$invalid_request]; else echo $invalid_request; ?></p>

<?php else: ?>

    <form id="content-form" action="index.php" method="post" class="form-horizontal">
    <div>
    <input type="hidden" name="mode" value="edit"/>
    <?php if (isset($page_data['id'])): ?>
        <input type="hidden" name="id" value="<?php echo $page_data['id']; ?>"/>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-10">
            <?php if (isset($page_data['id'])): ?>
                <h1><?php echo str_replace('[page]', '<a href="' . BASE_URL . $page_data['page'] . '">' . $page_data['page'] . '</a>', $lang['edit_page_headline']); ?></h1>
            <?php else: ?>
                <h1><?php echo $lang['create_new_page_headline']; ?></h1>
            <?php endif; ?>
        </div>
        <div class="col-md-2">
            <button class="btn btn-lg btn-success btn-top pull-right"><span
                    class="glyphicon glyphicon-save"></span> <?php echo $lang['edit_page_submit']; ?></button>
        </div>
    </div>

    <?php include('errors.inc.tpl'); ?>

    <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#page-content" data-toggle="tab"><?php echo $lang['content_marking']; ?></a></li>
        <li><a href="#sidebars" data-toggle="tab"><?php echo $lang['sidebars_marking']; ?></a></li>
        <li><a href="#properties" data-toggle="tab"><?php echo $lang['properties_marking']; ?></a></li>
        <li><a href="#include" data-toggle="tab"><?php echo $lang['include_marking']; ?></a></li>
        <li><a href="#notes" data-toggle="tab"><?php echo $lang['page_notes_marking']; ?></a></li>
    </ul>

    <div id="myTabContent" class="tab-content">
    <div class="tab-pane active" id="page-content">

        <div class="form-group">
            <label for="page"
                   class="col-lg-1 control-label control-label-left"><?php echo $lang['edit_page_name_marking']; ?></label>

            <div class="col-lg-11">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo BASE_URL; ?></span>
                    <input id="page" type="text" name="page"
                           value="<?php if (isset($page_data['page'])) echo $page_data['page']; ?>" size="50"
                           class="form-control"/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="title"
                   class="col-lg-1 control-label control-label-left"><?php echo $lang['edit_title_marking']; ?></label>

            <div class="col-lg-11">
                <input id="title" type="text" name="title"
                       value="<?php if (isset($page_data['title'])) echo $page_data['title']; ?>" size="50"
                       class="form-control"/>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-12">
                <label for="content"><?php echo $lang['edit_content_marking']; ?></label>

                <?php if (isset($wysiwyg)): ?>
                    <a id="wysiwyg-toggle" class="btn btn-default btn-xs active pull-right"
                       href="index.php?mode=edit<?php if (isset($page_data['id'])): ?>&amp;id=<?php echo $page_data['id']; ?><?php endif; ?>&amp;disable_wysiwyg=true"
                       title="<?php echo $lang['disable_wysiwyg_editor']; ?>"
                       data-confirm-link="<?php echo rawurlencode($lang['change_edit_mode_notice']); ?>"><?php echo $lang['wysiwyg_label']; ?></a>
                <?php else: ?>
                    <a id="wysiwyg-toggle" class="btn btn-default btn-xs pull-right"
                       href="index.php?mode=edit<?php if (isset($page_data['id'])): ?>&amp;id=<?php echo $page_data['id']; ?><?php endif; ?>&amp;enable_wysiwyg=true"
                       title="<?php echo $lang['enable_wysiwyg_editor']; ?>"
                       data-confirm-link="<?php echo rawurlencode($lang['change_edit_mode_notice']); ?>"><?php echo $lang['wysiwyg_label']; ?></a>
                <?php endif; ?>

                <textarea id="content" name="content" cols="100" rows="28"
                          class="form-control html"><?php if (isset($page_data['content'])) echo $page_data['content']; ?></textarea>
            </div>
        </div>

        <?php if (empty($wysiwyg)): ?>
            <div class="form-group">
                <div class="col-lg-12">
                    <a class="btn btn-default btn-xs" href="index.php?mode=modal&amp;action=insert_image"
                       data-toggle="modal" data-target="#modal_image" data-insert="#content"
                       title="<?php echo $lang['insert_image_label']; ?>"><span
                            class="glyphicon glyphicon-picture"></span></a>
                    <a class="btn btn-default btn-xs" href="index.php?mode=modal&amp;action=insert_thumbnail"
                       data-toggle="modal" data-target="#modal_thumbnail" data-insert="#content"
                       title="<?php echo $lang['insert_thumbnail_label']; ?>"><span
                            class="glyphicon glyphicon-hand-left"></span></a>
                    <a class="btn btn-default btn-xs" href="index.php?mode=modal&amp;action=insert_gallery"
                       data-toggle="modal" data-target="#modal_gallery" data-insert="#content"
                       title="<?php echo $lang['insert_gallery_label']; ?>"><span class="glyphicon glyphicon-th"></span></a>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <div class="tab-pane" id="sidebars">

        <div class="form-group">
            <div class="col-lg-12">
                <label for="sidebar_1"><?php echo $lang['edit_sidebar_1_marking']; ?></label>
                <textarea id="sidebar_1" name="sidebar_1" cols="70" rows="13"
                          class="form-control html"><?php if (isset($page_data['sidebar_1'])) echo $page_data['sidebar_1']; ?></textarea>
            </div>
        </div>
        <!--<div class="checkbox">
<label for="sidebar_1_formatting">
<input id="sidebar_1_formatting" type="checkbox" name="sidebar_1_formatting" value="1"<?php if (isset($page_data['sidebar_1_formatting']) && $page_data['sidebar_1_formatting'] == 1): ?> checked="checked"'<?php endif; ?> /> <?php echo $lang['edit_formatting']; ?>
</label>
</div>-->

        <div class="form-group">
            <div class="col-lg-12">
                <label for="sidebar_2"><?php echo $lang['edit_sidebar_2_marking']; ?></label>
                <textarea id="sidebar_2" name="sidebar_2" cols="70" rows="13"
                          class="form-control html"><?php if (isset($page_data['sidebar_1'])) echo $page_data['sidebar_2']; ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-12">
                <label for="sidebar_3"><?php echo $lang['edit_sidebar_3_marking']; ?></label>
                <textarea id="sidebar_3" name="sidebar_3" cols="70" rows="13"
                          class="form-control html"><?php if (isset($page_data['sidebar_1'])) echo $page_data['sidebar_3']; ?></textarea>
            </div>
        </div>

    </div>

    <div class="tab-pane fade" id="properties">

    <div class="form-group">
        <label for="page_title" class="col-lg-2 control-label"><?php echo $lang['edit_page_title_marking']; ?></label>

        <div class="col-lg-10">
            <input id="page_title" type="text" name="page_title"
                   value="<?php if (isset($page_data['page_title'])) echo $page_data['page_title']; ?>" size="50"
                   class="form-control form-control-inline form-control-default"/>
        </div>
    </div>

    <div class="form-group">
        <label for="type" class="col-lg-2 control-label"><?php echo $lang['edit_type_marking']; ?></label>

        <div class="col-lg-10">
            <select id="type" name="type" size="1" class="form-control form-control-inline form-control-default">
                <?php foreach ($page_types as $key => $val): ?>
                    <option
                        value="<?php echo $key; ?>"<?php if (isset($page_data['type']) && $page_data['type'] == $key): ?> selected="selected"<?php endif; ?>><?php if (isset($lang[$val['page_type_label']])) echo $lang[$val['page_type_label']]; else echo $val['page_type_label']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="type_addition"
                   value="<?php if (isset($page_data['type_addition'])) echo $page_data['type_addition']; ?>"
                   placeholder="<?php echo $lang['edit_type_addition_marking']; ?>" size="40"
                   class="form-control form-control-inline form-control-medium"/>
        </div>
    </div>

    <div class="form-group">
        <label for="time" class="col-lg-2 control-label"><?php echo $lang['edit_time_marking']; ?></label>

        <div class="col-lg-10">
            <input id="time" type="text" name="time"
                   value="<?php if (isset($page_data['time'])) echo $page_data['time']; ?>"
                   placeholder="<?php echo $lang['edit_time_format']; ?>" size="20"
                   class="form-control form-control-inline form-control-default"/>
        </div>
    </div>

    <div class="form-group">
        <label for="last_modified"
               class="col-lg-2 control-label"><?php echo $lang['edit_last_modified_marking']; ?></label>

        <div class="col-lg-10">
            <input id="last_modified" type="text" name="last_modified"
                   value="<?php if (isset($page_data['last_modified'])) echo $page_data['last_modified']; ?>"
                   placeholder="<?php echo $lang['edit_time_format']; ?>" size="20"
                   class="form-control form-control-inline form-control-default"/>


            <div class="checkbox">
                <label for="display_time">
                    <input type="checkbox" id="display_time" name="display_time"
                           value="1"<?php if (isset($page_data['display_time']) && $page_data['display_time'] == 1): ?> checked="checked"<?php endif; ?> /> <?php echo $lang['edit_display_time_label']; ?>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="menu_1" class="col-lg-2 control-label"><?php echo $lang['edit_menus_marking']; ?></label>

        <div class="col-lg-10">
            <select id="menu_1" name="menu_1" size="1" class="form-control form-control-inline form-control-medium">
                <option value="">#1</option>
                <?php if (isset($menus)): ?>
                    <?php foreach ($menus as $menu): ?>
                        <option
                            value="<?php echo $menu; ?>"<?php if (isset($page_data['menu_1']) && $page_data['menu_1'] == $menu): ?> selected="selected"<?php endif; ?>><?php echo $menu; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <select name="menu_2" size="1" class="form-control form-control-inline form-control-medium">
                <option value="">#2</option>
                <?php if (isset($menus)): ?>
                    <?php foreach ($menus as $menu): ?>
                        <option
                            value="<?php echo $menu; ?>"<?php if (isset($page_data['menu_2']) && $page_data['menu_2'] == $menu): ?> selected="selected"<?php endif; ?>><?php echo $menu; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <select name="menu_3" size="1" class="form-control form-control-inline form-control-medium">
                <option value="">#3</option>
                <?php if (isset($menus)): ?>
                    <?php foreach ($menus as $menu): ?>
                        <option
                            value="<?php echo $menu; ?>"<?php if (isset($page_data['menu_3']) && $page_data['menu_3'] == $menu): ?> selected="selected"<?php endif; ?>><?php echo $menu; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="menu_1" class="col-lg-2 control-label"><?php echo $lang['edit_sections_marking']; ?></label>

        <div class="col-lg-10">
            <input id="sections" type="text" name="sections"
                   value="<?php if (isset($page_data['sections'])) echo $page_data['sections']; ?>"
                   placeholder="<?php echo $lang['values_comma_separated']; ?>" size="40"
                   class="form-control form-control-inline form-control-default"/>
        </div>
    </div>

    <div class="form-group">
        <label for="breadcrumbs_0" class="col-lg-2 control-label"><?php echo $lang['breadcrumbs']; ?></label>

        <div class="col-lg-10">
            <?php for ($i = 0; $i < $settings['breadcrumbs']; ++$i): ?>
                <select id="breadcrumbs_<?php echo $i; ?>" name="breadcrumbs[]" size="1"
                        class="form-control form-control-inline form-control-small">
                    <option
                        value=""<?php if (empty($page_data['breadcrumbs'][$i])): ?> selected="selected"<?php endif; ?>>
                        &nbsp;</option>
                    <?php foreach ($pages as $breadcrumb_page): ?>
                        <option
                            value="<?php echo $breadcrumb_page['id']; ?>"<?php if (isset($page_data['breadcrumbs'][$i]) && $page_data['breadcrumbs'][$i] == $breadcrumb_page['id']): ?> selected="selected"<?php endif; ?>><?php echo $breadcrumb_page['page']; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if ($i < $settings['breadcrumbs'] - 1): ?> &raquo; <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label"><?php echo $lang['edit_description_marking']; ?></label>

        <div class="col-lg-10">
            <input id="description" type="text" name="description"
                   value="<?php if (isset($page_data['description'])) echo $page_data['description']; ?>" size="60"
                   class="form-control form-control-large"/>
        </div>
    </div>

    <div class="form-group">
        <label for="keywords" class="col-lg-2 control-label"><?php echo $lang['edit_keywords_marking']; ?></label>

        <div class="col-lg-10">
            <input id="keywords" type="text" name="keywords"
                   value="<?php if (isset($page_data['keywords'])) echo $page_data['keywords']; ?>"
                   placeholder="<?php echo $lang['values_comma_separated']; ?>" size="60"
                   class="form-control form-control-large"/>
        </div>
    </div>

    <div class="form-group">
        <label for="page_info" class="col-lg-2 control-label"><?php echo $lang['edit_page_info_marking']; ?></label>

        <div class="col-lg-10">
            <input id="page_info" type="text" name="page_info"
                   value="<?php if (isset($page_data['page_info'])) echo $page_data['page_info']; ?>" size="60"
                   class="form-control form-control-default"/>
        </div>
    </div>

    <div class="form-group">
        <label for="gcb_1" class="col-lg-2 control-label"><?php echo $lang['edit_gcb_marking']; ?></label>

        <div class="col-lg-10">
            <select id="gcb_1" name="gcb_1" size="1" class="form-control form-control-inline form-control-medium">
                <option value="">#1</option>
                <?php if (isset($gcbs)): ?>
                    <?php foreach ($gcbs as $gcb): ?>
                        <option
                            value="<?php echo $gcb['identifier']; ?>"<?php if (isset($page_data['gcb_1']) && $page_data['gcb_1'] == $gcb['identifier']): ?> selected<?php endif; ?>><?php echo $gcb['identifier']; ?></option>
                    <?php endforeach ?>
                <?php endif; ?>
            </select>
            <select name="gcb_2" size="1" class="form-control form-control-inline form-control-medium">
                <option value="">#2</option>
                <?php if (isset($gcbs)): ?>
                    <?php foreach ($gcbs as $gcb): ?>
                        <option
                            value="<?php echo $gcb['identifier']; ?>"<?php if (isset($page_data['gcb_2']) && $page_data['gcb_2'] == $gcb['identifier']): ?> selected<?php endif; ?>><?php echo $gcb['identifier']; ?></option>
                    <?php endforeach ?>
                <?php endif; ?>
            </select>
            <select name="gcb_3" size="1" class="form-control form-control-inline form-control-medium">
                <option value="">#3</option>
                <?php if (isset($gcbs)): foreach ($gcbs as $gcb): ?>
                    <option
                        value="<?php echo $gcb['identifier']; ?>"<?php if (isset($page_data['gcb_3']) && $page_data['gcb_3'] == $gcb['identifier']): ?> selected<?php endif; ?>><?php echo $gcb['identifier']; ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="template" class="col-lg-2 control-label"><?php echo $lang['edit_template_marking']; ?></label>

        <div class="col-lg-10">
            <select id="template" name="template" size="1" class="form-control form-control-default">
                <?php if (isset($template_files)): foreach ($template_files as $template_file): ?>
                    <option
                        value="<?php echo $template_file; ?>"<?php if ($page_data['template'] == $template_file): ?> selected="selected"<?php endif; ?>> <?php echo $template_file; ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="language" class="col-lg-2 control-label"><?php echo $lang['page_language']; ?></label>

        <div class="col-lg-10">
            <select id="language" name="language" size="1" class="form-control form-control-default">
                <option
                    value=""<?php if (empty($page_data['language'])): ?> selected="selected"<?php endif; ?>><?php echo $lang['page_language_default']; ?></option>
                <?php if (isset($page_languages)): foreach ($page_languages as $page_language): ?>
                    <option
                        value="<?php echo $page_language['identifier']; ?>"<?php if (isset($page_data['language']) && $page_data['language'] == $page_language['identifier']): ?> selected="selected"<?php endif; ?>> <?php echo $page_language['name']; ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="content_type" class="col-lg-2 control-label"><?php echo $lang['page_content_type']; ?></label>

        <div class="col-lg-10">
            <input id="content_type" type="text" name="content_type"
                   value="<?php if (isset($page_data['content_type'])) echo $page_data['content_type']; ?>"
                   placeholder="<?php echo $lang['page_content_type_exp']; ?>" size="20"
                   class="form-control form-control-default"/>
        </div>
    </div>

    <div class="form-group">
        <label for="tv" class="col-lg-2 control-label"><?php echo $lang['template_variables']; ?></label>

        <div class="col-lg-10">
            <input type="text" id="tv" name="tv" value="<?php if (isset($page_data['tv'])) echo $page_data['tv']; ?>"
                   placeholder="<?php echo $lang['values_comma_separated']; ?>"
                   class="form-control form-control-default" size="40"/>
        </div>
    </div>

    <div class="form-group">
        <label for="edit_permission" class="col-lg-2 control-label"><?php echo $lang['edit_permission']; ?></label>

        <div class="col-lg-10">
            <input type="text" id="edit_permission" name="edit_permission"
                   value="<?php if (isset($page_data['edit_permission'])) echo $page_data['edit_permission']; ?>"
                   placeholder="<?php echo $lang['values_comma_separated']; ?>"
                   class="form-control form-control-default" size="40"/>

            <div class="checkbox">
                <label for="edit_permission_general">
                    <input id="edit_permission_general" type="checkbox" name="edit_permission_general"
                           value="1"<?php if (isset($page_data['edit_permission_general']) && $page_data['edit_permission_general'] == 1): ?> checked="checked"<?php endif; ?> /> <?php echo $lang['edit_permission_general']; ?>
                </label>
            </div>
        </div>
    </div>


    <div class="form-group">
        <strong class="col-lg-2 control-label"><?php echo $lang['status']; ?></strong>

        <div class="col-lg-10">
            <div class="radio">
                <label for="status_2"><input id="status_2" type="radio" name="status"
                                             value="2"<?php if (isset($page_data['status']) && $page_data['status'] == 2): ?> checked="checked"<?php endif; ?> /><?php echo $lang['status_published_searchable']; ?>
                </label><br/>
                <label for="status_1"><input id="status_1" type="radio" name="status"
                                             value="1"<?php if (isset($page_data['status']) && $page_data['status'] == 1): ?> checked="checked"<?php endif; ?> /> <?php echo $lang['status_published']; ?>
                </label><br/>
                <label for="status_0"><input id="status_0" type="radio" name="status"
                                             value="0"<?php if (isset($page_data['status']) && $page_data['status'] == 0): ?> checked="checked"<?php endif; ?> /> <?php echo $lang['status_draft']; ?>
                </label>
            </div>
        </div>
    </div>

    </div>


    <div class="tab-pane fade" id="include">


        <div class="form-group">
            <label for="include_page"
                   class="col-lg-2 control-label"><?php echo $lang['edit_include_in_marking']; ?></label>

            <div class="col-lg-10">
                <select id="include_page" name="include_page" size="1"
                        class="form-control form-control-inline form-control-medium">
                    <option
                        value=""<?php if (empty($page_data['include_page'])): ?> selected="selected"<?php endif; ?>><?php echo $lang['edit_include_page_marking']; ?></option>
                    <?php foreach ($pages as $include_page): if ($include_page['type'] == 'overview' || $include_page['type'] == 'news'): ?>
                        <option
                            value="<?php echo $include_page['id']; ?>"<?php if (isset($page_data['include_page']) && $page_data['include_page'] == $include_page['id']): ?> selected="selected"<?php endif; ?>><?php echo $include_page['page']; ?></option>
                    <?php endif; endforeach; ?>
                </select>
                <select name="include_rss" size="1" class="form-control form-control-inline form-control-medium">
                    <option
                        value=""<?php if (empty($page_data['include_rss'])): ?> selected="selected"<?php endif; ?>><?php echo $lang['edit_include_rss_marking']; ?></option>
                    <?php foreach ($pages as $include_rss): if ($include_rss['type'] == 'rss'): ?>
                        <option
                            value="<?php echo $include_rss['id']; ?>"<?php if (isset($page_data['include_rss']) && $page_data['include_rss'] == $include_rss['id']): ?> selected="selected"<?php endif; ?>><?php echo $include_rss['page']; ?></option>
                    <?php endif; endforeach; ?>
                </select>
                <select name="include_sitemap" size="1" class="form-control form-control-inline form-control-medium">
                    <option
                        value=""<?php if (empty($page_data['include_sitemap'])): ?> selected="selected"<?php endif; ?>><?php echo $lang['edit_include_sitemap_marking']; ?></option>
                    <?php foreach ($pages as $include_sitemap): if ($include_sitemap['type'] == 'sitemap'): ?>
                        <option
                            value="<?php echo $include_sitemap['id']; ?>"<?php if (isset($page_data['include_sitemap']) && $page_data['include_sitemap'] == $include_sitemap['id']): ?> selected="selected"<?php endif; ?>><?php echo $include_sitemap['page']; ?></option>
                    <?php endif; endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="include_order"
                   class="col-lg-2 control-label"><?php echo $lang['edit_order_number_marking']; ?></label>

            <div class="col-lg-9">
                <input type="text" id="include_order" name="include_order"
                       value="<?php echo $page_data['include_order']; ?>" size="35"
                       class="form-control form-control-small">
            </div>
        </div>

        <div class="form-group">
            <label for="teaser_headline"
                   class="col-lg-2 control-label"><?php echo $lang['edit_teaser_headline_marking']; ?></label>

            <div class="col-lg-9">
                <input type="text" id="teaser_headline" name="teaser_headline"
                       value="<?php if (isset($page_data['teaser_headline'])): ?><?php echo $page_data['teaser_headline']; ?><?php endif; ?>"
                       size="35" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="teaser" class="col-lg-2 control-label"><?php echo $lang['edit_teaser_marking']; ?></label>

            <div class="col-lg-9">
                <textarea id="teaser" name="teaser" cols="75" rows="13"
                          class="form-control"><?php if (isset($page_data['teaser'])) echo $page_data['teaser']; ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="link_name" class="col-lg-2 control-label"><?php echo $lang['edit_include_link']; ?></label>

            <div class="col-lg-9">
                <input type="text" id="link_name" name="link_name"
                       value="<?php if (isset($page_data['link_name'])) echo $page_data['link_name']; ?>" size="35"
                       class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="teaser_img"
                   class="col-lg-2 control-label"><?php echo $lang['edit_teaser_img_marking']; ?></label>

            <div class="col-lg-9">
                <div class="input-group">
                    <input type="text" id="teaser_img" name="teaser_img"
                           value="<?php if (isset($page_data['teaser_img'])) echo $page_data['teaser_img']; ?>"
                           size="35" class="form-control">
<span class="input-group-btn">
<a class="btn btn-default modal-invoker" href="index.php?mode=modal&amp;action=insert_raw_image"
   title="<?php echo $lang['select_image']; ?>" data-toggle="modal" data-target="#modal_raw_image"
   data-insert="#teaser_img"><span class="glyphicon glyphicon-search"></span></a>
</span>
                </div>


            </div>
        </div>

    </div>


    <div class="tab-pane fade" id="notes">
        <div class="form-group">
            <div class="col-lg-12">
                <label for="page_notes"><?php echo $lang['edit_page_notes_marking']; ?></label>
                <textarea id="page_notes" name="page_notes" cols="70" rows="20"
                          class="form-control"><?php if (isset($page_data['page_notes'])) echo $page_data['page_notes']; ?></textarea>
            </div>
        </div>

    </div>

    </div>

    <div class="row">
        <div class="col-md-10">
            <?php if (isset($page_data['id'])): ?>
                <div class="radio">
                    <p><label for="edit_mode_0">
                            <input id="edit_mode_0" type="radio" name="edit_mode"
                                   value="0"<?php if (isset($edit_mode) && $edit_mode == 0): ?> checked="checked"<?php endif; ?> /> <?php echo $lang['edit_page_mode_edit']; ?>
                        </label><br/>
                        <label for="edit_mode_1">
                            <input id="edit_mode_1" type="radio" name="edit_mode"
                                   value="1"<?php if (isset($edit_mode) && $edit_mode == 1): ?> checked="checked"<?php endif; ?> /> <?php echo $lang['edit_page_mode_save_as_new']; ?>
                        </label></p>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-2">
            <button class="btn btn-lg btn-success pull-right"><span
                    class="glyphicon glyphicon-save"></span> <?php echo $lang['edit_page_submit']; ?></button>
        </div>
    </div>

    </div>
    </form>

<?php endif; ?>
<div class="modal fade" id="modal_image" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal fade" id="modal_thumbnail" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal fade" id="modal_gallery" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal fade" id="modal_raw_image" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
