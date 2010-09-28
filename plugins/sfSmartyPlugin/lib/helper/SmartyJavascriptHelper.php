<?php

/**
 * Smarty JavascriptHelpers class for symfony,
 * helpers to use the javascript helpers in a more smartyish way
 *
 * @version $Id$
 * @copyright 2006 Georg Gell
 */

class SmartyJavascriptHelper {
	public static function javascript(array $params, $content, Smarty $smarty, &$repeat){
		if (!$repeat) {
			return javascript_tag($content);
		}
	}
}

sfSmartyView::registerBlock('javascript', array('SmartyJavascriptHelper', 'javascript'));
?>