<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SchedulesModel;

class SchedulesEdit extends BaseController
{
    private $schedules_model;

    public function __construct()
    {
        $this->schedules_model = new SchedulesModel();
    }

    public function index(): string
    {
        $data['response_table'] = json_encode($this->schedules_model->getSchedulesDataWithId(), JSON_UNESCAPED_UNICODE);
        $data['title'] = 'Изменение/удаление графиков работ';
        return view('templates/Header', $data)
            . view('pages/EditSchedules', $data)
            . view('templates/Footer');
    }

    public function deleteSchedule()
    {
        $deleteId = $this->request->getPost('deleteId');

        if (!$deleteId || !is_numeric($deleteId)) {
            return $this->response->setStatusCode(400)->setJSON('Invalid deleteId');
        }

        $success = $this->schedules_model->deleteSchedule((int)$deleteId);

        if ($success) {
            return $this->response->setJSON('Информация о графике удалена');
        } else {
            return $this->response->setStatusCode(500)->setJSON('Ошибка при удалении');
        }
    }

    public function getSchedulesData()
    {
        $response_table = $this->schedules_model->getSchedulesDataWithId();
        return $this->response->setJSON($response_table);
    }

    public function editSchedule()
    {
        $postData = $this->request->getPost();

        $editId = $postData['editId'] ?? null;
        $brigade = $postData['brigade_name'] ?? null;
        $object = $postData['object_name'] ?? null;
        $description = $postData['description'] ?? null;
        $from = $postData['from'] ?? null;
        $to = $postData['to'] ?? null;
        $cost = $postData['cost'] ?? null;

        if (
            !$editId || !is_numeric($editId) || !$brigade ||
            !$object || !$description || !$from || !$to || !$cost
        ) {
            return $this->response->setStatusCode(400)->setJSON('Некорректные входные данные');
        }

        $brigadeId = $this->schedules_model->getBrigadeIdByName($brigade);
        $objectId  = $this->schedules_model->getObjectIdByName($object);

        if ($brigadeId === null || $objectId === null) {
            return $this->response->setStatusCode(400)->setJSON('Имя бригады или объекта не найдено');
        }

        $success = $this->schedules_model->editSchedule($editId, $brigadeId, $objectId, $description, $from, $to, $cost);
        
        if ($success) {
            return $this->response->setJSON("Информация о графике с номером $editId успешно изменена");
        } else {
            return $this->response->setStatusCode(500)->setJSON('Ошибка при обновлении');
        }
    }
}