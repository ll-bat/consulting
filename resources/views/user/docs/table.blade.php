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
        <td rowspan='2' align='center' valign='middle' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> პროცესი
        </td>
        <td rowspan='2' align='center' valign='middle' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> საფრთხე
        </td>
        <td rowspan='2' align='center' valign='middle' width='20' height='22'
            style='vertical-align:middle;color: #ff00ff;border:7px solid #b8b894;background-color:#DEEAF6'>
            საფრთ.ამს.<br/>ფოტო
        </td>
        <td rowspan='2' align='center' valign='middle' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> პოტენციური ზიანი
        </td>
        <td rowspan='2' align='center' valign='middle' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> ვინ იმყოფება <br/> რისკის
            ქვეშ
        </td>
        <td rowspan='2' align='center' valign='middle' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> არსებული კონტროლის <br/>ზომები
        </td>
        <td colspan='3' align='center' valign='middle' width='20' height='22'
            style='vertical-align:middle;color:#ff0000;border:7px solid #b8b894;background-color:#DEEAF6'> საწყისი რისკი
        </td>
        <td rowspan='2' align='center' valign='middle' width='20' height='22'
            style='vertical-align:middle;font-size:8px;border:7px solid #b8b894;background-color:#DEEAF6'> გასატარებელ.
            ღონისძიებები. <br/> დამატებითი კონტროლის <br/> ზომები
        </td>
        <td colspan='3' align='center' valign='middle' width='20' height='22'
            style='vertical-align:middle;color:#28A78C;border:7px solid #b8b894;background-color:#DEEAF6'> ნარჩენი რისკი
        </td>
        <td rowspan='2' align='center' valign='middle' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> პასუხისმგებელი <br/> პირი
        </td>
        <td rowspan='2' align='center' valign='middle' width='20' height='22'
            style='vertical-align:middle;border:7px solid #b8b894;background-color:#DEEAF6'> შესრ.ვადა
        </td>
    </tr>
    <tr>
        <td width='5' height='22'></td>
        <td align='center' valign='middle' width='7' height='24'
            style='font-size:8px;background-color:#DEEAF6;border:5px solid #b8b888'> ალბათობა
        </td>
        <td align='center' valign='middle' width='7' height='24'
            style='font-size:8px;background-color:#DEEAF6;border:5px solid #b8b888'> შედეგი
        </td>
        <td align='center' valign='middle' width='7' height='24'
            style='font-size:8px;background-color:#DEEAF6;border:5px solid #b8b888'> რისკის <br/> დონე
        </td>
        <td align='center' valign='middle' width='7' height='24'
            style='font-size:8px;background-color:#DEEAF6;border:5px solid #b8b888'> ალბათობა
        </td>
        <td align='center' valign='middle' width='7' height='24'
            style='font-size:8px;background-color:#DEEAF6;border:5px solid #b8b888'> შედეგი
        </td>
        <td align='center' valign='middle' width='7' height='24'
            style='font-size:8px;background-color:#DEEAF6;border:5px solid #b8b888'> რისკის <br/> დონე
        </td>
    </tr>
    <thead>

    <tbody>
    @for ($i = 0; $i < $countAll; $i++)
        <tr style='height:20px'>
            <td width='5' height='22'></td>

            @if ($object->hasNewProcess($i))
                <td rowspan="{{ $object->getProcessMax($i) }}" align='center' valign='middle' style='height:35px;font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB'>{{ $object->getProcessName($i) }}</td>
            @endif
            @if ($object->hasNewDanger($i))
                <td rowspan="{{ $object->getDangerMax($i) }}" align='center' valign='middle' style='height:35px;font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB'>{{ $object->getDangerName($i) }}</td>
                <td rowspan="{{ $object->getDangerMax($i) }}" width='15' height='40'
                    style='background-color:#aa00ff;border:7px solid #b8b894;background-color:#EAECEB'>
                <!-- @if ($object->hasImage($i))
                    <img src="data:image/jpeg;base64,{{base64_encode($object->getImageName($i))}}"
                                class='hoverable-image'
                                style='max-width:7rem;max-height:5rem;' />
                         @endif -->
                </td>
            @endif
            <td class='small1' align='center' valign='middle' style='font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB'>{{ $object->getArrayElement('ploss', $i)}}</td>
            <td class='' align='center' valign='middle' height='35' style='font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB'>{{ $object->getArrayElement('udanger', $i)}}</td>
            <td class='' align='center' valign='middle' style='font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB'>{{ $object->getControl(0, $i)}}</td>
            @if ($object->hasNewDanger($i))
                <td rowspan="{{ $object->getDangerMax($i) }}" align='center' valign='middle' style='font-size: 10px;background-color:#0070C0;border:7px solid #b8b894'>{{$object->getResult('first_probability', $i)}}</td>
                <td rowspan="{{ $object->getDangerMax($i) }}" align='center' valign='middle' style='font-size: 10px;background-color:#D9D9D9;border:7px solid #b8b894'>{{$object->getResult('first_result', $i)}}</td>
                <td rowspan="{{ $object->getDangerMax($i) }}" align='center' valign='middle' style='font-size: 10px;background-color:#FFFF00;border:7px solid #b8b894'>{{$object->getResult('first_level', $i)}}</td>
            @endif
            <td class='' valign='middle' align='center' style='font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB'>{{ $object->getControl(1, $i)}}</td>
            @if ($object->hasNewDanger($i))
                <td rowspan="{{ $object->getDangerMax($i) }}" align='center' valign='middle' style='background-color:#0070C0;border:7px solid #b8b894'>{{$object->getResult('second_probability', $i)}}</td>
                <td rowspan="{{ $object->getDangerMax($i) }}" align='center' valign='middle' style='background-color:#D9D9D9;border:7px solid #b8b894'>{{$object->getResult('second_result', $i)}}
                </td>
                <td rowspan="{{ $object->getDangerMax($i) }}" valign='middle' align='center' style='background-color:#FFFF00;border:7px solid #b8b894'>{{$object->getResult('second_level', $i)}}</td>
            @endif
            <td class='small' align='center' style='font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB'>{{ $object->getOptionalArrayElement('rpersons', $i)}}</td>
            <td class='small' align='center' style='font-size: 10px;border:7px solid #b8b894;background-color:#EAECEB'>{{ $object->getOptionalArrayElement('etimes', $i)}}</td>
        </tr>
    @endfor
    </tbody>
</table>
</body>
</html>
