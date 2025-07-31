<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ObjectsModel;
use App\Models\ObjectTypesModel;

class ObjectsCreate extends BaseController
{
    private $objects_model;
    private $object_types_model;

    public function __construct() {
        $this->objects_model = new ObjectsModel();
        $this->object_types_model = new ObjectTypesModel();
    }

    public function index(): string
    {
        $data['select_object_types'] = json_encode(
            $this->object_types_model->getObjectTypesData(), JSON_UNESCAPED_UNICODE);
        $data['title'] = 'Добавить новый объект';
        return view('templates/Header', $data)
            . view('pages/CreateObject')
            . view('templates/Footer');
    }

    public function create()
    {
        $postData = $this->request->getPost();

        $typeName = $postData['object_type'] ?? '';
        
        $typeId = $this->objects_model->getTypeIdByName($typeName);
        
        if (!$typeId) {
            return $this->response->setStatusCode(400)->setJSON('Тип объекта не найден');
        }
        
        $object = [
            'ID_type' => $typeId,
            'Name'    => $postData['object_name'] ?? '',
            'City'    => $postData['object_city'] ?? '',
            'Street'  => $postData['object_street'] ?? '',
        ];

        $success = $this->objects_model->create($object);

        if ($success) {
            return $this->response->setStatusCode(200)->setJSON('Информация о новом объекте добавлена');
        } else {
            return $this->response->setStatusCode(500)->setJSON('Ошибка при добавлении объекта');
        }
    }
}