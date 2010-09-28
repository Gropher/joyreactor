<?php use_helper('I18N') ?>
<div id="sf_apply_logged_in_as">
<p>
<?php echo __("Logged in as %1%", 
  array("%1%" => $sf_user->getGuardUser()->getUsername())) ?>
</p>
<?php echo link_to(__('Log Out'), 
  '@sf_guard_signout', array("id" => 'logout')) ?>
<?php echo link_to(__('Settings'), 
  'sfApply/settings', array("id" => 'settings')) ?>
</div>

