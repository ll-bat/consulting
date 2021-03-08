<?php
/**
 * @var Obj $object
 */

use App\Helperclass\Obj;
?>

    <!doctype html>
<html>
<body>

@include('user.docs._doc-header', compact('docAbout'))

<table style='border: 2px dashed #123abc'>
    <thead>
    <tr>
        <td height='20'></td>
    </tr>
    <tr>
        <td height='20'></td>
    </tr>
    <tr>
        <td height='20'></td>
    </tr>
    <tr>
        <td height='20'></td>
    </tr>
    <tr style='border: 5px dashed #ccc'>
        <td width='5' height='22'></td>
        <td rowspan='2' align='center' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> პროცესი
        </td>
        <td rowspan='2' align='center' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> საფრთხე
        </td>
        <td rowspan='2' align='center' width='20' height='22'
            style='vertical-align:middle;color: #ff00ff;border:7px solid #b8b894;background-color:#DEEAF6'>
            საფრთ.ამს.<br/>ფოტო
        </td>
        <td rowspan='2' align='center' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> პოტენციური ზიანი
        </td>
        <td rowspan='2' align='center' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> ვინ იმყოფება <br/> რისკის
            ქვეშ
        </td>
        <td rowspan='2' align='center' width='25' height='22'
            style='font-size: 10px;border:7px solid #b8b894;background-color:#DEEAF6'>
            არსებული კონტროლის <br/>ზომები <br/>
            <span>(საწყის ეტაპზე)</span>
        </td>
        <td colspan='3' align='center' width='20' height='22'
            style='vertical-align:middle;color:#ff0000;border:7px solid #b8b894;background-color:#DEEAF6'> საწყისი რისკი
        </td>
        <td rowspan='2' align='center' width='25' height='22'
            style='vertical-align:middle;font-size:8px;border:7px solid #b8b894;background-color:#DEEAF6'>
            კონტროლის დამატებითი ზომები <br/> <span>(გატარებული ან/და მიმდინარე)</span>
        </td>
        <td colspan='3' align='center' width='20' height='22'
            style='vertical-align:middle;color:#28A78C;border:7px solid #b8b894;background-color:#DEEAF6'> ნარჩენი რისკი
        </td>
        <td rowspan='2' align='center' width='25' height='22'
            style='font-size: 10px;border:7px solid #b8b894;background-color:#DEEAF6'>
            გასატარებელი <br/>ღონისძიებები
        </td>
        <td rowspan='2' align='center' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> პასუხისმგებელი <br/> პირი
        </td>
        <td rowspan='2' align='center' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> შესრ.ვადა
        </td>
    </tr>
    <tr>
        <td width='5' height='22'></td>
        <td align='center' width='7' height='24'
            style='font-size:8px;background-color:#DEEAF6;border:5px solid #b8b888'> ა
        </td>
        <td align='center' width='7' height='24'
            style='font-size:8px;background-color:#DEEAF6;border:5px solid #b8b888'> შ
        </td>
        <td align='center' width='7' height='24'
            style='font-size:8px;background-color:#DEEAF6;border:5px solid #b8b888'> რისკის <br/> დონე
        </td>
        <td align='center' width='7' height='24'
            style='font-size:8px;background-color:#DEEAF6;border:5px solid #b8b888'> ა
        </td>
        <td align='center' width='7' height='24'
            style='font-size:8px;background-color:#DEEAF6;border:5px solid #b8b888'> შ
        </td>
        <td align='center' width='7' height='24'
            style='font-size:8px;background-color:#DEEAF6;border:5px solid #b8b888'> რისკის <br/> დონე
        </td>
    </tr>
    <thead>

    <tbody>
    @for ($i = 0; $i < $countAll; $i++)
        <?php $dangerMax = $object->getDangerMax($i); ?>
        <tr style='height:20px'>
            <td width='5' height='22'></td>

            @if ($object->hasNewProcess($i))
                <td rowspan="{{ $object->getProcessMax($i) }}" align='center'
                    style='height:35px;font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB'>{{ $object->getProcessName($i) }}</td>
            @endif
            @if ($object->hasNewDanger($i))
                <td rowspan="{{ $dangerMax }}" align='center'
                    style='height:35px;font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB'>
                    {{ $dangerMax }}
                </td>

                <td rowspan="{{ $dangerMax }}" style='border:7px solid #b8b894;background-color:#EAECEB'>
{{--                    @if ($object->hasImage($i))--}}
{{--                        <img src="{{ $object->getImageContent($i) }}"--}}
{{--                             width="70"--}}
{{--                             alt=""--}}
{{--                        />--}}
{{--                    @endif--}}
                </td>

                @foreach(['ploss', 'udanger'] as $type)
                    <td rowspan="{{ $dangerMax }}" class='small1' align='center'
                        style="border:7px solid #b8b894;background-color:#EAECEB;">
                        <div>
                            @foreach($object->getWholeElements($type, $i) as $value)
                                <p style='font-size: 10px;margin-bottom: 5px !important;'> {{ $value }} </p>
                            @endforeach
                        </div>
                    </td>
                @endforeach

            @endif

            <td class='' align='center'
                style='font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB'>{{ $object->getControl(0, $i)}}</td>
            @if ($object->hasNewDanger($i))
                <td rowspan="{{ $dangerMax }}" align='center'

                    style="background-color:#EAECEB;border:7px solid #b8b894;"
                >

                    {{$object->getResult('first_probability', $i)}}

                </td>

                <td rowspan="{{ $dangerMax }}" align='center'

                    style="background-color:#EAECEB;border:7px solid #b8b894;"
                >
                    {{$object->getResult('first_result', $i)}}

                </td>

                <?php
                $score = $object->getResult('first_level', $i);
                $color = $object->getRiskColor($score);
                ?>
                <td rowspan="{{ $dangerMax }}"
                    align='center'
                    style="background: {{ $color }}; border-color: {{ $color }}">
                    {{ $score }}
                </td>

            @endif
            <td class='' align='center'
                style='font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB'>{{ $object->getControl(1, $i)}}</td>
            @if ($object->hasNewDanger($i))
                <td rowspan="{{ $dangerMax }}" align='center'
                    style="background-color:#EAECEB;border:7px solid #b8b894;">
                    {{$object->getResult('second_probability', $i)}}
                </td>
                <td rowspan="{{ $dangerMax }}" align='center'
                    style="background-color:#EAECEB;border:7px solid #b8b894;">
                    {{$object->getResult('second_result', $i)}}
                </td>

                <?php
                $score = $object->getResult('second_level', $i);
                $color = $object->getRiskColor($score);
                ?>
                <td rowspan="{{ $dangerMax }}"
                    align='center'
                    style="background: {{ $color }}; border-color: {{ $color }}">
                    {{ $score }}
                </td>
            @endif
            <td class="small" align="center"
                style="font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB">
                {{ $object->getControl(2, $i)}}
            </td>

            @if ($object->hasNewDanger($i))
                @foreach(['rpersons', 'etimes'] as $type)
                    <td rowspan="{{ $dangerMax }}" class='small' align='center'
                        style="border:7px solid #b8b894;background-color:#EAECEB">
                        <div class="my-2">
                            @foreach($object->getWholeElements($type, $i, false) as $value)
                                <p style="font-size: 10px;"> {{ $value }} </p>
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
