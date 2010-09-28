<?
/**
 * sfGuardUserProfile form.
 *
 * @package    form
 * @subpackage sfGuardUserProfile
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class sfGuardUserProfileForm extends BasesfGuardUserProfileForm {
    public function configure() {
        sfApplicationConfiguration::getActive()->loadHelpers('I18N');
        unset($this['collectIcqStatus'], $this['user_id'], $this['validate'], $this['created_at'], $this['updated_at'], $this['rating'], $this['isNew']);
        $this->setWidget('ljpassword', new sfWidgetFormInputPassword(array('always_render_empty' => false)));
        $this->setWidget('avatar', new sfWidgetFormInputFileEditable(array(
            'file_src' => $this->getObject()->getAvatar(),
            'is_image' => true,
            'edit_mode' => $this->getObject()->getAvatar(),
            'with_delete' => $this->getObject()->getAvatar(),
            'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
            'delete_label' => __('Удалить аватар'))));
        $this->validatorSchema['avatar'] = new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir'), 'validated_file_class' => 'sfResizedFile', 'mime_types' => 'web_images', 'required' => false));
        $this->widgetSchema->setLabels(array(
            'email'    => 'Адрес E-Mail:',
            'fullname' => 'Имя и фамилия:',
            'icq'      => 'Номер ICQ:',
            'jabber'   => 'Jabber/GoogleTalk:',
            'commentsToJabber'   => 'Отправлять уведомления в Jabber:',
            'commentsToIcq'   => 'Отправлять уведомления в ICQ:',
            'commentsToMail'   => 'Отправлять уведомления по почте:',
            'useCrossposting'   => 'Использовать кросспостинг в ЖЖ:',
            'collectJabberStatus' => 'Собирать jabber-статусы',
            //'collectIcqStatus' => 'Собирать icq-статусы',
            'notifyFriendline' => 'Уведомлять о новых постах друзей',
            'ljlogin'  => 'Живой Журнал:',
            'ljpassword'  => 'Пароль от ЖЖ:',
            'avatar'  => 'Аватар:',
            'about'  => 'О себе:'));
        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', false);
        $this->widgetSchema->setFormFormatterName('list');
        $this->widgetSchema->setNameFormat('sfApplySettings[%s]');
    }

    public function saveFile($field, $filename = null, sfValidatedFile $file = null) {
        return '/uploads/'.parent::saveFile($field, $filename, $file);
    }
}