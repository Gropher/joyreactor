<? use_helper('Text'); ?>
<? if(!isset($parent))$parent = '' ?>
<? echo form_tag('post_comment/create?post_id='.$post->getId(),
                array('id' => 'add_comment_form'.$post->getId()."_".$parent,
                  'method' => 'post',
                  'onkeypress' => "ctrlEnter(event, this);",
                  'onsubmit' => "return AIM.submit(this,
                    {'onStart' : function() { startAddComment('".$post->getId()."_".$parent."'); },
                     'onComplete' : function(response) { completeAddComment('".$post->getId()."_".$parent."', response); }
                    })") ) ?>
    <? if($parent): ?>
        <? echo input_hidden_tag('parent_id', $parent->getId()) ?>
    <? endif ?>
	<? echo textarea_tag('comment_text', null, array('rows' => 5, 'cols' => 75)) ?>
    <br/>
    <? echo submit_tag(__('Добавить'), array('id' => 'submit', 'class' => 'submit_add_comment'.$post->getId()."_".$parent)) ?>
    <a href="#" onclick="$j('#comment_picture_url', $j(this).parent()).show(); $j(this).hide(); return false;">Вставить картинку</a>
    <? echo input_tag('comment_picture_url', null, array('style' => 'display:none')) ?>
</form>