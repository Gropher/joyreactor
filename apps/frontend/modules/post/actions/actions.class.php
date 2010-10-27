<?
class postActions extends sfActions {
    public function executeIndex(sfWebRequest $request) {
        $this->curUser = $this->getUser()->getGuardUser();
        if($this->curUser) {
            $request->addRequestParameters(array("username" => $this->curUser->getUsername()));
            $this->forward("post", "new");
        }
        $this->form = $this->applyForm();
        if($request->isMethod('post')) {
            sfApplicationConfiguration::getActive()->loadHelpers(array('Guid'));
            $this->form->bind($request->getParameter('sfApplyApply'));
            if ($this->form->isValid()) {
                $this->form->setValidate("n".createGuid());
                $this->form->save();
                $this->getUser()->signin($this->form->getObject()->getUser(), true);
                $post = new Post();
                $post->setText($this->getRequestParameter('text'));
                $post->setMoodName($this->getRequestParameter('mood'));
                $post->setUser($this->form->getObject()->getUser());
                $post->save();
                try {
                    $profile = $this->form->getObject();
                    nahoMail::send(sfConfig::get('app_sfApplyPlugin_apply_subject',
                        "Активация на сайте " . $request->getHost()),
                        nahoMail::getBody('partial', 'global/sendValidateNew',
                        array('name' => $profile->getFullname(), 'validate' => $profile->getValidate())),
                        $profile->getEmail());
                }catch(Exception $e) {}
                return 'After';
            }
        }
    }

    public function executeBest(sfWebRequest $request) {
    }

    public function executeWorst(sfWebRequest $request) {
    }

    public function executeText(sfWebRequest $request) {
    }

    public function executeMood(sfWebRequest $request) {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N'));
        if($request->getParameter('mood') == 1)
            $this->title = __('Веселое');
        elseif($request->getParameter('mood') == -1)
            $this->title = __('Грустное');
        else
            $this->title = __('Интересное');
    }

    public function executeNew(sfWebRequest $request) {
        $this->curUser = $this->getUser()->getGuardUser();
        if($this->curUser) {
            Cookie::setCookie($this->curUser, "new", Post::getNewLine('count'), time() + 24 * 60 * 60);
            Cookie::setCookie($this->curUser, "newTime", date("Y-m-d H:i:s"), time() + 24 * 60 * 60);
        }
    }

    public function executeDiscussion(sfWebRequest $request) {
        $this->curUser = $this->getUser()->getGuardUser();
        Cookie::setCookie($this->curUser, "discussion", $this->curUser->getDiscussionLine('count'), time() + 24 * 60 * 60);
        Cookie::setCookie($this->curUser, "discussionTime", date("Y-m-d H:i:s"), time() + 24 * 60 * 60);
    }

    public function executeDate(sfWebRequest $request) {
        $this->posts = Post::getDateLine($request->getParameter('date'), $request->getParameter('page'));
        $this->post_count = Post::getDateLine($request->getParameter('date'), 'count');
    }

    public function executeUserdate(sfWebRequest $request) {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N', 'Parse'));
        $this->user = sfGuardUser::getUserByUsername($request->getParameter('username'));
        $this->forward404Unless($this->user);
        $this->posts = $this->user->getDateLine($request->getParameter('date'), $request->getParameter('page'));
        $this->post_count = $this->user->getDateLine($request->getParameter('date'), 'count');
        $this->getResponse()->setTitle($request->getParameter('date')." / ".$this->user->getUsername()." / ".__("JoyReactor – твое хорошее настроние. Картинки, приколы, видео, демотиваторы."));
    }

    public function executeAttribute(sfWebRequest $request) {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N', 'Parse'));
        $this->attr = Doctrine::getTable('PostAttribute')->find(array($request->getParameter('id')));
        $this->forward404Unless($this->attr);
        $this->title = "";
        $this->description = "";
        if($this->attr->getComment()) {
            $this->description = trimword($this->attr->getComment(), sfConfig::get('app_post_description_length'));
            $this->title = trimword($this->attr->getComment(), sfConfig::get('app_post_title_length'))." / ";
        }
        $this->title .= __("JoyReactor – твое хорошее настроние. Картинки, приколы, видео, демотиваторы.");
    }

