<?php
/**
 * @var Obj $object
 */

use App\Helperclass\Obj;

?>

    <!doctype html>
<html>
<head>
    <style>
        body {
            font-family: DejaVu Sans;
        }

        thead tr td {
            vertical-align: middle;
            border: 1px solid #b8b894;
            background-color: #DEEAF6;
            text-align: center;
            font-size: 12px;
        }

        tbody tr td {
            font-size: 12px;
            border: 1px solid #b8b894;
            background-color: #EAECEB;
            text-align: center;
        }

        .bg-dlight {
            background-color: #D9D9D9;
        }

        .bg-primary {
            background-color: #0070C0 !important;
            color: white !important;
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
        <td rowspan='2'> პროცესი</td>
        <td rowspan='2' style=''> საფრთხე</td>
        <td rowspan='2' style='color: #ff00ff;'> საფრთ.ამს.<br/>ფოტო</td>
        <td rowspan='2' style=''> პოტენციური ზიანი</td>
        <td rowspan='2' style=''> ვინ იმყოფება <br/> რისკის ქვეშ</td>
        <td rowspan='2' style=''> არსებული კონტროლის ზომები <br/> <i class="text-sm text-muted">(საწყის ეტაპზე)</i></td>
        <td colspan='3' style='color:#ff0000;'> საწყისი რისკი</td>
        <td rowspan='2' style=''> კონტროლის დამატებითი ზომები <br/>
            <i class="text-sm text-muted">(გატარებული ან/და მიმდინარე)</i>
        </td>
        <td colspan='3' style='color:#28A78C;'> ნარჩენი რისკი</td>
        <td rowspan='2' class=''> გასატარებელი ღონისძიებები</td>
        <td rowspan='2' style=''> პასუხისმგებელი <br/> პირი</td>
        <td rowspan='2' style=''> შესრ.ვადა</td>
    </tr>
    <tr>
        <td style="padding: 3px 10px"> ა</td>
        <td style='padding: 3px 10px'> შ</td>
        <td style='font-size: .65rem'> რისკის <br/> დონე</td>
        <td style='padding: 3px 10px'> ა</td>
        <td style='padding: 3px 10px'> შ</td>
        <td style='font-size: .65rem'> რისკის <br/> დონე</td>
    </tr>
    <thead>

    <tbody>
    @for ($i = 0; $i < $countAll; $i++)
        <?php $dangerMax = $object->getDangerMax($i); ?>
        <tr>
            @if ($object->hasNewProcess($i))
                <td rowspan="{{ $object->getProcessMax($i) }}" class="text-sm" style='height:100px;'>
                    {{ $object->getProcessName($i) }}
                </td>
            @endif
            @if ($object->hasNewDanger($i))
                <td rowspan="{{ $dangerMax }}" class="text-sm" style='height:100px;'>
                    {{ $object->getDangerName($i) }}
                </td>
                <td rowspan="{{ $dangerMax }}">
                    @if ($object->hasImage($i))
                        <img src="data:image/jpeg;base64,{{base64_encode($object->getImageContent($i))}}"
                             class='hoverable-image' style='max-width:7rem;max-height:5rem;'/>
                    @endif
                </td>

                @foreach(['ploss', 'udanger'] as $type)
                    <td rowspan="{{ $dangerMax }}" class='text-sm'>
                        <div class="my-2">
                            @foreach($object->getWholeElements($type, $i) as $value)
                                <p class=""> {{ $value }} </p>
                            @endforeach
                        </div>
                    </td>
                @endforeach
            @endif
            <td class="text-sm">
                {{ $object->getControl(0, $i)}}
            </td>
            @if ($object->hasNewDanger($i))
                <td rowspan="{{ $dangerMax }}" class='bg-lightgrey'>
                    {{$object->getResult('first_probability', $i)}}
                </td>
                <td rowspan="{{ $dangerMax }}" class='bg-lightgrey'>
                    {{$object->getResult('first_result', $i)}}
                </td>
                <?php
                $score = $object->getResult('first_level', $i);
                $color = $object->getRiskColor($score);
                ?>
                <td rowspan="{{ $dangerMax }}" style="background: {{ $color }}; border-color: {{ $color }}">
                    {{ $score }}
                </td>
            @endif
            <td class="text-sm">
                {{ $object->getControl(1, $i)}}
            </td>
            @if ($object->hasNewDanger($i))
                <td rowspan="{{ $dangerMax }}" class='bg-lightgrey'>
                    {{$object->getResult('second_probability', $i)}}
                </td>
                <td rowspan="{{ $dangerMax }}" class='bg-lightgrey'>
                    {{$object->getResult('second_result', $i)}}
                </td>
                <?php
                $score = $object->getResult('second_level', $i);
                $color = $object->getRiskColor($score);
                ?>
                <td rowspan="{{ $dangerMax }}" style="background: {{ $color }}; border-color: {{ $color }}">
                    {{ $score }}
                </td>
            @endif
            <td class="text-sm py-2">
                {{ $object->getControl(2, $i) }}
            </td>
            </td>
            @if ($object->hasNewDanger($i))
                @foreach(['rpersons', 'etimes'] as $type)
                    <td rowspan="{{ $dangerMax }}" class='text-sm'>
                        <div class="my-2">
                            @foreach($object->getWholeElements($type, $i, false) as $value)
                                <p class=""> {{ $value }} </p>
                            @endforeach
                        </div>
                    </td>
                @endforeach
            @endif
        </tr>

    @endfor
    </tbody>
</table>
</body>
</html>
