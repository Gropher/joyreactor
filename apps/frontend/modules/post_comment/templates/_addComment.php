<? use_helper('Text'); ?>
<? if(!isset($parent))$parent = '' ?>
<? echo form_tag('post_comment/create?post_id='.$post->getId(), array('id' => 'add_comment_form'.$post->getId()."_".$parent, 'method' => 'post', 'onkeypress' => "ctrlEnter(event, this);", 'onsubmit' => "return AIM.submit(this, {'onStart' : startAddComment".$post->getId()."_".$parent.", 'onComplete' : completeAddComment".$post->getId()."_".$parent."})") ) ?>
    <? if($parent): ?>
        <? echo input_hidden_tag('parent_id', $parent->getId()) ?>
    <? endif ?>
	<? echo textarea_tag('comment_text', null, array('rows' => 5, 'cols' => 75)) ?>
    <br/>
    <? echo submit_tag(__('Добавить'), array('id' => 'submit', 'class' => 'submit_add_comment'.$post->getId()."_".$parent)) ?>
    <a href="#" onclick="$j('#comment_picture_url', $j(this).parent()).show(); $j(this).hide(); return false;">Вставить картинку</a>
    <? echo input_tag('comment_picture_url', null, array('style' => 'display:none')) ?>
</form>
<script type="text/javascript">
    function startAddComment<? echo $post->getId()."_".$parent ?>(response)
    {
        $j('.submit_add_comment<? echo $post->getId()."_".$parent ?>').attr("disabled", true);
    }

    function completeAddComment<? echo $post->getId()."_".$parent ?>(response)
    {
        $j('#add_comment_form<? echo $post->getId()."_".$parent ?>').keypress(function(e){ctrlEnter(e, this)});
        $j('.addcomment').hide("fast");
        $j('.addcommentInline').hide("fast");
        $j('#comment_list<? echo $post->getId()."_".$parent ?>').html(response);
        $j('.submit_add_comment<? echo $post->getId()."_".$parent ?>').removeAttr("disabled");
        $j('#add_comment_form<? echo $post->getId()."_".$parent ?> :input[type=textarea]').each(function(){
        $j(this).val('');});
    }
</script>