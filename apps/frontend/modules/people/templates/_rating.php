<input name="ratingstar<?echo $user->getId()?>" type="radio" class="star" disabled="disabled"
    <?if($user->getProfile()->getStars() == 1):?> checked="checked"<?endif?>
    title="<?echo __('Рейтинг').": ".$user->getProfile()->getRating()?>"/>
<input name="ratingstar<?echo $user->getId()?>" type="radio" class="star" disabled="disabled"
    <?if($user->getProfile()->getStars() == 2):?> checked="checked"<?endif?>
    title="<?echo __('Рейтинг'.": ".$user->getProfile()->getRating())?>"/>
<input name="ratingstar<?echo $user->getId()?>" type="radio" class="star" disabled="disabled"
    <?if($user->getProfile()->getStars() == 3):?> checked="checked"<?endif?>
    title="<?echo __('Рейтинг'.": ".$user->getProfile()->getRating())?>"/>
<input name="ratingstar<?echo $user->getId()?>" type="radio" class="star" disabled="disabled"
    <?if($user->getProfile()->getStars() == 4):?> checked="checked"<?endif?>
    title="<?echo __('Рейтинг'.": ".$user->getProfile()->getRating())?>"/>
<input name="ratingstar<?echo $user->getId()?>" type="radio" class="star" disabled="disabled"
    <?if($user->getProfile()->getStars() == 5):?> checked="checked"<?endif?>
    title="<?echo __('Рейтинг'.": ".$user->getProfile()->getRating())?>"/>
<br/>
<div id="rating-text"><?echo __('Рейтинг'.": ".$user->getProfile()->getRating())?></div>
