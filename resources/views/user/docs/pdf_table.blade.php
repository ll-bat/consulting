



<!doctype html>
<html>
  <head>
    <style>
       body { font-family: DejaVu Sans; }
       thead tr td {
          vertical-align: middle;
          border: 1px solid #b8b894;
          background-color:#DEEAF6;
          text-align:center;
          font-size: 12px;
       }

       tbody tr td {
         font-size: 12px;
         border:1px solid #b8b894;
         background-color:#EAECEB;
         text-align: center;
       }

       .bg-dlight {
          background-color: #D9D9D9;
       }

       .bg-primary {
          background-color: #0070C0 !important;
          color:white !important;
       }

       .bg-warning {
          background-color: #FFFF00 !important;
       }

       .text-sm {
           font-size: .62rem;
       }

       .text-muted {
           color: #413d3d;
       }

    </style>
  <body>

  @include('user.docs.doc-header', compact('docAbout'))

  <table>
          <thead>
                  <tr>
                     <td rowspan='2'> პროცესი </td>
                     <td rowspan='2' style=''> საფრთხე </td>
                     <td rowspan='2' style='color: #ff00ff;'> საფრთ.ამს.<br />ფოტო </td>
                     <td rowspan='2' style=''> პოტენციური ზიანი </td>
                     <td rowspan='2' style=''> ვინ იმყოფება <br/> რისკის ქვეშ </td>
                     <td rowspan='2' style=''> არსებული კონტროლის ზომები <br /> <i class="text-sm text-muted">(საწყის ეტაპზე)</i> </td>
                     <td colspan='3' style='color:#ff0000;'> საწყისი რისკი </td>
                     <td rowspan='2' style='' > კონტროლის დამატებითი ზომები <br /> <i class="text-sm text-muted">(გატარებული ან/და მიმდინარე)</i> </td>
                     <td colspan='3' style='color:#28A78C;'> ნარჩენი რისკი </td>
                     <td rowspan='2' class=''> გასატარებელი ღონისძიებები </td>
                     <td rowspan='2' style=''> პასუხისმგებელი <br/> პირი </td>
                     <td rowspan='2' style=''> შესრ.ვადა </td>
                  </tr>
                  <tr>
                     <td style="padding: 3px 10px"> ა </td>
                     <td style='padding: 3px 10px'> შ </td>
                     <td style='font-size: .65rem'> რისკის <br /> დონე</td>
                     <td style='padding: 3px 10px'> ა </td>
                     <td style='padding: 3px 10px'> შ </td>
                     <td style='font-size: .65rem'> რისკის <br /> დონე</td>
                  </tr>
              <thead>

              <tbody>
                 @for ($i = 0; $i < $countAll; $i++)
                    <tr>
                       @if ($object->hasNewProcess($i))
                       <td rowspan="{{ $object->getProcessMax($i) }}" class="text-sm" style='height:100px;'>
                           {{ $object->getProcessName($i) }}
                       </td>
                       @endif
                       @if ($object->hasNewDanger($i))
                       <td rowspan="{{ $object->getDangerMax($i) }}" class="text-sm" style='height:100px;'>
                           {{ $object->getDangerName($i) }}
                       </td>
                       <td rowspan="{{ $object->getDangerMax($i) }}">
                         @if ($object->hasImage($i))
                           <img src="data:image/jpeg;base64,{{base64_encode($object->getImageContent($i))}}" class='hoverable-image' style='max-width:7rem;max-height:5rem;' />
                         @endif
                       </td>
                       @endif
                       <td class='text-sm' style='height:50px'>
                         {{ $object->getArrayElement('ploss', $i)}}
                       </td>
                       <td class="text-sm" >
                         {{ $object->getArrayElement('udanger', $i)}}
                        </td>
                       <td class="text-sm">
                         {{ $object->getControl(0, $i)}}
                       </td>
                       @if ($object->hasNewDanger($i))
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='bg-primary'>
                        {{$object->getResult('first_probability', $i)}}
                        </td>
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='bg-dlight'>
                         {{$object->getResult('first_result', $i)}}
                        </td>
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='bg-warning'>
                         {{$object->getResult('first_level', $i)}}
                        </td>
                       @endif
                       <td class="text-sm">
                         {{ $object->getControl(1, $i)}}
                       </td>
                       @if ($object->hasNewDanger($i))
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='bg-primary'>
                         {{$object->getResult('second_probability', $i)}}
                        </td>
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='bg-dlight'>
                         {{$object->getResult('second_result', $i)}}
                        </td>
                       <td rowspan="{{ $object->getDangerMax($i) }}" class='bg-warning'>
                         {{$object->getResult('second_level', $i)}}
                       </td>
                       @endif
                       <td class="text-sm py-2">
                           {{ $object->getControl(2, $i) }}
                       </td>
                       <td class='text-sm'>
                         {{ $object->getOptionalArrayElement('rpersons', $i)}}
                       </td>
                       <td class='text-sm'>
                          {{ $object->getOptionalArrayElement('etimes', $i)}}
                        </td>
                    </tr>

                 @endfor
            </tbody>
        </table>
  </body>
</html>
