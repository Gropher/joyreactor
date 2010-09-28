<?php

/**
 * api actions.
 *
 * @package    Empaty
 * @subpackage api
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class apiActions extends sfActions {
/**
 * Executes index action
 *
 * @param sfRequest $request A request object
 */
    public function executeUpload(sfWebRequest $request) {
        $uploaded_file = $request->getFiles('file');
        $this->filename = '';
        if($uploaded_file) {
            try {
                $filename = time().$uploaded_file['name'];
                $thumbnail = new sfThumbnail(811, 0, true, false, 100, sfConfig::get('app_sfThumbnailPlugin_adapter','sfGDAdapter'));
                $thumbnail->loadFile($uploaded_file['tmp_name']);
                $thumbnail->save(sfConfig::get('sf_upload_dir').'/'.$filename);
                $this->filename =  'http://'.$_SERVER['HTTP_HOST'].'/uploads/'.$filename;
            }catch(Exception $e) {
            }
        }
        return $this->renderPartial('upload', array('filename' => $this->filename));
    }

    public function executeUploadUrl(sfWebRequest $request) {
        $this->filename = '';
        if($this->getRequestParameter('picture_url') != null) {
            try {
                $filename = explode('/',$this->getRequestParameter('picture_url'));
                $filename = time().$filename[count($filename)-1];
                $thumbnail = new sfThumbnail(811, 0, true, false, 100, sfConfig::get('app_sfThumbnailPlugin_adapter','sfGDAdapter'));
                $thumbnail->loadFile($this->getRequestParameter('picture_url'));
                $thumbnail->save(sfConfig::get('sf_upload_dir').'/'.$filename);
                $this->filename =  'http://'.$_SERVER['HTTP_HOST'].'/uploads/'.$filename;
            }catch(Exception $e) {
            }
        }
        return $this->renderPartial('upload', array('filename' => $this->filename));
    }

    public function executePostInsertTrigger(sfWebRequest $request) {
        sfLoader::loadHelpers('Partial');
        $this->filename = 'error';
        $post = Doctrine::getTable('Post')->find(array($this->getRequestParameter('post_id')));
        $admin = sfGuardUser::getAdminUser();
        if($admin && urldecode($this->getRequestParameter('login')) == $admin->getProfile()->getLjlogin() &&
            urldecode($this->getRequestParameter('pass')) == $admin->getProfile()->getLjpassword() &&
            $post != null) {
            if($post->getUser()->getProfile()->getUsecrossposting()) {
                func::crossposting($post->getUser()->getProfile()->getLjlogin(),
                    $post->getUser()->getProfile()->getLjpassword(),
                    get_partial('post/post_lj', array('post' => $post)), $post->getMoodNameI18N(), $post->getMoodSmile());
            }
            $this->filename = 'ok';
        }
        return $this->renderPartial('upload', array('filename' => $this->filename));
    }

    public function executeMainPageTrigger(sfWebRequest $request) {
        sfLoader::loadHelpers('Partial');
        $this->filename = 'error';
        $post = Doctrine::getTable('Post')->find(array($this->getRequestParameter('post_id')));
        $admin = sfGuardUser::getAdminUser();
        if($admin && $admin->getProfile()->getUsecrossposting() && urldecode($this->getRequestParameter('login')) == $admin->getProfile()->getLjlogin() &&
            urldecode($this->getRequestParameter('pass')) == $admin->getProfile()->getLjpassword() &&
                $post != null) {
            if(!$post->getLj() && $post->getRating() >= sfConfig::get('app_post_mainpage_threshold')) {
                func::crossposting($admin->getProfile()->getLjlogin(),
                    $admin->getProfile()->getLjpassword(),
                    get_partial('post/post_lj', array('post' => $post, 'showUsername' => 1)), $post->getMoodNameI18N(), $post->getMoodSmile());
                $post->setLj(1);
                $post->save();
                $this->filename = 'ok';
            }
        }
        return $this->renderPartial('upload', array('filename' => $this->filename));
    }
}
