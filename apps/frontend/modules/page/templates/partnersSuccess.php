<? slot('menu2') ?>
    <?echo link_to(__('О проекте'), 'page/index')?>&nbsp;&nbsp;|&nbsp;&nbsp;
    <?echo link_to(__('Движок'),'page/engine')?>&nbsp;&nbsp;|&nbsp;&nbsp;
    <b><?echo __('Партнерка')?></b>
<? end_slot() ?>
<h1><?echo __("Партнерка")?></h1>
<p>
    <?echo __("Уникальная акция на реакторе: приведи друга, получи рейтинг.")?>
</p>
<p>
    <?echo __("Отправь своему другу ".link_to(__('эту ссылку'), 'sfApply/apply?partnerId='.$sf_user->getGuardUser()->getId())." на регистрацию на нашем сайте и когда он активирует свой аккаунт, ты получишь +100 к рейтингу.")?>
</p>