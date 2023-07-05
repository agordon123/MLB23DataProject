<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class JSONService
{
    protected $jsonPage;
    public function __construct($jsonPage)
    {
        $this->jsonPage = $jsonPage;
    }

    public function getJSON(File $file)
    {
        $file->get($this->jsonPage);
        $json = file_get_contents($this->jsonPage);
        $json = json_decode($json, true);
        return $json;
    }
}
