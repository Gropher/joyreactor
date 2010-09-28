<?php

/**
 * sfApply actions.
 *
 * @package    5seven5
 * @subpackage sfApply
 * @author     Tom Boutell, tom@punkave.com
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */

// Necessary due to a bug in the Symfony autoloader
require_once(dirname(__FILE__).'/../lib/BasesfApplyActions.class.php');

class sfApplyActions extends BasesfApplyActions
{
  // See how this extends BasesfApplyActions? You can replace it with
  // your own version by adding a modules/sfApply/actions/actions.class.php
  // to your own application and extending BasesfApplyActions there as well.
}
