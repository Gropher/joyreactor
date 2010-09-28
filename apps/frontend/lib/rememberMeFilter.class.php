<?php

class rememberMeFilter extends sfFilter {
    public function execute ($filterChain) {
        if ($this->isFirstCall() and !$this->getContext()->getUser()->isAuthenticated()) {
            $cookie = $this->getContext()->getRequest()->getCookie(sfConfig::get('app_sf_guard_plugin_remember_cookie_name', 'sfRemember'));
            if ($cookie) {
                $q = Doctrine_Query::create()
                    ->from('sfGuardRememberKey r')
                    ->innerJoin('r.sfGuardUser u')
                    ->where('r.remember_key = ?', $cookie);
                if ($q->count()) {
                    $this->getContext()->getUser()->signIn($q->fetchOne()->sfGuardUser);
                }
            }
        }
        elseif($this->getContext()->getUser()->isAuthenticated()){
            Doctrine_Query::create()
                ->update('sfGuardUser u')
                ->set("u.last_login", "'".date('Y-m-d H:i:s')."'")
                ->where('u.id = ?', $this->getContext()->getUser()->getGuardUser()->getId())
                ->execute();
            $user = $this->getContext()->getUser()->getGuardUser();
//            $user->setLastLogin(date('Y-m-d h:i:s'));
//            $user->save();
        }
        // execute next filter
        $filterChain->execute();
    }
}