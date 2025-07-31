<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ObjectTypesModel;

class ObjectTypesCreate extends BaseController
{
    private $model;

    public function __construct() {
        $this->model = new ObjectTypesModel();
    }

    public function index(): string
    {
        $data['title'] = 'Добавить новый тип объекта';
        return view('templates/Header', $data)
            . view('pages/CreateObjectType')
            . view('templates/Footer');
    }

    public function create()
    {
        $typeName = $this->request->getPost('type_name');
        $status = $this->model->create($typeName);
        return $this->response->setJSON($status);
    }
}