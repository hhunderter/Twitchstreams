<?php

namespace Modules\Twitchstreams\Controllers\Admin;

use \Modules\Twitchstreams\Mappers\Streamer as StreamerMapper;
use \Modules\Twitchstreams\Models\Streamer as StreamerModel;

class Index extends \Ilch\Controller\Admin
{
    public function init()
    {
        $items = array
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
                'name' => 'add',
                'active' => false,
                'icon' => 'fa fa-plus-circle',
                'url' => $this->getLayout()->getUrl(array('controller' => 'index', 'action' => 'treat'))
            ),
            array
            (
                'name' => 'settings',
                'active' => false,
                'icon' => 'fa fa-cogs',
                'url' => $this->getLayout()->getUrl(array('controller' => 'settings', 'action' => 'index'))
            )
        );  

        if ($this->getRequest()->getControllerName() == 'index' AND $this->getRequest()->getActionName() == 'treat') {
            $items[1]['active'] = true;
        } elseif ($this->getRequest()->getControllerName() == 'settings') {
            $items[2]['active'] = true;
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
                ->add($this->getTranslator()->trans('twitchstreams'), array('controller' => 'index', 'action' => 'index'))
                ->add($this->getTranslator()->trans('menuStreamer'), array('action' => 'index'));

        $this->getView()->set('streamer', $mapper->getStreamer());
    }

    public function treatAction()
    {
        $mapper = new StreamerMapper();

        if ($this->getRequest()->getParam('id')) {
            $this->getLayout()->getAdminHmenu()
                    ->add($this->getTranslator()->trans('twitchstreams'), array('action' => 'index'))
                    ->add($this->getTranslator()->trans('edit'), array('action' => 'treat'));

            $this->getView()->set('streamer', $mapper->readById($this->getRequest()->getParam('id')));
        } else {
            $this->getLayout()->getAdminHmenu()
                    ->add($this->getTranslator()->trans('twitchstreams'), array('controller' => 'index', 'action' => 'index'))
                    ->add($this->getTranslator()->trans('add'), array('action' => 'treat'));
        }

        if ($this->getRequest()->getParam('id')) {
            $streamerArray = $mapper->readById($this->getRequest()->getParam('id'));
            $streamerModel = new StreamerModel();
            $streamerModel->setId($streamerArray['id']);
            $streamerModel->setUser($streamerArray['user']);
            $streamerModel->setOnline($streamerArray['online']);
            $streamerModel->setGame($streamerArray['game']);

            $this->getView()->set('streamer', $streamerModel);
        }

        if ($this->getRequest()->isPost()) {
            $mapper = new StreamerMapper();
            $model = new StreamerModel();

            if ($this->getRequest()->getParam('id')) {
                $model->setId($this->getRequest()->getParam('id'));
            }

            $user = $this->getRequest()->getPost('inputUser');

            if (empty($user)) {
                $this->addMessage('missingUser', 'danger');
            } else {
                $model->setUser($user);
                $model->setOnline(0);
                $mapper->save($model);

                $mapper->updateOnlineStreamer();

                $this->addMessage('saveSuccess');
                
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function updateAction()
    {
        $mapper = new StreamerMapper();

        $mapper->updateOnlineStreamer();

        $this->addMessage('updateSuccess');

        $this->redirect(array('action' => 'index'));
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id')) {
            $mapper = new StreamerMapper();
            $mapper->delete($this->getRequest()->getParam('id'));

            $this->addMessage('deleteSuccess');

            $this->redirect(array('action' => 'index'));
        }
    }
}
