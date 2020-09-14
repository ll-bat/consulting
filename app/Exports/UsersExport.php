<?php

namespace App\Exports;

use App\User;
use App\Export;
use App\Helperclass\Content;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromView,WithDrawings,ShouldAutoSize
{
    protected $exportFilename = null;
    protected $data           = null;
    protected $all            = null;

    public function __construct($exportFilename){
        $this->exportFilename = $exportFilename;
        $this->init();
    }

    public function init(){
        $con = new Content($this->exportFilename);
        $con = $con->getData();
        $this->data = $con[1];
        $this->all  = $con[0];
    }

    public function view(): View
    {
        return view('user.docs.table', [
            'countAll' => $this->all,
            'object'   => $this->data
        ]);
    }

    public function drawings()
    {
        $all = $this->data->getImages();
        $images = [];
        $c = 7;

        foreach ($all as $image){
            if (!$image['has']) {
                $c += $image['max'];
                continue;
            }

            $drawing = new Drawing();
            $drawing->setName('Image');
            $drawing->setDescription('This is my Image');
            $path = $image['path'];
            $drawing->setPath($path);       
            $drawing->setHeight(35);
            $drawing->setWidth(70);
            $drawing->setOffsetX(15);
            $drawing->setOffsetY(18*($image['max']-1) + 3);
            $drawing->setCoordinates("D$c");
            $images[] = $drawing;

            $c += $image['max'];
        }

        return $images;
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('B2:O2')->getFont()->setBold(true);
    }
    
}
