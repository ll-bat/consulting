<?php


namespace App\Helperclass;


class QuestionsJson
{
     public array $data;

     public function __construct(array $data, bool $saveImages = true) {
         $this->init($data, $saveImages);
     }

     public function init($_data, $saveImages) {

         $obj = [];
         $images = [];

         try {
             $_data = $_data[0];

             foreach ($_data as $process) {
                 foreach ($process as $danger) {

                     if (gettype($danger) !== 'object') continue;

                     list($pid, $did) = [$danger->pid, $danger->did];

                     $el =  [
                         'pid' => $pid,
                         'did' => $did
                     ];

                     $danger = $danger->data;

                     $data = [
                         'hasImage' => false,
                         'image' => '',
                         'oldImage' => $danger->hasImage ? $danger->imageName : ''
                     ];

                     if ($danger->hasImage) {
                         if (!isset($images[$pid])) {
                             $images[$pid] = [];
                         }

                         $images[$pid][$did] = $data['oldImage'];
                     }

                     $data['control'] = [];

                     foreach ([0, 1, 2] as $answer) {
                         foreach ($danger->control[$answer] as $control) {
                             $data['control'][] = [
                                 'id' => $control->id,
                                 'value' => $answer
                             ];
                         }
                     }

                     $data['ploss'] = $data['udanger'] = [];

                     foreach (['ploss', 'udanger'] as $type) {
                         $typeData = $danger->{$type};
                         foreach ($typeData as $val) {
                             $data[$type][] = [
                                 'id' => $val->id,
                                 'value' => 1
                             ];
                         }
                     }

                     foreach (['newControls', 'newUdangers', 'rpersons', 'etimes'] as $type) {
                         $typeVal = $danger->{$type};
                         $data[$type] = $typeVal;
                         if (!$typeVal) {
                             $data[$type][] = ['value' => ''];
                         }
                     }

                     $el['data'] = $data;
                     $obj[] = $el;
                 }
             }

             $this->data = $obj;

             if ($saveImages) {
                 session()->put('_oldImages', $images);
             }

         } catch (\Exception $e) {
//             dd($e->getMessage() . '; line - ' . $e->getLine());
             $this->data = [];
         }

         $this->data = $obj;
     }

     public function getData(): array
     {
         return $this->data;
     }
}
