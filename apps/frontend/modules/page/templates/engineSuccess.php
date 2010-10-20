<? slot('menu2') ?>
    <?echo link_to(__('О проекте'), 'page/index')?>&nbsp;&nbsp;|&nbsp;&nbsp;
    <b><?echo __('Движок')?></b>
    <?if($sf_user->isAuthenticated()):?>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <?echo link_to(__('Партнерка'), 'page/partners')?>
    <?endif?>
<? end_slot() ?>
<h1><?echo __("Движок")?></h1>
<p>
    <?echo __("Движок нашего сайта написан на <a href='http://php.net/'>PHP5</a>
              c использованием <a href='http://www.symfony-project.org/'>Symfony Framework 1.2</a> 
               и является свободным программным обеспечением, распространяемым по лицензии 
              <a href='http://www.gnu.org/licenses/gpl-3.0.html'>GPLv3</a>.")?>
</p>
<h3><?echo __("Ссылки")?></h3>
<ul>
    <li>
        <p>GIT &mdash; <a href="http://git.plugncode.com/?p=joyreactor/.git;a=summary">http://git.plugncode.com/?p=joyreactor/.git;a=summary</a></p>
    </li>
    <li>
        <p><?echo __("Инструкция по установке")?> &mdash; <a href="http://www.joyreactor.ru/uploads/reactor.txt">http://www.joyreactor.ru/uploads/reactor.txt</a></p>
    </li>
    <li>
        <p><?echo __("Страница проекта на Assembla")?> &mdash; <a href="https://www.assembla.com/spaces/empaty/">https://www.assembla.com/spaces/empaty/</a></p>
    </li>

    <li>
        <p><?echo __("Вопросы, предложения, пожелания можно писать в")?> <a href="/tag/dev"><?echo __("блог разработки")?></a></p>
    </li>
</ul>
