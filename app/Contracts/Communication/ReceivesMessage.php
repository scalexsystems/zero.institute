<?php namespace Scalex\Zero\Contracts\Communication;

interface ReceivesMessage
{
    public function getChannelName() : string;

    public function getChannel();

    public function getKey();

    public function getMorphClass();
}
