<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ObjectsModel;

class ObjectsEdit extends BaseController
{
    private $objects_model;

    public function __construct()
    {
        $this->objects_model = new ObjectsModel();
    }

    public function index(): string
    {
        $data['response_table'] = json_encode($this->objects_model->getObjectDataWithId(), JSON_UNESCAPED_UNICODE);
        $data['title'] = 'Изменение/удаление объектов';
        return view('templates/Header', $data)
            . view('pages/EditObjects', $data)
            . view('templates/Footer');
    }

    public function deleteObject()
    {
        $deleteId = $this->request->getPost('deleteId');

        if (!$deleteId || !is_numeric($deleteId)) {
            return $this->response->setStatusCode(400)->setJSON('Invalid deleteId');
        }

        $success = $this->objects_model->deleteObject((int)$deleteId);

        if ($success) {
            return $this->response->setJSON('Информация об объекте удалена');
        } else {
            return $this->response->setStatusCode(500)->setJSON('Ошибка при удалении объекта');
        }
    }

    public function getObjectData()
    {
        $response_table = $this->objects_model->getObjectDataWithId();
        return $this->response->setJSON($response_table);
    }

    public function editObject()
    {
        $postData = $this->request->getPost();

        $editId = $postData['editId'] ?? null;
        $typeName = $postData['object_type'] ?? null;
        $objectName = $postData['object_name'] ?? null;
        $city = $postData['object_city'] ?? null;
        $street = $postData['object_street'] ?? null;

        if (!$editId || !is_numeric($editId) || !$typeName || !$objectName || !$city || !$street) {
            return $this->response->setStatusCode(400)->setJSON('Некорректные входные данные');
        }

        $typeId = $this->objects_model->getTypeIdByName($typeName);

        if ($typeId === null) {
            return $this->response->setStatusCode(400)->setJSON('Тип объекта не найден');
        }

        $success = $this->objects_model->editObject((int)$editId, $typeId, $objectName, $city, $street);

        if ($success) {
            return $this->response->setJSON("Информация об объекте с номером $editId успешно изменена");
        } else {
            return $this->response->setStatusCode(500)->setJSON('Ошибка при обновлении объекта');
        }
    }
}
