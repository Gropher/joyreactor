<span>
    <? echo __('Рейтинг').': ' ?>
    <? if($sf_user->isAuthenticated() &&
               !$post->isUserVoted($sf_user->getGuardUser()) &&
               $sf_user->getGuardUser() != $post->getUser() ): ?>
        <? echo link_to_remote('<img src="/images/vote_plus.png"/>', array(
                'update' => 'post_rating'.$post->getId(),
                'url' => 'post_vote/create?post_id='.$post->getId().'&vote=plus'),
        array('title' => __('голосовать за'))) ?>
    <?else:?>
        <a href='#' class='vote-unregistered' onclick='return false;'><img src="/images/vote_plus.png"/></a>
    <? endif ?>
    <? echo $post->getrating() ?>
    <? if($sf_user->isAuthenticated() &&
               !$post->isUserVoted($sf_user->getGuardUser()) &&
               $sf_user->getGuardUser() != $post->getUser() ): ?>
        <? echo link_to_remote('<img src="/images/vote_minus.png"/>', array(
                'update' => 'post_rating'.$post->getId(),
                'url' => 'post_vote/create?post_id='.$post->getId().'&vote=minus'),
        array('title' => __('голосовать против'))) ?>
    <?else:?>
        <a href='#' class='vote-unregistered' onclick='return false;'><img src="/images/vote_minus.png"/></a>
    <? endif ?>
</span>
