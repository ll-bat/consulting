<?php

namespace App\Helperclass;

use App\Export;
use App\Objects;

class Json {
    private int $exportId;
    private int $fieldId;

    public function __construct($exportId = 0){
        $this->exportId = $exportId;
    }

    public function setFieldId($fieldId) {
        $this->fieldId = $fieldId;
    }

    /**
     * @param $export
     * @return mixed
     */
    public static function sload($export){
        return json_decode($export->data, true);
    }

    /**
     * @param $export
     * @return mixed
     */
    public function load($export){
        return json_decode($export->data, true);
    }

    /**
     * @param $data
     * @return int
     * @throws \Exception
     */
    public function save($data): int
    {
        $data = json_encode($data);

        if ($this->exportId) {
            return $this->update($data);
        }

        return $this->create($data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data) {
        $docData = session()->get('_docData') ?? false;
        if (!$docData) {
            throw new \Exception('Bad request', 400);
        }

        $objectId = $docData['objectId'];

        $ok = Objects::where('id', $objectId)->where('user_id', current_user()->id)->limit(1)->count() > 0;
        if (!$ok) {
            throw new \Exception('Such object does not exist', 400);
        }

        $filename = $docData['filename'];
        if (!$filename) {
            throw new \Exception('Document filename not provided', 400);
        }

        $export = Export::create([
            'user_id' => current_user()->id,
            'filename' => $filename,
            'object_id' => $objectId,
            'field_id' => $this->fieldId,
            'data' => $data,
            'author-names' => $docData['author-names'],
            'address' => $docData['address'],
            'description' => $docData['description'],
            'first_date' => $docData['first_date'],
            'second_date' => $docData['second_date'],
            'number' => $docData['number']
        ]);

        return $export->id;
    }

    /**
     * @param $data
     * @return int
     */
    public function update($data): int
    {
        $export = Export::where('id', $this->exportId)
            ->where('user_id', current_user()->id)
            ->first();

        if (!$export) {
            throw new \Exception('Such export does not exist', 400);
        }

        $ok = $export->update(['data' => $data]);
        if (!$ok) {
            throw new \Exception('ვერ მოხერხდა დოკუმენტის განახლება გაურკვეველი მიზეზების გამო. გთხოვთ, სცადოთ ახლიდან', 400);
        }

        return $this->exportId;
    }
}



