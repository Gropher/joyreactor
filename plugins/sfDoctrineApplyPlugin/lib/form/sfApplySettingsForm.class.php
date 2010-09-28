<?php

class sfApplySettingsForm extends sfGuardUserProfileForm
{
  public function configure()
  {
    parent::configure();

    // We're editing the user who is logged in. It is not appropriate
    // for the user to get tsfApplySettingsForm.classo pick somebody else's userid, or change
    // the validate field which is part of how their account is 
    // verified by email. Also, users cannot change their email 
    // addresses as they are our only verified connection to the user.
  }
}

