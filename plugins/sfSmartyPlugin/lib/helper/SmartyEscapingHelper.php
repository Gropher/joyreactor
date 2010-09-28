<?php

/**
 * Smarty EscapingHelpers class for symfony,
 * helpers to use the escaping helpers in a more smartyish way
 *
 * @version $Id$
 * @copyright 2006 Georg Gell
 */

class SmartyEscapingHelper {
	public static function esc_entities($content){
		return esc_entities($content);
	}

	public static function esc_js($content){
		return esc_js($content);
	}

	public static function esc_js_no_entities($content){
		return esc_js_no_entities($content);
	}

	public static function esc_raw($content){
		return esc_raw($content);
	}
}

sfSmartyView::registerModifier('esc_entities', array('SmartyEscapingHelper', 'esc_entities'));
sfSmartyView::registerModifier('esc_js', array('SmartyEscapingHelper', 'esc_js'));
sfSmartyView::registerModifier('esc_js_no_entities', array('SmartyEscapingHelper', 'esc_js_no_entities'));
sfSmartyView::registerModifier('esc_raw', array('SmartyEscapingHelper', 'esc_raw'));

?>