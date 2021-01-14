<?php

namespace App\Helperclass;

class Filter
{

    private $data;


    public function __construct($obj)
    {
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
            $d = $this->filter($o);
            if (!$d) continue;

            $newobj[] = $d;
        }

        $this->data = $newobj;
    }

    public function filter($o)
    {
        $obj = [];
        $data = [];
        $false = false;


        if (!$this->isInt($o['did'], '', $false)) return false;
        else {
            $obj['did'] = $o['did'];
        }
        if (!$this->isInt($o['pid'], '', $false)) return false;
        else {
            $obj['pid'] = $o['pid'];
        }

        if (gettype($o['data']) != 'array') return false;
        $o = $o['data'];

        if (gettype($o['hasImage']) != 'boolean') return false;
        $data['hasImage'] = $o['hasImage'];

        if ($data['hasImage'] && !$this->filterImageName($o['imageName'], 'imageName', $data)) return false;
        if (gettype($o['control']) != 'array') return false;

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


        $data['ploss'] = [];
        if (gettype($o['ploss']) == 'array') {
            foreach ($o['ploss'] as $p) {
                if (!isset($p['id']) || !isset($p['value'])) continue;
                if (!$this->isInt($p['id'], '', $false) || !$this->isInt($p['value'], '', $false)) continue;
                if ($p['value'] != 1) continue;
                $data['ploss'][] = ['id' => $p['id'], 'value' => $p['value']];
            }
        }

        $data['udanger'] = [];
        if (gettype($o['udanger']) == 'array') {
            foreach ($o['udanger'] as $u) {
                if (!isset($u['id']) || !isset($u['value'])) continue;
                if (!$this->isInt($u['id'], '', $false) || !$this->isInt($u['value'], '', $false)) continue;
                if ($u['value'] != 1) continue;
                $data['udanger'][] = ['id' => $u['id'], 'value' => $u['value']];
            }
        }


        $types = ['newControls' => 'isString',
            'newUdangers' => 'isString',
            'rpersons' => 'isString',
            'etimes' => 'isDate'
        ];

        foreach ($types as $type => $filter) {
            $data[$type] = [];
            if (gettype($o[$type]) == 'array') {
                foreach ($o[$type] as $n) {
                    if (isset($n['value']))
                        if (call_user_func([static::class, $filter], $n['value']))
                            $data[$type][] = ['value' => $n['value']];
                }
            }
        }


        //  $data['rperson'] = '';
        //  if (isset($o['rperson']) && $o['rperson'] != '')
        //     $data['rperson'] = $o['rperson'];


        //  $data['etime'] = '';
        //  if (isset($o['etime'])){
        //      if ($this->isDate($o['etime']))  $data['etime'] = $o['etime'];
        //  }

        $obj['data'] = $data;

        return $obj;
    }

    public function isInt($a, $name, &$data)
    {
        if (!preg_match('/^-?\d+$/', $a)) {
            return false;
        }

        if ($data) $data[$name] = $a;
        return true;
    }

    public function isString($str)
    {
        return is_string($str);
    }

    public function filterImageName($a, $name, &$data)
    {
        if (!preg_match('/^(image_[0-9]+_[0-9]+)$/', $a)) {
            return false;
        }

        $data[$name] = $a;
        return true;
    }

    public function isDate($d)
    {
        if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $d)) {
            return false;
        }
        return true;
    }
}



