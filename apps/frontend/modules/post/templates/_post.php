<? use_helper('Text', 'Parse', 'UserTime', 'DeltaCount'); ?>
<?php use_javascript('comments'); ?>

<?if(!isset($show_comments)) $show_comments=0 ?>
<?if(!isset($showAddComment)) $showAddComment=0 ?>
<div class="article post-<? echo $post->getMoodName() ?>">
    <div class="uhead">
        <? if($sf_user->isAuthenticated()): ?>
            <? include_partial('favorite/link', array('post' => $post)) ?>
        <? endif ?>
        <big><big>
            <? echo image_tag("/images/smile_".$post->getMoodName().".png",array('height'=>46))?>
            <a <?if($post->getUser()->isOnline()) {
                    echo 'class="online_username" ';
                    if($post->getUser()->getLastStatus() && $post->getUser()->getLastStatus()->getText())
                        echo 'title="'.$post->getUser()->getLastStatus()->getText().'"';
                    else
                        echo 'title="'.__('сейчас на сайте').'"';
                 } else {
                    echo 'class="offline_username"';
                    if($post->getUser()->getLastStatus() && $post->getUser()->getLastStatus()->getText())
                        echo 'title="'.$post->getUser()->getLastStatus()->getText().'"';
                 }?>
                href="<?echo url_for('post/user?username='.$post->getUser()->getUsername())?>">
                <?echo $post->getUser()->getUsername()?>
            </a>
        </big></big>
    </div><!-- /uhead -->
    <?if(!($sf_user->isAuthenticated() && $sf_user->getGuardUser()->isHidden($post))):?>
        <?include_partial('post/post_content', array('post' => $post)) ?>
    <?else:?>
        <?if($post->getBlogs()->count() != 0):?>
        <span style="display:block; color:#666;">
            <?
            foreach($post->getBlogs() as $blog) {
                $blog_link = link_to($blog->getTag(), 'blog/show?name='.$blog->getTag(ESC_RAW), array("absolute" => "true", "title" => $blog->getName()))." ";
		if($blog->getCount() > 1)
			$blog_link = "<b>".$blog_link."</b>";
		echo $blog_link;
	    }
            ?>
        </span>
        <?endif?>
    <?endif?>
    <div class="ufoot">
        <span class="date">
            <? echo user_time($post->getCreatedAt()) ?>
        </span>
        <span class="manage">
	        &nbsp;<? echo link_to(__('поделиться'), 
	                              'post/show?id='.$post->getId(), 
	                              array('id' => 'post_share_link'.$post->getId(), 
	                                    'title' => __('поделиться ссылкой на пост с друзьями'), 
	                                    'class'=>'link', 
	                                    'onclick' => '$j("#post_share_form'.$post->getId().'").toggle("fast").load("'.url_for("post/share?id=".$post->getId()).'");return false;')) ?>&nbsp;
            <? if($sf_user->isAuthenticated() && ((!$post->isOld() && $sf_user->getGuardUser() == $post->getUser()) || $sf_user->getGuardUser()->getIsSuperAdmin())): ?>
                <? echo link_to(__('удалить'), 'post/delete?id='.$post->getId(), array('title' => __('удалить пост'), 'class'=>"delete", 'onclick' => "return confirm('".__('Действительно удалить пост?')."')")) ?>&nbsp;
            <? endif ?>
            <? if($sf_user->isAuthenticated() && ($sf_user->getGuardUser() == $post->getUser() || $sf_user->getGuardUser()->getIsSuperAdmin())): ?>
                <? echo link_to(__('теги'), 'post/show?id='.$post->getId(), array('id' => 'post_settag_link'.$post->getId(), 'title' => __('изменить теги'), 'class'=>'link', 'onclick' => '$j("#post_settag_form'.$post->getId().'").toggle("fast");return false;')) ?>&nbsp;
            <? endif ?>
            <? if($sf_user->isAuthenticated() && $sf_user->getGuardUser() != $post->getUser() && !$sf_user->getGuardUser()->getIsSuperAdmin()): ?>
                <? echo link_to(__('добавить теги'), 'post/show?id='.$post->getId(), array('id' => 'post_settag_link'.$post->getId(), 'title' => __('изменить теги'), 'class'=>'link', 'onclick' => '$j("#post_settag_form'.$post->getId().'").toggle("fast");return false;')) ?>&nbsp;
            <? endif ?>
            <? if($sf_user->isAuthenticated()): ?>
                <? echo link_to('ссылка', 'post/show?id='.$post->getId()."&partnerId=".$sf_user->getGuardUser()->getId(), array('title' => __('ссылка на пост'), 'class'=>'link')) ?>&nbsp;
            <? else: ?>
                <? echo link_to('ссылка', 'post/show?id='.$post->getId(), array('title' => __('ссылка на пост'), 'class'=>'link')) ?>&nbsp;
            <? endif ?>
            <? include_partial('hidden/link', array('post' => $post, 'showAddComment' => $showAddComment, 'show_comments' => $show_comments)) ?>&nbsp;
            <?if($sf_user->getGuardUser() && $sf_user->getGuardUser()->getIsSuperAdmin()):?>
                <? echo link_to(__('заголовок'), 'post/show?id='.$post->getId(), array('id' => 'post_header_link'.$post->getId(), 'title' => __('редактировать заголовок H1'), 'class'=>'link', 'onclick' => '$j("#post_header_form'.$post->getId().'").toggle("fast");return false;')) ?>&nbsp;
            <?endif?>
        </span>
        <? if(!isset($noCommentsLinks) || !$noCommentsLinks): ?>
        <span class="comments">
            <? echo link_to($post->getCommentsCount(),
                'post/show?id='.$post->getId(),
                array('title' => __('количество комментариев'),
                  'class'=>'commentnum',
                  'onclick' => '$j("#post_comment_list'.$post->getId().'")
                      .toggle("fast")
                      .load("'.url_for("post/comments?id=".$post->getId()).'", function() {UpdateCommentsCss();}
                    );
                    return false;')) ?>
            <?if(getDeltaCount($sf_user, $post->getCommentsCount(), "comments".$post->getId()) > 0):?>
                <span class="commentnumDelta" title="колличество новых комментариев">
                    <? echo "+".getDeltaCount($sf_user, $post->getCommentsCount(), "comments".$post->getId()) ?>
                </span>
            <?endif?>
        </span>
        <? endif ?>
        <?if($sf_user->getGuardUser() && $sf_user->getGuardUser()->getIsSuperAdmin()):?>
        <span style="display:none;" id="post_header_form<?echo $post->getId()?>">
            <?echo form_remote_tag(array( 'url' => "post/setheader?id=".$post->getId(), 'update' => 'postContainer'.$post->getId()))?>
                <?echo input_tag("post_header",$post->getSeoDescription(), array('size' => 74))?>
                <?echo submit_tag(__("Сохранить"))?>
            </form>
        </span>
	    <?endif?>
	    <?if($sf_user->getGuardUser()):?>
        <span style="display:none;" id="post_settag_form<?echo $post->getId()?>">
            <?echo form_remote_tag(array( 'url' => "post/settag?id=".$post->getId(), 'update' => 'postContainer'.$post->getId()))?>
                <?if($post->getBlogs()->count() != 0 && ($sf_user->getGuardUser() == $post->getUser() || $sf_user->getGuardUser()->getIsSuperAdmin())) $tag = $post->getTagline(); else $tag="";?>
                <?echo input_tag("tag",$tag, array('size' => 74))?>
                <?echo submit_tag(__("Сохранить"))?>
            </form>
        </span>
        <?endif?>
	    <span style="display:none;" id="post_share_form<?echo $post->getId()?>"></span>
        <div id="post_comment_list<?echo $post->getId()?>" <?if(!$show_comments):?>style="display:none;"<?endif?>>
            <?if($show_comments):?>
                <?include_partial('post/post_comments', array('post' => $post, 'showAddComment' => $showAddComment))?>
            <?endif?>
        </div>
        <? include_partial('post_vote/link', array('post' => $post)) ?>
    </div>
</div><!-- /article -->
