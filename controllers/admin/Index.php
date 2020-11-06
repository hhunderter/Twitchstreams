<?php

namespace Modules\Twitchstreams\Controllers\Admin;

use \Modules\Twitchstreams\Mappers\Streamer as StreamerMapper;
use \Modules\Twitchstreams\Models\Streamer as StreamerModel;
use Ilch\Validation;

class Index extends \Ilch\Controller\Admin
{
    public function init()
    {
        $items = [
            [
                'name' => 'menuStreamer',
                'active' => false,
                'icon' => 'fas fa-th-list',
                'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'index']),
                [
                    'name' => 'add',
                    'active' => false,
                    'icon' => 'fas fa-plus-circle',
                    'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'treat'])
                ]
            ],
            [
                'name' => 'settings',
                'active' => false,
                'icon' => 'fas fa-cogs',
                'url' => $this->getLayout()->getUrl(['controller' => 'settings', 'action' => 'index'])
            ]
        ];

        if ($this->getRequest()->getActionName() == 'treat') {
            $items[0][0]['active'] = true;
        } else {
            $items[0]['active'] = true;
        }

        $this->getLayout()->addMenu
        (
            'twitchstreams',
            $items
        );
    }

    public function indexAction()
    {
        $mapper = new StreamerMapper();

        $this->getLayout()->getAdminHmenu()
            ->add($this->getTranslator()->trans('twitchstreams'), ['controller' => 'index', 'action' => 'index'])
            ->add($this->getTranslator()->trans('menuStreamer'), ['action' => 'index']);

        if ($this->getRequest()->getPost('check_streamer')) {
            if ($this->getRequest()->getPost('action') == 'delete') {
                foreach ($this->getRequest()->getPost('check_streamer') as $id) {
                    $mapper->delete($id);
                }
            }
        }

        $this->getView()->set('streamer', $mapper->getStreamer());
    }

    public function treatAction()
    {
        $mapper = new StreamerMapper();
        $streamer = new StreamerModel();

        if ($this->getRequest()->getParam('id')) {
            $this->getLayout()->getAdminHmenu()
                ->add($this->getTranslator()->trans('twitchstreams'), ['action' => 'index'])
                ->add($this->getTranslator()->trans('edit'), ['action' => 'treat']);

            $streamer = $mapper->readById($this->getRequest()->getParam('id'));
            $this->getView()->set('streamer', $streamer);

            if (!$streamer) {
                $this->redirect()
                        ->to(['action' => 'index']);
            }
        } else {
            $this->getLayout()->getAdminHmenu()
                ->add($this->getTranslator()->trans('twitchstreams'), ['controller' => 'index', 'action' => 'index'])
                ->add($this->getTranslator()->trans('add'), ['action' => 'treat']);
        }

        if ($this->getRequest()->isPost()) {
            Validation::setCustomFieldAliases([
                'inputUser' => 'streamer'
            ]);
            
            if ($streamer->getUser() === null || $this->getRequest()->getPost('inputUser') !== $streamer->getUser()) {
                $validationrules = ['inputUser' => 'required|unique:twitchstreams_streamer,user'];
            } else {
                $validationrules = ['inputUser' => 'required'];
            }

            $validation = Validation::create($this->getRequest()->getPost(), $validationrules);

            if ($validation->isValid()) {
                $streamer->setUser($this->getRequest()->getPost('inputUser'));
                
                $mapper->updateOnlineStreamer($this->getConfig()->get('twitchstreams_apiKey'), $streamer);

                $this->redirect()
                    ->withMessage('saveSuccess')
                    ->to(['action' => 'index']);
            }

            $this->addMessage($validation->getErrorBag()->getErrorMessages(), 'danger', true);
            $this->redirect()
                ->withInput()
                ->withErrors($validation->getErrorBag())
                ->to(array_merge(['action' => 'treat'], ($this->getRequest()->getParam('id') ? ['id' => $this->getRequest()->getParam('id')] : [])));
        }
    }

    public function updateAction()
    {
        $mapper = new StreamerMapper();

        $mapper->updateOnlineStreamer($this->getConfig()->get('twitchstreams_apiKey'));

        $this->redirect()
            ->withMessage('updateSuccess')
            ->to(['action' => 'index']);
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isSecure()) {
            if ($this->getRequest()->getParam('id')) {
                $mapper = new StreamerMapper();
                $mapper->delete($this->getRequest()->getParam('id'));

                $this->redirect()
                    ->withMessage('deleteSuccess')
                    ->to(['action' => 'index']);
            }
        }

        $this->redirect()
            ->to(['action' => 'index']);
    }
}
