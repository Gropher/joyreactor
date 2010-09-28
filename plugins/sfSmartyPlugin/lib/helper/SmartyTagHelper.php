<?php

/**
 * Smarty TagHelpers class for symfony,
 * helpers to use the tag helpers in a more smartyish way
 *
 * @version $Id$
 * @copyright 2006 Georg Gell
 */

class SmartyTagHelper {
	public static function cdata(array $params, $content, Smarty $smarty, &$repeat){
		if (!$repeat) {
			return "//<![CDATA[\n$content\n//]]>";
		}
	}
}

sfSmartyView::registerBlock('cdata', array('SmartyTagHelper', 'cdata'));
?>