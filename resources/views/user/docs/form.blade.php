@extends('layouts/zim')

@section('header')
   <style>




       tr  td {
          text-align: center !important;
       }


       thead tr td {
          font-size: .7rem;
          border: 1px solid lightgrey;
          background-color: rgb(222, 234, 246);
       }

       .smaller {
          font-size: .6rem;
       }

       .small {
          font-size: .8rem;
       }

       .small1 {
          font-size: .7rem;
       }

       table tr td {
          border: 1px solid lightgrey;
       }

       .bg-dlight {
          background-color: rgba(0,0,0,.1);
          border-bottom-color:rgba(0,0,0,.1);
       }

       .bg-purple {
          background-color:purple;
          border-bottom-color: purple
       }

       .bg-primary {
          border-bottom-color:rgb(0, 122, 254);
       }

       .bg-warning {
          border-bottom-color:rgb(255, 255, 0);
       }

       .hoverable-image {
          margin:auto;
          top:0;left:0;right:0;bottom:0;
          min-width:5rem;
          position:absolute;
          width:5rem;
          min-height:5rem;
          height:5rem;
          transition: all .41s ease-in;
          z-index: 99 !important;
       }

       .hoverable-image:hover {
          position:absolute;
          left:-10rem;right:-10rem;top:-5rem;bottom:-5rem;
          min-width:20rem;
          min-height:20rem;
          border-radius:10px;
          z-index: 1;
       }

      
   </style>
@endsection

@section('content')

      <img src='' class='position-absolute' 
                  id='hovered-image'
                  onmouseout='minImage(event)' 
                  style='max-width:20rem; max-heigth:30rem;z-index:1'/>
      
       <div class='container-fluid mt-5'>
           <table class='table-striped border w-100'>
              <thead>
                  <tr>
                     <td rowspan='2'> პროცესი </td>
                     <td rowspan='2'> საფრთხე </td>
                     <td rowspan='2'> საფრთ.ამს.ფოტო </td>
                     <td rowspan='2'> პოტენციური ზიანი </td>
                     <td rowspan='2'> ვინ იმყოფება რისკის ქვეშ </td>
                     <td rowspan='2'> არსებული კონტროლის ზომები </td>
                     <td colspan='3' class='text-danger'> საწყისი რისკი </td>
                     <td rowspan='2' class='smaller'> გასატარებელ. ღონისძიებები. დამატებითი კონტროლის ზომები </td>
                     <td colspan='3' class='text-success'> ნარჩენი რისკი </td>
                     <td rowspan='2'> პასუხისმგებელი პირი </td>
                     <td rowspan='2'> შესრ.ვადა </td>
                  </tr>
                  <tr>
                     <td> ალბათობა</td>
                     <td> შედეგი</td>
                     <td> რისკის დონე</td>
                     <td> ალბათობა</td>
                     <td> შედეგი</td>
                     <td> რისკის დონე</td>
                  </tr>
              <thead>

              <tbody>
                 @for ($i = 0; $i < $countAll; $i++)
                    <tr>
                       @if ($object->hasNewProcess($i))
                       <td rowspan="{{ $object->getProcessMax($i) }}" class='smaller'>
                           {{ $object->getProcessName($i) }}
                       </td>
                       @endif 
                       @if ($object->hasNewDanger($i))
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='smaller'>
                           {{ $object->getDangerName($i) }}                       
                       </td>
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='position-relative @if (!$object->hasImage($i)) bg-purple @endif' style='@if ($object->hasImage($i)) height:5rem; width:7rem; @endif'> 
                         @if ($object->hasImage($i))
                           <img src="{{ $object->getImageName($i) }}" 
                                class='hoverable-image' 
                                onmouseover="maximImage(event, '{{$object->getImageName($i)}}')"
                                style='max-width:7rem;max-height:5rem;' />
                         @endif 
                       </td>
                       @endif 
                       <td class='small1'> 
                         {{ $object->getArrayElement('ploss', $i)}}
                       </td>
                       <td class='small1'> 
                         {{ $object->getArrayElement('udanger', $i)}}
                        </td>
                       <td class='smaller'> 
                         {{ $object->getControl(0, $i)}} 
                       </td>
                       @if ($object->hasNewDanger($i))
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='bg-primary'>
                        {{$object->getResult('first_probability', $i)}}
                        </td>
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='bg-dlight'>
                         {{$object->getResult('first_result', $i)}} 
                        </td>
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='bg-warning border-warning'>
                         {{$object->getResult('first_level', $i)}} 
                        </td>
                       @endif 
                       <td class='smaller'> 
                         {{ $object->getControl(1, $i)}} 
                       </td>
                       @if ($object->hasNewDanger($i))
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='bg-primary'>
                         {{$object->getResult('second_probability', $i)}}
                        </td>
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='bg-dlight'>
                         {{$object->getResult('second_result', $i)}}
                        </td>
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='bg-warning border-warning'> 
                         {{$object->getResult('second_level', $i)}}
                       </td>
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='small'> 
                         {{ $object->getStringElement('rperson', $i)}}
                       </td>
                       <td rowspan="{{ $object->getDangerMax($i) }}"> 
                         {{ $object->getStringElement('etime', $i)}}
                        </td>
                       @endif 
                    </tr>
                 @endfor

           
              </tbody>
           </table>
       </div>

 <script>
    st(dom.body, 'bg: rgba(32, 113, 99, .04')
 </script>
@endsection
