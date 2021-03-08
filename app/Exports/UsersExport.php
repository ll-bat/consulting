<?php

namespace App\Exports;

use App\Helperclass\Content;
use App\Helperclass\Obj;
use Faker\Provider\File;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromView, WithDrawings, WithStyles, ShouldAutoSize
{
    protected $export = null;
    protected ?Obj $data = null;
    protected $all = null;
    protected $docAbout = [];

    public function __construct($export)
    {
        $this->export = $export;
        $this->init();
    }

    public function init()
    {
        $con = new Content($this->export);
        $this->docAbout = $con->docAbout;
        $con = $con->getData();
        $this->data = $con[1];
        $this->all = $con[0];
    }

    public function view(): View
    {
        return view('user.docs.table', [
            'countAll' => $this->all,
            'object' => $this->data,
            'docAbout' => $this->docAbout
        ]);
    }

    public function drawings()
    {
//        new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();

//         $all = $this->data->getImages();
//        $all = [];
//        $images = [];
//        $c = 7;

//        foreach ($all as $image) {
//            if (!$image['has']) {
//                $c += $image['max'];
//                continue;
//            }

//            $drawing = new Drawing();
//            $drawing->setName('Image');
//            $drawing->setDescription('This is my Image');
//            $path = $image['path'];
//            $drawing->setPath($path, false);
//            $drawing->setHeight();
//            $drawing->setWidth(7);
////            $drawing->setOffsetX(15);
////            $drawing->setOffsetY(18 * ($image['max'] - 1) + 3);
//            $drawing->setCoordinates("D$c");
//            $images[] = $drawing;
//
//            $c += $image['max'];
//        }

//        return $images;
        return [];
    }


    public function styles(Worksheet $sheet)
    {
        /**
         * Get the grid coordinates
         * This part is required as we want to vertically center values in each cell
         */
        $startCell = 'B2';
        /** '13' here is the starting coordinate of the form itself, beside header */
        $endCell = 'Q' . (13 + $this->all);

        $sheet->getStyle("$startCell:$endCell")
            ->getAlignment()
            ->setVertical(Alignment::HORIZONTAL_CENTER);
    }

}
