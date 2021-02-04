


<table class="table" width="100%" style="margin-bottom: 40px">
    <tbody>
        <tr>
            <td class="font-weight-bold" colspan="2" width="80%" style="padding: 20px 0;">
                რისკების შეფასების დოკუმენტი
            </td>
            <td class="text-right font-weight-bold text-sm" style="background: #DEEBF7;">
                დოკუმენტის N:
            </td>
            <td class="text-sm px-3">
                {{ $docAbout['number'] }}
            </td>
        </tr>
        <tr style="background: #efeeee">
            <td width="20%" class="text-sm font-weight-bold" style="background: #DEEBF7; padding: 10px 0">
               შემფასებლის/ების სახელი და გვარი:
            </td>
            <td class="text-sm">
                {{ $docAbout['author-names'] }}
            </td>
            <td class="text-left text-sm font-weight-bold" style="background: #DEEBF7; padding: 10px 0">
                რისკების შეფასების თარიღი:
            </td>
            <td class="text-sm">
                {{ $docAbout['first_date'] }}
            </td>
        </tr>
        <tr style="background: #efeeee">
            <td class="text-sm font-weight-bold" style="background: #DEEBF7; padding: 10px 0">
                სამუშაო ობიექტის დასახელება და მისამართი:
            </td>
            <td class="text-sm">
                {{ $docAbout['address'] }}
            </td>
            <td class="text-left text-sm font-weight-bold" style="background: #DEEBF7; padding: 10px 0">
                დოკუმენტის გადახედვის სავარაუდო თარიღი:
            </td>
            <td class="text-sm">
                {{ $docAbout['second_date'] }}
            </td>
        </tr>
        <tr style="background: #efeeee">
            <td class="text-sm font-weight-bold" style="background: #DEEBF7; padding: 10px 0">
                სამუშაოს მოკლე აღწერა:
            </td>
            <td colspan="3" class="text-sm">
                {{ $docAbout['description'] }}
            </td>
        </tr>
    </tbody>
</table>
