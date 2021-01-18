<?php

namespace App\Helperclass;

use App\Export;

class Json {
    private int $exportId;

    public function __construct($exportId = 0){
        $this->exportId = $exportId;
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
        $name = md5(uniqid());
        $path = "$name.json";

        $export = Export::create(['user_id' => current_user()->id, 'filename' => $path, 'data' => $data]);

        return $export->id;
    }

    /**
     * @param $data
     * @return int
     */
    public function update($data): int
    {
        $export = Export::findOrFail($this->exportId);

        $export->update(['data' => $data]);

        return $this->exportId;
    }
}



