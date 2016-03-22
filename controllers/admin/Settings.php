<?php
namespace Modules\Twitchstreams\Controllers\Admin;

class Settings extends \Ilch\Controller\Admin
{
    
    public function init()
    {
        $this->getLayout()->addMenu
        (
            'module',
            array
            (
                array
                (
                    'name' => 'menuStreamer',
                    'active' => false,
                    'icon' => 'fa fa-th-list',
                    'url' => $this->getLayout()->getUrl(array('controller' => 'index', 'action' => 'index'))
                ),
                array
                (
                    'name' => 'menuSettings',
                    'active' => true,
                    'icon' => 'fa fa-cogs',
                    'url' => $this->getLayout()->getUrl(array('controller' => 'settings', 'action' => 'index'))
                )
            )
        );
    }
    
    public function indexAction()
    {
        $this->getLayout()->getAdminHmenu()
        ->add($this->getTranslator()->trans('module'), array('controller' => 'index', 'action' => 'index'))
        ->add($this->getTranslator()->trans('settings'), array('action' => 'index'));
        if($this->getRequest()->isPost()) {
            $requestEveryPage = $this->getRequest()->getPost('requestEveryPage');
            if($requestEveryPage === 'on') {
                $this->getConfig()->set('twitchstreams_requestEveryPageCall', 1);
            } else {
                $this->getConfig()->set('twitchstreams_requestEveryPageCall', 0);
            }
        }

        $this->getView()->set('requestEveryPage', $this->getConfig()->get('twitchstreams_requestEveryPageCall'));    
        
        
    }
}