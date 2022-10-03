


<table class="table" width="100%" style="margin-bottom: 40px">
    <tbody>
        <tr>
            <td colspan="2" width="80%" style="padding: 20px 0;background: #f2fafd">
                <b style="font-size: 1rem"> {{ __("რისკების შეფასების დოკუმენტი") }} </b>
            </td>
            <td class="text-right font-weight-bold text-sm" style="background: #DEEBF7;">
              <b> {{ __("დოკუმენტის") }} N:</b>
            </td>
            <td class="text-sm px-3">
                {{ $docAbout['number'] }}
            </td>
        </tr>
        <tr style="background: #efeeee">
            <td width="20%" class="text-sm" style="background: #DEEBF7; padding: 10px 0">
              <b class="text-sm"> {{ __("შემფასებლის/ების სახელი და გვარი") }}:</b>
            </td>
            <td class="text-sm">
                {{ $docAbout['author-names'] }}
            </td>
            <td class="text-left text-sm font-weight-bold" style="background: #DEEBF7; padding: 10px 0">
                <b class="text-sm"> {{ __("რისკების შეფასების თარიღი") }}:</b>
            </td>
            <td class="text-sm">
                {{ $docAbout['first_date'] }}
            </td>
        </tr>
        <tr style="background: #efeeee">
            <td class="text-sm font-weight-bold" style="background: #DEEBF7; padding: 10px 0">
                <b class="text-sm"> {{ __("სამუშაო ობიექტის დასახელება და მისამართი") }}:</b>
            </td>
            <td class="text-sm">
                {{ $docAbout['address'] }}
            </td>
            <td class="text-left text-sm font-weight-bold" style="background: #DEEBF7; padding: 10px 0">
                <b class="text-sm"> {{ __("დოკუმენტის გადახედვის სავარაუდო თარიღი") }}:</b>
            </td>
            <td class="text-sm">
                {{ $docAbout['second_date'] }}
            </td>
        </tr>
        <tr style="background: #efeeee">
            <td class="text-sm font-weight-bold" style="background: #DEEBF7; padding: 10px 0">
                <b class="text-sm"> {{ __("სამუშაოს მოკლე აღწერა") }}: </b>
            </td>
            <td colspan="3" class="text-sm">
                {{ $docAbout['description'] }}
            </td>
        </tr>
    </tbody>
</table>
