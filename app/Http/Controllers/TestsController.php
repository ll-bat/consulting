<?php

namespace App\Http\Controllers;

use App\Control;
use App\DangerProcess;
use App\Helperclass\Filter;
use App\Helperclass\FinalData;
use App\Helperclass\Obj;
use App\Helperclass\Json;
use App\Helperclass\Content;
use App\Helperclass\QuestionsJson;
use App\Helperclass\SiteJson;
use App\Helperclass\Texts;
use App\Helperclass\Services;
use App\Helperclass\Customizable;
use App\Export;
use App\Helperclass\UserInputs;
use App\Process;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class TestsController extends Controller
{
    public function index()
    {

//        $this->setElementImage();
//        $this->testImage();
//          $a = ['1', '2', '1'];
//
//          $b = ['1'];
//
//          dd(array_diff($b, $a));

//          $controls = Control::limit(20)->orderBy('k', 'desc')->get()->toArray();
//          dd($controls);
//          $this->calc();

//          $sql = 'select danger_id, process_id from danger_process where danger_id in (52) and process_id in (1)';
//
//          $data = DB::select(DB::raw($sql));
//
////          $data = DangerProcess::whereIn('danger_id', [52])->whereIn('process_id', [1])->get();
//          dd($data);

    }

    public function setElementImage() {

        $c = new Texts();

        $c->setElementImage('services', 'between-image-and-title', '/element-images/between-image-and-title.png');

        $c->saveData($c->getData());

        dd($c->getElementImage('home', 'title'));
    }

    public function testImage() {
//        $path = 'https://res.cloudinary.com/de8t95zmf/image/upload/v1615222401/dhwebsyndtvcpagosx2m.png';

//        $image = Image::make($test)->save('storage/hello.png');
//        $image = Image::make($path)->text();

//        $data = @file_get_contents($path);
//        dd(base64_encode($data));

//        $filename = basename($path);

//        if (File::exists('storage/' . $filename)) {
//            dd($filename);
//        }
//
//        Image::make($path)->save('storage/' . $filename);

//        $image = (string) Image::make($path)->encode('data-url');
//        dd($image);

        dd(sys_get_temp_dir());
    }

    public function calc2()
    {

        $dangerIds = [56, 57];

        $controls = DB::table('controls')
            ->join('control_dangers', 'controls.id', '=', 'control_dangers.control_id')
            ->whereIn('control_dangers.danger_id', $dangerIds)
            ->selectRaw('SUM( CAST(controls.k as DECIMAL(9,2)) ) as controls_sum, control_dangers.danger_id')
            ->groupBy('control_dangers.danger_id')
            ->get()
            ->toArray();
    }

    public function calc()
    {
        $export = Export::find(74);
        $data = json_decode($export->data, true);
        $data = $data[0];

//          $data = $this->makeAssoc($data);


        dd($data);
//          UserInputs::createRecords(1, 1, $data, []);
//          $data = $this->makeAssoc($data);


//          return $data;
//          dd($data);

        $questions = new QuestionsJson($data, false);
        dd($questions->getData());
//          $data = $this->convert($data);
//          $data = $this->correctControls($data);

        $data = $questions->getData();

        $filter = new Filter($data, 1);
        $data = $filter->getData();

//          dd($filter->getAddedValues());
        UserInputs::createRecords(74, 1, $filter->getAddedValues());

        dd($data);

//          $finalData = new FinalData(false, 1);
//          $data = $finalData->init($data, 1);

        dd($data);
    }

    public function correctControls($data)
    {
        foreach ($data as &$d) {
            $old = $d['data']['control'];
            $controls = array_merge($old[0], array_merge($old[1], $old[2]));
            $d['data']['control'] = $controls;
        }
        return $data;
    }

    public function convert($data)
    {
        $obj = [];

        foreach ($data as $index => $p) {
            foreach ($p as $ind => $d) {
                if ((gettype($d) !== 'array') && gettype($d) !== 'object') continue;
                $obj[] = [
                    'pid' => $d['pid'],
                    'did' => $d['did'],
                    'data' => $d['data']
                ];
            }
        }

        return $obj;
    }

    public function makeAssoc($data)
    {

        $obj = [];

        if (!in_array(gettype($data), ['array', 'object'])) {
            return $data;
        }

        foreach ($data as $ind => $d) {
            $obj[$ind] = $this->makeAssoc($d);
        }

        return $obj;

//          $filename = $export->filename;
//
//          $dompdf = new Dompdf();
//          $customPaper = array(0,0,900,2700);
//          $dompdf->set_paper($customPaper);
//
//          $con = new Content($export, 'pdf');
//          $con = $con->getData();
//
//          $view = view('user.docs.pdf_table', [
//              'countAll' => $con[0],
//              'object'   => $con[1]
//          ])->render();
//
//          $dompdf->loadHtml($view);
//          $dompdf->render();

//          $dompdf->stream('my.pdf1',array('Attachment'=>0));
//          return response($dompdf->stream());

//          $dompdf->stream();


        //      $obj = new Customizable();

        //      dd($obj->getData());

        //  dd($this->getData());

//            $c = new SiteJson();
//
//            dd($c->getData());

//              $c = new Texts();
//
//              $data = $c->getData();
//              $data['element-images'] = [
//                  'home' => [
//                      'small-title' => '/element-images/home-small-title.png',
//                      'title' => '/element-images/home-title.png',
//                      'description' => '/element-images/home-description.png',
//                  ],
//                  'blogs' => [
//                      'title' => '/element-images/blogs-title.png'
//                  ],
//                  'services' => [
//                      'title' => '/element-images/service-title.png'
//                  ],
//                  'about' => [
//                      'title' => '/element-images/about-title.png',
//                      'title-1' => '/element-images/about-title-1.png',
//                      'description-1' => '/element-images/about-description-1.png',
//                      'title-2' => '/element-images/about-title-2.png',
//                      'description-2' => '/element-images/about-description-2.png',
//                  ],
//                  'contact' => [
//                      'title' => '/element-images/contact-title.png'
//                  ]
//              ];
//
//              $c->saveData($data);
//
//              dd($c->getData());


//              $c->setElementImage('', '', '');
//              $c->saveData();
//
//              dd($c->getElementImage('home', 'title'));
    }

    public function getData()
    {

//            $data = [];
//
//            foreach (['1','2', '3_123'] as $val){
//                   $data[$val] = $this->anotherFn($val);
//            }
//
//            return $data;
    }

    public function anotherFn($el)
    {
//            return
//                   [
//                        'is-bold' => 'yes'
//                   ];

    }
}