    public function executeShow(sfWebRequest $request) {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N', 'Parse'));
        $this->post = Doctrine::getTable('Post')->find(array($request->getParameter('id')));
        if($request->getParameter('noajax'))
            $this->showAddComment = 1;
        $this->forward404Unless($this->post);
        $this->partnerId = $request->getParameter('partnerId');
        if($this->partnerId)
            setcookie('partnerId', $this->partnerId, time()+60*60*2 , "/");
        $this->title = $this->post->getSeoTitle();
        $this->title = $this->title ? $this->title." / " : "";
        $this->description = $this->post->getSeoDescription();
        $this->text = trimword(strip_tags($this->post->getText()), sfConfig::get('app_post_description_length'));
        if($this->text)
            $this->title .= $this->text." / ";
        $this->tagnames = $this->post->getTagNames();
        if($this->tagnames)
            $this->title .= $this->tagnames." / ";
        $this->getResponse()->setTitle($this->title.__("JoyReactor – твое хорошее настроние. Картинки, приколы, видео, демотиваторы."));
        $this->getResponse()->addMeta('description', $this->description);
        $this->getResponse()->addMeta('keywords', wordlist($this->description));
        if(count($attr) && $attr[0]->getComment()) {
            try {
                $options = array(
                    'limit'   => sfConfig::get('app_sphinx_results_per_page'),
                    'offset'  => 0,
                    'mode'    => sfSphinxClient::SPH_MATCH_ANY,
                );
                $this->sphinx = new sfSphinxClient($options);
                $res = $this->sphinx->Query($attr[0]->getComment(), sfConfig::get('app_sphinx_index'));
                $this->pager = new sfSphinxPager('Post', $options['limit'], $this->sphinx);
                $this->pager->setPage(1);
                $this->pager->init();
                $this->simPosts = $this->pager->getResults();
            } catch (Exception $e) { }
        }
    }

    public function executeDelete(sfWebRequest $request) {
        $this->post = Doctrine::getTable('Post')->find(array($request->getParameter('id')));
        $this->forward404Unless($this->post && $this->post->getUser() == $this->getUser()->getGuardUser());
        $this->post->delete();
        $this->redirect('post/user');
    }

    public function executeUser(sfWebRequest $request) {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N', 'Parse'));
        $this->curUser = $this->getUser()->getGuardUser();
        $this->user = sfGuardUser::getUserByUsername($request->getParameter('username'));
        $this->forwardIf(!$this->user && !$this->curUser, 'sfGuardAuth', 'signin');
        if(!$this->user)
            $this->redirect('post/user?username='.$this->curUser->getUsername());
        elseif($this->curUser == $this->user)
            $this->setTemplate('my');
        else
            $this->setTemplate('user');
        $this->getResponse()->setTitle($this->user->getUsername()." / ".__("JoyReactor – твое хорошее настроние. Картинки, приколы, видео, демотиваторы."));
    }

    public function executeFriends(sfWebRequest $request) {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N', 'Parse'));
        $this->user = sfGuardUser::getUserByUsername($request->getParameter('username'));
        $this->forward404Unless($this->user);
        $this->getResponse()->setTitle("Френдлента / ".$this->user->getUsername()." / ".__("JoyReactor – твое хорошее настроние. Картинки, приколы, видео, демотиваторы."));
    }

    public function executePersonal(sfWebRequest $request) {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N', 'Parse'));
        $this->user = sfGuardUser::getUserByUsername($request->getParameter('username'));
        $this->curUser = $this->getUser()->getGuardUser();
        if($this->curUser && $this->user) {
            Cookie::setCookie($this->curUser, "personal".$this->user->getId(), $this->user->getPersonalLine('count'), time() + 24 * 60 * 60);
            Cookie::setCookie($this->curUser, "personal".$this->user->getId()."Time", date("Y-m-d H:i:s"), time() + 24 * 60 * 60);
        }
        $this->forward404Unless($this->user);
        $this->getResponse()->setTitle("Лента / ".$this->user->getUsername()." / ".__("JoyReactor – твое хорошее настроние. Картинки, приколы, видео, демотиваторы."));
    }

    public function executeFavorite(sfWebRequest $request) {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N', 'Parse'));
        $this->user = sfGuardUser::getUserByUsername($request->getParameter('username'));
        $this->forward404Unless($this->user);
        $this->getResponse()->setTitle("Избранное / ".$this->user->getUsername()." / ".__("JoyReactor – твое хорошее настроние. Картинки, приколы, видео, демотиваторы."));
    }

