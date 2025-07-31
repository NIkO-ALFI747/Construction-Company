<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ObjectsModel;
use App\Models\ObjectTypesModel;

class ObjectsInfo extends BaseController
{
    private $objects_model;
    private $object_types_model;

    public function __construct()
    {
        $this->objects_model = new ObjectsModel();
        $this->object_types_model = new ObjectTypesModel();
    }

    public function index()
    {
        $data = [
            'response_table' => json_encode($this->objects_model->getObjectData(), JSON_UNESCAPED_UNICODE),
            'select_object_types' => json_encode($this->object_types_model->getObjectTypesData(), JSON_UNESCAPED_UNICODE),
            'select_object_cities' => json_encode($this->object_types_model->getObjectCitiesData(), JSON_UNESCAPED_UNICODE),
            'title' => 'Информация об обьектах строительства',
        ];

        echo view('templates/Header', $data);
        echo view('pages/ObjectsInfo', $data);
        echo view('templates/Footer');
    }

    public function getFilter()
    {
        $postData = $this->request->getPost();
        $city = $postData['object_city'] ?? null;
        $type = $postData['object_type'] ?? null;

        $response = $this->objects_model->getFilteredObjectsData($city, $type);
        return $this->response->setJSON($response);
    }

    public function getSearch()
    {
        $postData = $this->request->getPost();
        $columnIndex = isset($postData['object_column']) ? (int)$postData['object_column'] : null;
        $searchVal = $postData['search_val'] ?? null;

        $response = $this->objects_model->getSearchedObjectsData($columnIndex, $searchVal);
        return $this->response->setJSON($response);
    }

    public function getSort()
    {
        $postData = $this->request->getPost();
        $columnIndex = isset($postData['object_column']) ? (int)$postData['object_column'] : null;
        $sortVal = isset($postData['sort_val']) ? (int)$postData['sort_val'] : null;

        $response = $this->objects_model->getSortedObjectsData($columnIndex, $sortVal);
        return $this->response->setJSON($response);
    }

    public function reset()
    {
        $response = $this->objects_model->getObjectData();
        return $this->response->setJSON($response);
    }

    public function getObjectsDataName()
    {
        $response = $this->objects_model->getObjectsDataName();
        return $this->response->setJSON($response);
    }
}
