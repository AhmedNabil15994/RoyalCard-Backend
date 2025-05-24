<?php

namespace WAIntegration\Services;

use WAIntegration\Contracts\MessageContract;
use WAIntegration\WAconnection;

class MessageService implements MessageContract
{
    public $base = '/messages';
    public function send($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendMessage','POST',$data);
    }

    public function sendImage($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendImage','POST',$data);
    }

    public function sendVideo($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendVideo','POST',$data);
    }

    public function sendAudio($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendAudio','POST',$data);
    }

    public function sendFile($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendFile','POST',$data);
    }

    public function sendLink($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendLink','POST',$data);
    }

    public function sendSticker($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendSticker','POST',$data);
    }

    public function sendGif($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendGif','POST',$data);
    }

    public function sendLocation($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendLocation','POST',$data);
    }

    public function sendContact($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendContact','POST',$data);
    }

    public function sendMention($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendMention','POST',$data);
    }

    public function sendReaction($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendReaction','POST',$data);
    }

    public function sendBulkMessage($data)
    {
        return (new WAconnection())->startRequest($this->base.'/sendGroupMessage','POST',$data);
    }


}
