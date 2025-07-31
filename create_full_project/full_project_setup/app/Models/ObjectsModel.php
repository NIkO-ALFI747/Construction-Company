<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\ObjectTypesModel;

class ObjectsModel extends Model
{
    protected $DBGroup = 'default';
    protected $allowedFields = ['ID_type', 'Name', 'City', 'Street'];
    protected $table = 'objects';
    protected $primaryKey = 'ID_object';
    protected $useTimestamps = false;
    protected $db;
    private $object_types_model;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        parent::__construct($this->db);
        $this->object_types_model = new ObjectTypesModel();
    }

    public function getTypeIdByName(string $typeName): ?int
    {
        $builder = $this->db->table('types_of_objects');
        $builder->select('ID_type');
        $builder->where('Name', $typeName);
        $query = $builder->get();
        $row = $query->getRowArray();

        return $row['ID_type'] ?? null;
    }

    public function create(array $objectData): bool
    {
        return $this->insert($objectData);
    }

    public function getObjectDataWithId(): array
    {
        $builder = $this->db->table('objects')
            ->select('objects.ID_object AS Номер_объекта, types_of_objects.Name AS Тип_объекта, 
            objects.Name AS Название_объекта, City AS Город, Street AS Улица')
            ->join('types_of_objects', 'objects.ID_type = types_of_objects.ID_type')
            ->orderBy('objects.ID_object', 'ASC');
        $query = $builder->get();
        return $this->object_types_model->formatResultToArray($query);
    }

    public function getObjectData(): array
    {
        $builder = $this->db->table('objects')
            ->select('types_of_objects.Name AS Тип_объекта, 
            objects.Name AS Название_объекта, City AS Город, Street AS Улица')
            ->join('types_of_objects', 'objects.ID_type = types_of_objects.ID_type')
            ->orderBy('types_of_objects.Name', 'ASC');
        $query = $builder->get();
        return $this->object_types_model->formatResultToArray($query);
    }

    public function getObjectsDataName(): array
    {
        $query = $this->db->table('objects')->select('Name')->get();
        return $this->object_types_model->formatResultToArray($query, false);
    }

    public function deleteObject(int $deleteId): bool
    {
        return $this->delete($deleteId);
    }

    public function editObject(int $editId, int $typeId, string $objectName, string $city, string $street): bool
    {
        $data = [
            'ID_type' => $typeId,
            'Name'    => $objectName,
            'City'    => $city,
            'Street'  => $street,
        ];

        return $this->update($editId, $data);
    }

    public function getFilteredObjectsData(?string $city = null, ?string $type = null): array
    {
        $builder = $this->db->table('objects')
            ->select('types_of_objects.Name AS Тип_объекта, objects.Name AS Название_объекта, City AS Город, Street AS Улица')
            ->join('types_of_objects', 'objects.ID_type = types_of_objects.ID_type');

        if ($city) {
            $builder->where('City', $city);
        }
        if ($type) {
            $builder->where('types_of_objects.Name', $type);
        }

        $builder->orderBy('types_of_objects.Name', 'ASC');

        $query = $builder->get();
        return $this->object_types_model->formatResultToArray($query);
    }

    public function getSearchedObjectsData(?int $columnIndex = null, ?string $searchValue = null): array
    {
        $columnMap = [
            0 => 'types_of_objects.Name',
            1 => 'objects.Name',
            2 => 'City',
            3 => 'Street',
        ];

        $builder = $this->db->table('objects')
            ->select('types_of_objects.Name AS Тип_объекта, objects.Name AS Название_объекта, City AS Город, Street AS Улица')
            ->join('types_of_objects', 'objects.ID_type = types_of_objects.ID_type');

        if (isset($columnIndex, $searchValue) && array_key_exists($columnIndex, $columnMap)) {
            $builder->like($columnMap[$columnIndex], $searchValue, 'after');
        }

        $builder->orderBy('types_of_objects.Name', 'ASC');

        $query = $builder->get();
        return $this->object_types_model->formatResultToArray($query);
    }

    public function getSortedObjectsData(?int $columnIndex = null, ?int $sortDirection = null): array
    {
        $columnMap = [
            0 => 'types_of_objects.Name',
            1 => 'objects.Name',
            2 => 'City',
            3 => 'Street',
        ];

        $directionMap = [
            0 => 'ASC',
            1 => 'DESC',
        ];

        $column = $columnMap[$columnIndex] ?? 'types_of_objects.Name';
        $direction = $directionMap[$sortDirection] ?? 'ASC';

        $builder = $this->db->table('objects')
            ->select('types_of_objects.Name AS Тип_объекта, objects.Name AS Название_объекта, City AS Город, Street AS Улица')
            ->join('types_of_objects', 'objects.ID_type = types_of_objects.ID_type')
            ->orderBy($column, $direction);

        $query = $builder->get();
        return $this->object_types_model->formatResultToArray($query);
    }
}
