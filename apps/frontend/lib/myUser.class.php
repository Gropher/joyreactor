<?

class myUser extends sfGuardSecurityUser
{
function __get($name)
    {
		if($name == 'GuardUser')
			return $this->getGuardUser();
		else if($name == 'Profile')
			return $this->getProfile();
	}
}
