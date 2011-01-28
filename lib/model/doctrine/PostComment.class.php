<?

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PostComment extends BasePostComment
{
    public function isOld() {
        return time() - strtotime($this['created_at']) > sfConfig::get('app_post_comment_delete_period', 15) * 60;
    }

    public function postInsert($event)
    {
        if($this->Post->getUserId() != $this->getUserId()) {
            $this->Post->setRating($this->Post->getRating() + sfConfig::get('app_post_comment_rating', 0.1));

            $this->Post->User->getProfile()->setRating($this->Post->User->getProfile()->getRating() + sfConfig::get('app_post_comment_rating', 0.1));
            $this->Post->User->save();

            $this->User->getProfile()->setRating($this->User->getProfile()->getRating() + sfConfig::get('app_user_comment_rating', 0.1));
            $this->User->save();
        }
        $this->Post->setCommentsCount($this->Post->getCommentsCount() + 1);
        $this->Post->save();
    }

    public function preDelete($event)
    {
        if($this->Post->getUserId() != $this->getUserId()) {
            $this->Post->setRating($this->Post->getRating() - sfConfig::get('app_post_comment_rating', 0.1));

            $this->Post->User->getProfile()->setRating($this->Post->User->getProfile()->getRating() - sfConfig::get('app_post_comment_rating', 0.1));
            $this->Post->User->save();

            $this->User->getProfile()->setRating($this->User->getProfile()->getRating() - sfConfig::get('app_user_comment_rating', 0.1));
            $this->User->save();
        }
        $this->Post->setCommentsCount($this->Post->getCommentsCount() - 1);
        $uptime = $this->Post->getUpdatedAt();
        $this->Post->save();
        $this->Post->setUpdatedAt($uptime);
        $this->Post->save();
        foreach($this->getComments() as $comment)
                $comment->delete();
    }
}
