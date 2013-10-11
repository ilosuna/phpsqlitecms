<?php
#unset($template_file);

// page type e.g. 'en,index_en;es,index_es;de,index_de'

/**
 * determines the langauge settings of the browser, details see here:
 * http://aktuell.de.selfhtml.org/artikel/php/httpsprache/
 */
function lang_getfrombrowser($allowed_languages, $default_language, $lang_variable = null, $strict_mode = true) {
        // $_SERVER['HTTP_ACCEPT_LANGUAGE'] verwenden, wenn keine Sprachvariable mitgegeben wurde
        if ($lang_variable === null && isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $lang_variable = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        }

        // wurde irgendwelche Information mitgeschickt?
        if (empty($lang_variable)) {
                // Nein? => Standardsprache zurückgeben
                return $default_language;
        }

        // Den Header auftrennen
        $accepted_languages = preg_split('/,\s*/', $lang_variable);

        // Die Standardwerte einstellen
        $current_lang = $default_language;
        $current_q = 0;

        // Nun alle mitgegebenen Sprachen abarbeiten
        foreach ($accepted_languages as $accepted_language) {
                // Alle Infos über diese Sprache rausholen
                $res = preg_match ('/^([a-z]{1,8}(?:-[a-z]{1,8})*)'.
                                   '(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i', $accepted_language, $matches);

                // war die Syntax gültig?
                if (!$res) {
                        // Nein? Dann ignorieren
                        continue;
                }

                // Sprachcode holen und dann sofort in die Einzelteile trennen
                $lang_code = explode ('-', $matches[1]);

                // Wurde eine Qualität mitgegeben?
                if (isset($matches[2])) {
                        // die Qualität benutzen
                        $lang_quality = (float)$matches[2];
                } else {
                        // Kompabilitätsmodus: Qualität 1 annehmen
                        $lang_quality = 1.0;
                }

                // Bis der Sprachcode leer ist...
                while (count ($lang_code)) {
                        // mal sehen, ob der Sprachcode angeboten wird
                        if (in_array (strtolower (join ('-', $lang_code)), $allowed_languages)) {
                                // Qualität anschauen
                                if ($lang_quality > $current_q) {
                                        // diese Sprache verwenden
                                        $current_lang = strtolower (join ('-', $lang_code));
                                        $current_q = $lang_quality;
                                        // Hier die innere while-Schleife verlassen
                                        break;
                                }
                        }
                        // Wenn wir im strengen Modus sind, die Sprache nicht versuchen zu minimalisieren
                        if ($strict_mode) {
                                // innere While-Schleife aufbrechen
                                break;
                        }
                        // den rechtesten Teil des Sprachcodes abschneiden
                        array_pop ($lang_code);
                }
        }

        // die gefundene Sprache zurückgeben
        return $current_lang;
}

$lang_pages_parts = explode(';',$data['type_addition']);
foreach($lang_pages_parts as $lang_pages)
 {
  $lang_parts = explode(',',$lang_pages);
  $allowed_langs[] = trim($lang_parts[0]);
  $lang_pages_array[trim($lang_parts[0])] = trim($lang_parts[1]);
 }

$lang = lang_getfrombrowser ($allowed_langs, $allowed_langs[0], null, false);

if(isset($cache) && $cache->doCaching)
 {
  $cache->cacheId = PAGE;
  $cache_content = "<?php\ndefine('BASE_URL', '".BASE_URL."');\n\$data['type_addition']='".$data['type_addition']."';\ninclude('".BASE_PATH."cms/includes/page_types/language_redirect.php');\n?>";
  $cache->createChacheFile($cache_content);
 }

header($_SERVER['SERVER_PROTOCOL'] . ' 303 See Other');
header('Location: '.BASE_URL.$lang_pages_array[$lang]);

?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="refresh" content="0; <?php echo BASE_URL.$lang_pages_array[$lang]; ?>">
<title>303 See Other</title>
</head>
<body>
<a href="<?php echo BASE_URL.$lang_pages_array[$lang]; ?>"><?php echo BASE_URL.$lang_pages_array[$lang]; ?></a>
</body>
</html>
