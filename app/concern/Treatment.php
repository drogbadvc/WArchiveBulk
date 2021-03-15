<?php
namespace App\concern;

class Treatment
{
    /**
     * @param $string
     * @return false|string[]
     */
    public function domainParse($string)
    {
        return explode("\n",trim($string));
    }
}