<?php

namespace App\Helperclass;

class Filter
{

    private $data;
    private $oldImages;
    private $imageNameValidator = [];

    public function __construct($obj)
    {
        $this->oldImages = session()->get('oldImages') ?? [];
        $this->startFiltering($obj);
    }

    public function getData()
    {
        return $this->data;
    }

    public function startFiltering($obj)
    {
        $newobj = [];

        foreach ($obj as $o) {
            try {
                $d = $this->filter($o);
                if (!$d) continue;
            } catch (\Exception $e) {
                continue;
            }
            $newobj[] = $d;
        }

        session()->put('rule', $this->imageNameValidator);

        $this->data = $newobj;
    }

    public function filter($o)
    {
        /**
         * Check variables and their values. If at least one variable has invalid type or value, omit whole element...
         */

        $obj = [];
        $data = [];
        $false = false;

        /**
         * DangerId should of type integer
         */
        if ($this->isInt($o['did'], '', $false)) {
            $obj['did'] = $o['did'];
        }
        else {
            return false;
        }

        /**
         * ProcessId should of type integer
         */
        if ($this->isInt($o['pid'], '', $false)) {
            $obj['pid'] = $o['pid'];
        }
        else {
            return false;
        }

        list($pid, $did) = [$obj['pid'], $obj['did']];

        /**
         * Data should be of type array
         */
        if (gettype($o['data']) != 'array') {
            return false;
        }
        $o = $o['data'];

        /*
         * Filter image name and delete old one if necessary
         */
        if (gettype($o['hasImage']) != 'boolean') {
            return false;
        }
        $data['hasImage'] = $o['hasImage'];

        $hasOldImage = false;

        if (isset($this->oldImages[$pid]) && isset($this->oldImages[$pid][$did])) {
            $hasOldImage = true;
        }

        if ($data['hasImage']) {
            if ($this->filterImageName($o['imageName'], 'imageName', $pid, $did, $data)) {
                if ($hasOldImage) {
                    // @TODO: Implement image deletion .
                }
                $this->imageNameValidator[$data['imageName']] = 'required|image|mimes:jpeg,png,jpg|max:2048';
            } else {
                return false;
            }
        } else {
            if ($hasOldImage) {
                if (!isset($o['oldImage']) || !$o['oldImage']) {
                    // @TODO: Implement old image deletion .
                    $data['hasImage'] = false;
                    $data['imageName'] = '';
                } else {
                    $data['hasImage'] = true;
                    $data['oldImage'] = true;
                    $data['imageName'] = $this->oldImages[$pid][$did];
                }
            }
        }


        /**
         * Divide controls into 3 types according to user answers
         */
        if (gettype($o['control']) != 'array') {
            return false;
        }

        $data['control'] = [[], [], []];
        foreach ($o['control'] as $c) {
            if (!isset($c['id']) || !isset($c['value'])) {
                continue;
            }
            if (!$this->isInt($c['id'], '', $false) || !$this->isInt($c['value'], '', $false)) {
                continue;
            }
            if (!in_array($c['value'], [0, 1, 2])) continue;


            $data['control'][$c['value']][] = ['id' => $c['id'], 'value' => $c['value']];
        }

        /*
         * Filter ploss and udanger
         */
        $data['ploss'] = $data['udanger'] = [];

        foreach (['ploss', 'udanger'] as $type) {
            if (gettype($o[$type]) == 'array') {
                foreach ($o[$type] as $p) {
                    if (!isset($p['id']) || !isset($p['value'])) continue;
                    if (!$this->isInt($p['id'], '', $false) || !$this->isInt($p['value'], '', $false)) continue;
                    if ($p['value'] != 1) continue;
                    $data[$type][] = ['id' => $p['id'], 'value' => $p['value']];
                }
            }
        }

        /**
         * Filter input[type='text'] fields. Array keys are form names and values - validator functions
         */
        $types = [
            'newControls' => 'isString',
            'newUdangers' => 'isString',
            'rpersons' => 'isString',
            'etimes' => 'isDate'
        ];

        foreach ($types as $type => $filter) {
            $data[$type] = [];
            if (gettype($o[$type]) == 'array') {
                foreach ($o[$type] as $n) {
                    if (isset($n['value'])) {
                        if (call_user_func([static::class, $filter], $n['value'])) {
                            $data[$type][] = ['value' => $n['value']];
                        }
                    }
                }
            }
        }

        $obj['data'] = $data;

        return $obj;
    }

    /**
     * @param $a
     * @param $name
     * @param $data
     * @return bool
     */
    public function isInt($a, $name, &$data): bool
    {
        if (!preg_match('/^-?\d+$/', $a)) {
            return false;
        }

        if ($data) $data[$name] = $a;
        return true;
    }

    /**
     * @param $str
     * @return bool
     */
    public function isString($str): bool
    {
        return is_string($str);
    }

    /**
     * @param $a
     * @param $name
     * @param $pid
     * @param $did
     * @param $data
     * @return bool
     */
    public function filterImageName($a, $name, $pid, $did, &$data): bool
    {
        if ($a !== "image_{$pid}_{$did}") {
            return false;
        }

        $data[$name] = $a;
        return true;
    }

    /**
     * @param $d
     * @return bool
     */
    public function isDate($d): bool
    {
        if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $d)) {
            return false;
        }
        return true;
    }
}



