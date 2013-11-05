<?php
/**
 * GiveNow fetcher
 *
 * Requires Simple HTML DOM!
 * require_once("simple_html_dom.php");
 * @author http://www.github.com/kythin
*/
class GiveNow {

    public static function raised($page) {
        $html = file_get_html($page);
        $elem = $html->find('div[id=gauge] div[class=raised]', 0);
        $raised = str_replace("$","",trim($elem->plaintext));
        return $raised;
    }

    public static function gauge($page) {
        $slug = basename($page);
        $baseurl = str_replace("/".$slug, "", $page);
        $html = file_get_html($page);
        $elem = $html->find('div[id=gauge] img', 0);
        return $baseurl.$elem->src;
    }

}


