<?

/**
 * post_vote actions.
 *
 * @package    jobeet
 * @subpackage post_vote
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class post_voteActions extends sfActions {
/**
 * Executes index action
 *
 * @param sfRequest $request A request object
 */
    public function executeCreate(sfWebRequest $request) {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Url'));
        if(!$this->getUser()->isAuthenticated() && $request->getParameter('noajax')) {
            return $this->forward("sfGuardAuth", "signin");
        }
        $this->post = Doctrine::getTable('Post')->find(array($request->getParameter('post_id')));
        $this->vote = $request->getParameter('vote');
        $this->user = $this->getUser()->getGuardUser();
        if($this->getUser()->isAuthenticated() && $this->post->getUserId() != $this->user->getId() && $this->post && ($this->vote == 'plus' || $this->vote == 'minus') && !$this->post->isUserVoted($this->user)) {
            $this->post->addVote($this->user, $this->vote);
        }
        if($request->getParameter('noajax'))
            return $this->redirect(url_for('post/show?id='.$this->post->getId()));
        else
            return $this->renderPartial('post_vote/link_content', array('post' => $this->post));
    }
}
