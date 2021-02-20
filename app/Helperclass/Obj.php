<?php

namespace App\Helperclass;

class Obj
{
    protected $object = null;
    protected $links = null;
    protected $all = null;
    protected $exportAs = null;
    protected $images = [];

    public function __construct($data, $links, $all, $exportAs = '')
    {
        $this->setData($data, $links, $all, $exportAs);
//        dd($data);
//        dd($links);
    }

    public function setData($data, $links, $all, $exportAs)
    {
        $this->object = $data;
        $this->links = $links;
        $this->all = $all;
        $this->exportAs = $exportAs;
    }

    public function getData(): array
    {
        return [$this->object, $this->links, $this->all];
    }

    public function getObject($i)
    {
        $pid = $this->getProcessInd($i);
        $did = $this->getDangerInd($i);

        return $this->object[$pid][$did]['data'];
    }

    public function shrink($con): string
    {
        if ($this->exportAs != 'pdf') return $con;
        if (!is_string($con)) return $con;
        if (mb_strlen($con) == 0) return $con;

        $con = trim($con);
        if (mb_strlen($con) > 70) return mb_substr($con, 0, 68) . '...';
        return $con;
    }

    public function getArrayElement($name, $i): string
    {
        $obj = $this->getObject($i);
        $elm = $this->getElementInd($i);

        $el = $this->getExactElement($obj, $name, $elm);
        $el = $this->shrink($el);

        return $el;
    }

    public function getExactElement(&$data, $name, $elm): string
    {
        if (count($data[$name]) > $elm) {
            return $data[$name][$elm]['model']['name'];
        }
        return '';
    }

    public function getOptionalArrayElement($type, $i): string
    {
        $obj = $this->getObject($i);
        $elm = $this->getElementInd($i);

        if (count($obj[$type]) > $elm) {
            $el = $obj[$type][$elm]['value'];
            $el = $this->shrink($el);
            return $el;
        }

        return "";
    }

    public function getStringElement($name, $i): string
    {
        $obj = $this->getObject($i);

        $el = $obj[$name];
        $el = $this->shrink($el);

        if ($el != '') return $el;
        return '';
    }

    public function getControl($type, $i): string
    {
        $obj = $this->getObject($i);
        $elm = $this->getElementInd($i);

        $controls = &$obj['control'];

        if (count($controls[$type]) > $elm) {
            $el = $controls[$type][$elm]['model']['name'];
            $el = $this->shrink($el);

            return $el;
        }

        return '';
    }

    public function getResult($name, $i)
    {
        $obj = $this->getObject($i);

        return $obj['result'][$name];
    }

    public function hasImage($i)
    {
        $obj = $this->getObject($i);

        return $obj['hasImage'];
//         return false;
    }

    public function getImageName($i, $type = 'full')
    {
        $obj = $this->getObject($i);
        $path = $obj['imageName'];

        //1 --    // if ($type == 'full')
        //   $path = asset("storage/{$obj['imageName']}");  --1 //

        // $file = Storage::get("{$obj['imageName']}");
        // dd($file);
        // return response($file, 200)->header('Content-Type', 'image/jpeg');
        return $path;
    }

    public function getImageContent($i)
    {
        $obj = $this->getObject($i);
        // $path = asset("storage/{$obj['imageName']}");

        $path = $obj['imageName'];

        // $file = Storage::get("{$obj['imageName']}");

        $file = file_get_contents($path);

        return $file;
    }

    public function getImages(): array
    {
        $images = [];
        for ($i = 0; $i < $this->all; $i++) {
            if (!$this->hasNewDanger($i)) continue;
            $has = $this->hasImage($i);
            $path = '';

            if ($has) {
                $path = $this->getImageName($i, 'partial');
                // $path = public_path("storage/$path");
                // $path = public_path("$path");
            }

            $pid = $this->getProcessInd($i);
            $did = $this->getDangerInd($i);
            $max = $this->object[$pid][$did]['max'];
            $images[] = ['max' => $max, 'has' => $has, 'path' => $path];
        }
        return $images;
    }

    public function hasNewProcess($i)
    {
        return $this->links[$i]['hasNewProcess'];
    }

    public function hasNewDanger($i)
    {
        return $this->links[$i]['hasNewDanger'];
    }

    public function getProcessMax($i)
    {
        return $this->getProcess($i)['max'];
    }

    public function getDangerMax($i)
    {
        return $this->getProcess($i)[$this->getDangerInd($i)]['max'];
    }

    public function getProcessName($i): string
    {
        $el = $this->getProcess($i)[0]['processName'];
        $el = $this->shrink($el);
        return $el;
    }

    public function getDangerName($i): string
    {
        $danger = $this->getDanger($i)['dangerName'];
        return $this->shrink($danger);
    }

    public function getProcess($i)
    {
        return $this->object[$this->links[$i]['process']];
    }

    public function getProcessInd($i)
    {
        return $this->links[$i]['process'];
    }

    public function getDanger($i)
    {
        return $this->object[$this->getProcessInd($i)][$this->getDangerInd($i)];
    }

    public function getDangerInd($i)
    {
        return $this->links[$i]['danger'];
    }

    public function getElement($i)
    {
        return $this->object[$this->getElementInd($i)];
    }

    public function getElementInd($i)
    {
        return $this->links[$i]['element'];
    }
}



