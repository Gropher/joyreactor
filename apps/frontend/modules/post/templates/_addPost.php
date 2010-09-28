<?if(!isset($tag)) $tag = ''?>
<?if(!isset($noajax) || !$noajax):?>
    <? echo form_tag('post/create', array('method' => 'post', 'id' => 'add_post', 'enctype' => 'multipart/form-data', 'onkeypress' => "ctrlEnter(event, this);", 'onsubmit' => "return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})") ) ?>
<?else:?>
    <? echo form_tag('post/create', array('method' => 'post', 'id' => 'add_post', 'enctype' => 'multipart/form-data', 'onkeypress' => "ctrlEnter(event, this);", 'onsubmit' => '$j("#submit").attr("disabled", true);') ) ?>
    <? echo input_hidden_tag('noajax', $noajax) ?>
<?endif?>
    <div>
	<b><label for="text"><? echo __('Как дела? Что новенького?') ?></label></b><br/>
	<? echo textarea_tag('text', $tag, array('rows' => 3	, 'cols' => 76)) ?><br/>
	<div>
            <label for="mood"><? echo __('Настроение') ?>:</label>
            <div class='mood'>
                <? echo radiobutton_tag('mood', 'good', false, array('class' => 'styled_good')) ?>
                <? echo radiobutton_tag('mood', 'normal', true, array('class' => 'styled_normal')) ?>
                <? echo radiobutton_tag('mood', 'bad', false, array('class' => 'styled_bad') ) ?>
            </div>
            <? echo __('Картинка') ?>: <? echo input_file_tag('picture',array("style" => 'display:none')) ?>&nbsp;
            <? echo link_to_function(__('из файла'), 'showPictureUpload()', array('id' => 'more_file')) ?>&nbsp;
            <? echo input_tag('picture_url', null, array("style" => 'display:none')) ?>&nbsp;
            <? echo link_to_function(__('из URL'), 'showPictureURL()', array('id' => 'more_url')) ?>&nbsp;<!--small>еще одну</small-->
            &nbsp;&nbsp;&nbsp;<? echo submit_tag(__('Написать'), array('id' => 'submit')) ?>
    </div>
</div>
    <? if(isset($mypage)): ?>
		<? echo input_hidden_tag('mypage', true) ?>
	<? endif ?>
</form>
<script>
    function showPictureUpload()
    {
        $j('#picture_url').hide();
        $j('#more_url').show();
        $j('#picture').show();
        $j('#more_file').hide();
    }

    function showPictureURL()
    {
        $j('#picture').hide();
        $j('#more_file').show();
        $j('#picture_url').show();
        $j('#more_url').hide();
    }

    function startCallback()
    {
        $j('#submit').attr("disabled", true);
    }

    function completeCallback(response)
    {
        $j('#add_post').keypress(function(e){ctrlEnter(e, this)});
        $j('#post_list').html(response);
        $j('#picture').hide();
        $j('#more_file').show();
        $j('#picture_url').hide();
        $j('#more_url').show();
        $j('#picture').val('');
        $j('#picture_url').val('');
        $j('#text').val('<?echo $tag?>');
        $j('#submit').removeAttr("disabled");
    }
</script>
