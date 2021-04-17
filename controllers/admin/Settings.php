<?php

namespace Modules\Twitchstreams\Controllers\Admin;

class Settings extends \Ilch\Controller\Admin
{
    public function init()
    {
        $items = [
            [
                'name' => 'menuStreamer',
                'active' => false,
                'icon' => 'fas fa-th-list',
                'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'index'])
            ],
            [
                'name' => 'settings',
                'active' => true,
                'icon' => 'fas fa-cogs',
                'url' => $this->getLayout()->getUrl(['controller' => 'settings', 'action' => 'index'])
            ]
        ];

        $this->getLayout()->addMenu
        (
            'twitchstreams',
            $items
        );
    }

    public function indexAction()
    {
        $this->getLayout()->getAdminHmenu()
            ->add($this->getTranslator()->trans('twitchstreams'), ['controller' => 'index', 'action' => 'index'])
            ->add($this->getTranslator()->trans('settings'), ['action' => 'index']);

        if ($this->getRequest()->isPost()) {
            $this->getConfig()->set('twitchstreams_requestEveryPageCall', $this->getRequest()->getPost('requestEveryPage'))
                ->set('twitchstreams_apiKey', $this->getRequest()->getPost('apiKey'))
                ->set('twitchstreams_domains', $this->getRequest()->getPost('domains'))
                ->set('twitchstreams_showOffline', $this->getRequest()->getPost('showOffline'));

            $this->redirect()
                ->withMessage('saveSuccess')
                ->to(['action' => 'index']);
        }

        $this->getView()->set('requestEveryPage', $this->getConfig()->get('twitchstreams_requestEveryPageCall'))
            ->set('apiKey', (string)$this->getConfig()->get('twitchstreams_apiKey'))
            ->set('domains', (string)$this->getConfig()->get('twitchstreams_domains'))
            ->set('showOffline', (string)$this->getConfig()->get('twitchstreams_showOffline'));
    }
}
