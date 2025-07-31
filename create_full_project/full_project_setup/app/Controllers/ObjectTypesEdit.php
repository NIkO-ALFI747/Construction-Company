<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ObjectTypesModel;

class ObjectTypesEdit extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new ObjectTypesModel();
    }

    public function index(): string
    {
        $data['response_table'] = json_encode($this->model->getObjectTypesDataWithId(), JSON_UNESCAPED_UNICODE);
        $data['title'] = 'Изменение/удаление типов объектов';
        return view('templates/Header', $data)
            . view('pages/EditObjectTypes', $data)
            . view('templates/Footer');
    }

    public function deleteObjectType()
    {
        $deleteId = $this->request->getPost('deleteId');
        $status = $this->model->deleteObjectType($deleteId);
        return $this->response->setJSON($status);
    }

    public function getObjectTypesDataWithId()
    {
        $response_table = $this->model->getObjectTypesDataWithId();
        return $this->response->setJSON($response_table);
    }

    public function getObjectTypesData()
    {
        $select_object_types = $this->model->getObjectTypesData();
        return $this->response->setJSON($select_object_types);
    }

    public function editObjectType()
    {
        $editId = $this->request->getPost('editId');
        $typeName = $this->request->getPost('type_name');
        $status = $this->model->editObjectType($editId, $typeName);
        return $this->response->setJSON($status);
    }
}
