


<table class="table">
    <thead>
       <tr>
           <th></th>
           <th></th>
           <th></th>
           <th></th>
       </tr>
    </thead>
    <tbody>
        <tr>
            <td class="py-4 font-weight-bold" colspan="2" width="80%">
                რისკების შეფასების დოკუმენტი
            </td>
            <td class="text-right font-weight-bold text-sm" style="background: #DEEBF7">
                დოკუმენტის N:
            </td>
            <td class="text-sm px-3">
                {{ $docAbout['number'] }}
            </td>
        </tr>
        <tr style="background: #efeeee">
            <td width="20%" class="text-sm font-weight-bold" style="background: #DEEBF7">
               შემფასებლის/ების სახელი და გვარი:
            </td>
            <td class="text-sm">
                {{ $docAbout['author-names'] }}
            </td>
            <td class="text-left text-sm font-weight-bold" style="background: #DEEBF7">
                რისკების შეფასების თარიღი:
            </td>
            <td class="text-sm">
                {{ $docAbout['first_date'] }}
            </td>
        </tr>
        <tr style="background: #efeeee">
            <td class="text-sm font-weight-bold" style="background: #DEEBF7">
                სამუშაო ობიექტის დასახელება და მისამართი:
            </td>
            <td class="text-sm">
                {{ $docAbout['address'] }}
            </td>
            <td class="text-left text-sm font-weight-bold" style="background: #DEEBF7">
                დოკუმენტის გადახედვის სავარაუდო თარიღი:
            </td>
            <td class="text-sm">
                {{ $docAbout['second_date'] }}
            </td>
        </tr>
        <tr style="background: #efeeee">
            <td class="text-sm font-weight-bold" style="background: #DEEBF7">
                სამუშაოს მოკლე აღწერა:
            </td>
            <td colspan="3" class="text-sm">
                {{ $docAbout['description'] }}
            </td>
        </tr>
    </tbody>
</table>
