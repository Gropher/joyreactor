<?php
    function isNew($sf_user, $baseDate, $cookieName)
    {
        if(!$sf_user->isAuthenticated())
            return false;
        $cookie = $sf_user->getGuardUser()->getCookie($cookieName);
        if($cookie !== null)
        {
            return strtotime($baseDate) > strtotime($cookie);
        }
        else
            return true;
    }

    function getDeltaCount($sf_user, $baseCount, $cookieName)
    {
        if(!$sf_user->isAuthenticated())
            return 0;
        $cookie = $sf_user->getGuardUser()->getCookie($cookieName);;
        if($cookie !== null)
        {
            return $baseCount - $cookie;
        }
        else
            return $baseCount;
    }
?>
