<?php

namespace Modules\Twitchstreams\Models;

class Streamer extends \Ilch\Model {
    protected $id;
    protected $user;
    protected $title;
    protected $online;
    protected $game;
    protected $viewers;
    protected $previewMedium;
    protected $link;
    protected $createdAt;
        
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setUser($user)
    {
        $this->user = $user;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setOnline($online)
    {
        $this->online = $online;
    }
    
    public function getOnline()
    {
        return $this->online;
    }
    
    public function setGame($game)
    {
        $this->game = $game;    
    }
    
    public function getGame()
    {
        return $this->game;
    }
    
    public function setViewers($viewers)
    {
        $this->viewers = $viewers;
    }
    
    public function getViewers()
    {
        return $this->viewers;
    }
    
    public function setPreviewMedium($preview)
    {
        $this->previewMedium = $preview;
    }
    
    public function getPreviewMedium()
    {
        return $this->previewMedium;
    }
    
    public function setLink($link) {
        $this->link = $link;
    }
    
    public function getLink()
    {
        return $this->link;
    }
    
    public function setCreatedAt($createdAd)
    {
        $this->createdAt = $createdAd;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
