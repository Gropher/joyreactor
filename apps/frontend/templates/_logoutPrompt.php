<li class="login lastitem">
    <? echo link_to(__('Выход'), '@sf_guard_signout', array("id" => 'logout')) ?>
</li>
<li class="login">
    <? echo "<span>".__("Привет").",</span>".'<b>'.link_to($sf_user->getGuardUser()->getUsername(), 'post/user', array("id" => 'settings')).'</b>' ?>
</li>