<h1 id="mood_question"><? echo __('Как настроение?') ?></h1>
<span id= "hint" style="color: #999;">(выбери подходящий смайлик)&nbsp;</span>
<? echo form_tag('post/index', array('method' => 'post') ) ?>
<div class='mood'>
    <? echo radiobutton_tag('mood', 'good', $sf_request->getParameter('mood')=='good', array('class' => 'styled_good', 'onclick' => "onMoodSelect('good')")) ?>
    <? echo radiobutton_tag('mood', 'normal', $sf_request->getParameter('mood')=='normal', array('class' => 'styled_normal', 'onclick' => "onMoodSelect('normal')")) ?>
    <? echo radiobutton_tag('mood', 'bad',$sf_request->getParameter('mood')=='bad', array('class' => 'styled_bad', 'onclick' => "onMoodSelect('bad')")) ?>
</div>
<div id="main_question" style="display:none; font-weight:bold;"></div>
<? echo textarea_tag('text', $sf_request->getParameter('text'), array('rows' => 2, 'cols' => 50, 'style' => 'display:none')) ?><br/>
<? echo button_to_function(__('Написать'), 'onSubmitWriteClick()', array('id' => 'submit_write', 'style' => 'display:none; margin-bottom: 10px;')) ?>

<div id='registration_promt' style="display:none">
    <p><? echo __('Теперь надо бы зарегистрироваться ;)') ?></p>
    <? echo $form ?>
    <li><small><p><?echo __("*Для того, чтобы общаться, надо указать свою настоящую почту.")?></p></small></li>
    <? echo submit_tag(__('Написать')) ?>
</div>
</form>
<br/>
<script type="text/javascript">
    function onSubmitWriteClick()
    {
        $j('#registration_promt').show("fast");
        $j('#submit_write').hide("fast");
    }
    function onMoodSelect(mood)
    {
        $j('#text').show("fast");
        $j('#hint').hide("fast");
        $j('#mood_question').hide("fast");
        $j('#submit_write').show("fast");
        if(mood == 'bad')
            $j('#main_question').text("<? echo __('Что случилось?') ?>");
        else
            $j('#main_question').text("<? echo __('Как дела? Что делаешь?') ?>");
        $j('#main_question').show("fast");
    }
    $j(document).ready(function()
    {
        var mood = '<? echo $sf_request->getParameter('mood')?>';
        if(mood)
        {
            onMoodSelect(mood);
            onSubmitWriteClick();
        }
    })
</script>
