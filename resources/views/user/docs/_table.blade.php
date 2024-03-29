<?php
/**
 * @var Obj $object
 */

use App\Helperclass\Obj;

?>
<table class='table-striped border w-100'>
    <thead>
    <tr>
        <td rowspan='2'> {{ __("პროცესი") }}</td>
        <td rowspan='2'> {{ __("საფრთხე") }}</td>
        <td rowspan='2'> {{ __("საფრთ.ამს.ფოტო") }}</td>
        <td rowspan='2'> {{ __("პოტენციური ზიანი") }}</td>
        <td rowspan='2'> {{ __("ვინ იმყოფება რისკის ქვეშ") }}</td>
        <td rowspan='2'> {{ __("არსებული კონტროლის ზომები") }} <br/> <i class="text-muted">({{ __("საწყის ეტაპზე") }})</i></td>
        <td colspan='3' class='text-danger py-2'> {{ __("საწყისი რისკი") }}</td>
        <td rowspan='2' class='smaller'> {{ __("კონტროლის დამატებითი ზომები") }} <br/>
            <i class="text-muted">({{ __("გატარებული ან") }}/{{ __("და მიმდინარე") }})</i>
        </td>
        <td colspan='3' class='text-success py-2'> {{ __("ნარჩენი რისკი") }}</td>
        <td rowspan='2' class='smaller'> {{ __("გასატარებელი ღონისძიებები") }}</td>
        <td rowspan='2'> {{ __("პასუხისმგებელი პირი") }}</td>
        <td rowspan='2'> {{ __("შესრ.ვადა") }}</td>
    </tr>
    <tr>
        <td class="px-3"> {{ __('ა') }}</td>
        <td class="px-3"> {{ __('შ') }}</td>
        <td class="smaller"> {{ __("რისკის დონე") }}</td>
        <td class="px-3"> {{ __('ა') }} </td>
        <td class="px-3"> {{ __('შ') }}</td>
        <td class="smaller"> {{ __("რისკის დონე") }}</td>
    </tr>
    <thead>

    <tbody>
    @for ($i = 0; $i < $countAll; $i++)
        <?php $dangerMax = $object->getDangerMax($i); ?>
        <tr>
            @if ($object->hasNewProcess($i))
                <td rowspan="{{ $object->getProcessMax($i) }}" class='smaller'>
                    {{ $object->getProcessName($i) }}
                </td>
            @endif
            @if ($object->hasNewDanger($i))
                <td rowspan="{{ $dangerMax }}" class='smaller'>
                    {{ $object->getDangerName($i) }}
                </td>
                <td rowspan="{{ $dangerMax }}"
                    class='position-relative @if (!$object->hasImage($i)) bg-purple @endif'
                    style='@if ($object->hasImage($i)) height:6rem; width:5rem; @endif'>
                    @if ($object->hasImage($i))
                        <img src="{{($object->getImageName($i))}}"
                             class='hoverable-image'
                             style=''/>
                    @endif
                </td>
                @foreach(['ploss', 'udanger'] as $type)
                    <td rowspan="{{ $dangerMax }}" class='smaller'>
                        <div class="my-2">
                            @foreach($object->getWholeElements($type, $i) as $value)
                                <p class=""> {{ $value }} </p>
                            @endforeach
                        </div>
                    </td>
                @endforeach
            @endif
            @if ($object->hasNewDanger($i))
                <td rowspan="{{ $dangerMax }}" class='smaller py-2'>
                    @foreach($object->getAllControls(0, $i) as $value)
                        <p class=""> {{ $value }} </p>
                    @endforeach
                </td>
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
                <td rowspan="{{ $dangerMax }}" style="background: {{ $color }};">
                    {{ $score }}
                </td>
            @endif
            <td class='smaller py-2'>
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
                <td rowspan="{{ $dangerMax }}" style="background: {{ $color }};">
                    {{ $score }}
                </td>
            @endif
            <td class="smaller py-2">
                {{ $object->getControl(2, $i) }}
            </td>
            @if ($object->hasNewDanger($i))
                @foreach(['rpersons', 'etimes'] as $type)
                    <td rowspan="{{ $dangerMax }}" class='small1 px-2'>
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
