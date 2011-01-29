<?php
function parsetext($text) {
    $res = $text;

    // убираем переводы строк внутри тэгов
    do
    {
      $oldRes = $res;
      $res = preg_replace("/(<[^>]*)[\n\r]/m", '$1 ', $res);
    } while($res != $oldRes);

    $res = auto_link_text($res);
    $res = strip_tags_attributes($res,array('<strike>', '<s>', '<sup>', '<sub>', '<embed>', '<object>', '<param>', '<p>', '<b>', '<i>', '<br>', '<br/>', '<a>', '<em>', '<font>', '<strong>', '<img>', '<img/>', '<small>', '<big>', '<div>', '<span>'));
    $res = closetags($res);
    $res = redirectExternalLinks($res);
    $res = nl2br($res);
    $res = str_replace(array("\n", "\r"), " ", $res);
    $res = trim($res);
    return $res;
}

function redirectExternalLinks($text)
{
  $text = preg_replace_callback( "/<a\s[^>]*href=([\"']??)(http[^\" >]*?)\\1[^>]*>(.*)<\/a>/siU", function ($match) {
    return "<a href='/redirect?url=" . urlencode($match[2]) . "' rel='nofollow'>" . $match[3] . "</a>";
  }, $text);
  return $text;
}

function closetags ( $html ) {
    #put all opened tags into an array
    preg_match_all ( "#<([a-z]+) [^>]*((?:(?:'[^']*')|(?:\"[^\"]*'))[^>]*)*(?!/)>#iU", $html, $result );
    $openedtags = $result[1];

    # fix img, hr, br
    $openedtags = array_diff($openedtags, array("img", "hr", "br"));

    #put all closed tags into an array
    preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
    $closedtags = $result[1];
    $len_opened = count ( $openedtags );
    # all tags are closed
    if( count ( $closedtags ) == $len_opened ) {
        return $html;
    }
    $openedtags = array_reverse ( $openedtags );
    # close tags
    for( $i = 0; $i < $len_opened; $i++ ) {
        if ( !in_array ( $openedtags[$i], $closedtags ) ) {
            $html .= "</" . $openedtags[$i] . ">";
        }
        else {
            unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
        }
    }
    return $html;
}

function wordlist($sText) {
    $sText=str_replace("\n",' ',$sText);
    $sText=str_replace(",",'',$sText);

    $aWords=mb_split(" ",$sText);
    $res = "";
    foreach($aWords as $word) {
        $res .= mb_strtolower($word, "UTF-8").", ";
    }
    return mb_substr($res, 0, -2);
}

function trimword($sText, $iMaxLen) {
    $sText=str_replace("\r\n",'[<rn>]',$sText);
    $sText=str_replace("\n",'[<n>]',$sText);
    $iLen=-1;
    $aWordsResult=array();
    $aWords=mb_split(" ",$sText);
    for($i=0;$i<count($aWords);$i++) {
        if ($aWords[$i]!='[<rn>]' and $aWords[$i]!='[<n>]') {
            $aWordsResult[]=$aWords[$i];
            if($iLen + mb_strlen($aWords[$i], "utf-8") >= $iMaxLen)
                break;
            $iLen += mb_strlen($aWords[$i], "utf-8") + 1;
        }
    }
    $sText=join(' ',$aWordsResult);
    $sText=str_replace('[<rn>]'," ",$sText);
    $sText=str_replace('[<n>]'," ",$sText);
    return $sText;
}

function strip_tags_attributes($sSource, $aAllowedTags = array(),
        $aDisabledAttributes = array('onabort', 'onactivate', 'onafterprint',
                'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut',
                'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste',
                'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur',
                'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu',
                'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible',
                'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate',
                'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave',
                'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate',
                'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout',
                'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete',
                'onload', 'onlosecapture', 'onmousedown', 'onmouseenter',
                'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup',
                'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste',
                'onpropertychange', 'onreadystatechange', 'onreset', 'onresize',
                'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete',
                'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange',
                'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload')) {
    if (empty($aDisabledAttributes))
        return strip_tags($sSource, implode('', $aAllowedTags));
    return preg_replace('/<(.*?)>/ie', "'<' .
            preg_replace(array('/javascript:[^\"\']*/i', '/(" . implode('|',
            $aDisabledAttributes) . ")[ \\t\\n]*=[ \\t\\n]*[\"\'][^\"\']*[\"\']/i',
            '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'",
            strip_tags($sSource, implode('', $aAllowedTags)));
}
?>
