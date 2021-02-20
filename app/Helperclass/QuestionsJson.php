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

                     if (gettype($danger) !== 'object') {
                         continue;
                     }

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
                     $data['newControls'] = [
                         'first' => [],
                         'second' => []
                     ];

                     foreach ([0, 1, 2, 3] as $answer) {
                         $index = 'first';
                         if ($answer === 1) {
                             $index = 'second';
                         }
                         foreach ($danger->control[$answer] as $control) {
                             if (isset($control->added)) {
                                 $data['newControls'][$index][] = ['value' => $control->model->name];
                             } else {
                                 $data['control'][] = [
                                     'id' => $control->id,
                                     'value' => $answer
                                 ];
                             }
                         }
                     }

                     $data['ploss'] = $data['udanger'] = [];
                     $data['newPloss'] = $data['newUdangers'] = [];

                     foreach ([['ploss', 'newPloss'], ['udanger', 'newUdangers']] as [$type, $ref]) {
                         $typeData = $danger->{$type};
                         foreach ($typeData as $val) {
                             if (isset($val->added)) {
                                 $data[$ref][] = ['value' => $val->model->name];
                             } else {
                                 $data[$type][] = [
                                     'id' => $val->id,
                                     'value' => 1
                                 ];
                             }

                         }
                     }

                     foreach (['rpersons'] as $type) {
                         $typeVal = $danger->{$type};
                         $data[$type] = $typeVal ?? [];
                     }

                     $data['etimes'] = [
                         'normal' => [],
                         'time' => [],
                     ];

                     if (isset($danger->etimes)) {
                         foreach ($danger->etimes as $etime) {
                             if (isset($etime->type)) {
                                 $data['etimes'][$etime->type][] = ['value' => $etime->value];
                             }
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
             dd($e->getMessage() . '; line - ' . $e->getLine());
             exit;
             $this->data = [];
         }

//         dd($this->data);

     }

     public function getData(): array
     {
         return $this->data;
     }
}
