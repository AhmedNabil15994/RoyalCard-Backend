<?php

namespace WAIntegration\Contracts;

interface MessageContract
{
    public function send($data);
    public function sendImage($data);
    public function sendVideo($data);
    public function sendAudio($data);
    public function sendFile($data);
    public function sendLink($data);
    public function sendSticker($data);
    public function sendGif($data);
    public function sendLocation($data);
    public function sendContact($data);
    public function sendMention($data);
    public function sendReaction($data);
    public function sendBulkMessage($data);
}
