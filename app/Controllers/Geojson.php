<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Geojson extends Controller
{
    public function show($filename = null)
    {
        $path = WRITEPATH . "../public/assets/geojson/" . $filename;

        if (!file_exists($path)) {
            return $this->response->setStatusCode(404)->setBody('File not found');
        }

        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Content-Type', 'application/json')
            ->setBody(file_get_contents($path));
    }
}
