<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SchedulesModel;
use App\Models\ObjectsModel;

class SchedulesCreate extends BaseController
{
    private $schedules_model;
    private $objects_model;

    public function __construct() {
        $this->schedules_model = new SchedulesModel();
        $this->objects_model = new ObjectsModel();
    }

    public function index(): string
    {
        $data = [
            'select_brigades' => json_encode($this->schedules_model->getBrigadesDataName(), JSON_UNESCAPED_UNICODE),
            'select_objects' => json_encode($this->objects_model->getObjectsDataName(), JSON_UNESCAPED_UNICODE),
            'title' => 'Добавить новый график работ',
        ];

        return view('templates/Header', $data)
            . view('pages/CreateSchedule', $data)
            . view('templates/Footer');
    }

    public function create()
    {
        $postData = $this->request->getPost();

        $brigadeName = $postData['brigade_name'] ?? null;
        $objectName  = $postData['object_name'] ?? null;

        if (!$brigadeName || !$objectName) {
            return $this->response->setStatusCode(400)->setJSON('Имя бригады и объекта обязательны');
        }

        $brigadeId = $this->schedules_model->getBrigadeIdByName($brigadeName);
        $objectId = $this->schedules_model->getObjectIdByName($objectName);

        if (!$brigadeId || !$objectId) {
            return $this->response->setStatusCode(400)->setJSON('ID бригады или объекта не найден');
        }

        $schedule = [
            'ID_object'           => $objectId,
            'ID_brigade'          => $brigadeId,
            'Description_of_works'=> $postData['description'] ?? '',
            'From1'               => $postData['from'] ?? null,
            'To1'                 => $postData['to'] ?? null,
            'Cost'                => $postData['cost'] ?? 0,
        ];

        $success = $this->schedules_model->create($schedule);

        if ($success) {
            return $this->response->setJSON('Информация о новом графике работ добавлена');
        }

        return $this->response->setStatusCode(500)->setJSON('Ошибка при добавлении графика работ');
    }
}