    public function executeSettag(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod('post'));
        $post = Doctrine::getTable('Post')->find(array($request->getParameter('id')));
        $this->forward404Unless($post, $this->getUser()->getGuardUser());
        $tags = split("[,;:]", str_replace("*", "", str_replace("#", "", trim($request->getParameter('tag')))));
        if($post->getUser() == $this->getUser()->getGuardUser())
            $post->deleteBlogs();
        foreach($tags as $tag) {
            $tag = trim($tag);
            $blog = Blog::getOrCreateByTag($tag, $this->getUser()->getGuardUser());
            if($blog) {
                $bp = new BlogPost();
                $bp->setBlogId($blog->getId());
                $bp->setPostId($post->getId());
                $bp->save();
            }
        }
        return $this->renderPartial('post/post', array('post' => $post));
    }
    
    public function executeSetheader(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod('post'));
        $post = Doctrine::getTable('Post')->find(array($request->getParameter('id')));
        $user = $this->getUser()->getGuardUser();
        $this->forward404Unless($post, $user, $user->getIsSuperAdmin());
        $post->setHeader(trim($request->getParameter('post_header')));
        $post->save();
        return $this->renderPartial('post/post', array('post' => $post));
    }

    public function executeComments(sfWebRequest $request) {
        $post = Doctrine::getTable('Post')->find(array($request->getParameter('id')));
        $this->forward404Unless($post);
        return $this->renderPartial('post/post_comments', array('post' => $post, 'showAddComment' => 1));
    }

    public function executeCreate(sfWebRequest $request) {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Url'));
        $this->forward404Unless($request->isMethod('post'));
        $user = $this->getUser()->getGuardUser();
        try {
            $text = trim($this->getRequestParameter('text'));
            $blogs = array(); $pictures = array();
            $moodNo = 0;
            $doWork = false;
            $useMoodNo = false;
            do {
                $doWork = false;
                if (substr($text, 0, 2) == ":D") {
                    $moodNo = 1;
                    $text = trim(substr($text, 2));
                    $doWork = true;
                    $useMoodNo = true;
                }
                if (substr($text, 0, 2) == ":(") {
                    $moodNo = -1;
                    $text = trim(substr($text, 2));
                    $doWork = true;
                    $useMoodNo = true;
                }
                if (substr($text, 0, 2) == ":)") {
                    $moodNo = 0;
                    $text = trim(substr($text, 2));
                    $doWork = true;
                    $useMoodNo = true;
                }
                if (substr($text, 0, 1) == "#" || substr($text, 0, 1) == "*") {
                    $tags = split("[,;:| \n]", $text);
                    $blog = Blog::getOrCreateByTag(trim(substr($tags[0], 1)), $user);
                    if ($blog) {
                        $text = trim(substr($text, strlen($tags[0])+1));
                        $blogs[] = $blog;
                        $doWork = true;
                    }
                }
            } while ($doWork);
            $post = new Post();
            $post->setText($text);
            if($useMoodNo)
                $post->setMood($moodNo);
            else
                $post->setMoodName($this->getRequestParameter('mood'));
            $post->setUser($user);
            if($this->getRequestParameter('picture_url')) {
                $filename = pathinfo($this->getRequestParameter('picture_url'));
                $extension = $filename["extension"] ? $filename["extension"] : "jpg";
                $filename = time().rand(1, 999999).".".$extension;
                $thumbnail = new sfThumbnail(811, 0, true, false, 100, sfConfig::get('app_sfThumbnailPlugin_adapter','sfGDAdapter'));
                $thumbnail->loadFile($this->getRequestParameter('picture_url'));
                $thumbnail->save(sfConfig::get('sf_upload_dir').'/'.$filename);
                $pictures[] = array('value' => '/uploads/'.$filename,
                    'origin' => $this->getRequestParameter('picture_url'));
            }
            $uploaded_file = $request->getFiles('picture');
            if($uploaded_file['tmp_name']) {
                $pathinfo = pathinfo($uploaded_file['name']);
                $name = time().rand(1, 999999);
                $extension = $pathinfo["extension"] ? $pathinfo["extension"] : "jpg";
                $filename = $name.".".$extension;
                $origin = $name."_origin.".$extension;
                $thumbnail = new sfThumbnail(811, 0, true, false, 100, sfConfig::get('app_sfThumbnailPlugin_adapter','sfGDAdapter'));
                $thumbnail->loadFile($uploaded_file['tmp_name']);
                $thumbnail->save(sfConfig::get('sf_upload_dir').'/'.$filename);
                move_uploaded_file($uploaded_file['tmp_name'], sfConfig::get('sf_upload_dir').'/'.$origin);
                $pictures[] = array('value' => '/uploads/'.$filename,
                    'origin' => '/uploads/'.$origin);
            }

            foreach($blogs as $blog) {
                $post->getBlogs()->add($blog);
            }
            foreach($pictures as $pic) {
                $postAttr = new PostAttribute();
                $postAttr->setType('picture');
                $postAttr->setValue($pic['value']);
                $postAttr->setOrigin($pic['origin']);
                $post->getAttributes()->add($postAttr);
            }
            $post->save();
            /*if(!$this->getRequestParameter('noajax')) {
                if($this->getRequestParameter('mypage'))
                    $post_list = $user->getLine();
                else
                    $post_list = Post::getNewLine();
                return $this->renderPartial('post/postList', array('posts' => $post_list));
            }
            else
                $this->redirect(url_for('post/new'));*/
	    if($this->getRequestParameter('mypage'))
		$this->redirect(url_for('post/user'));
	    else
		$this->redirect(url_for('post/new'));
        } catch (Exception $e) {
            echo "Возникла ошибка при создании поста.<br/>\n";
            if($this->getRequestParameter('text')) {
                echo "Текст поста был такой:<br/>\n";
                echo "<hr/>".nl2br(htmlentities(trim($this->getRequestParameter('text'))))."<hr/><br/>\n";
            }
            if($this->getRequestParameter('noajax')) {
                echo "<a href='".$this->getRequest()->getReferer()."'>назад</a>";
            }
            die;
        }
    }

    protected function applyForm($className='sfApplyApplyForm', $object = null) {
        $key = "app_sfApplyPlugin_$className" . "_class";
        $class = sfConfig::get($key, $className);
        if ($object !== null) {
            return new $class($object);
        }
        return new $class;
    }
}
