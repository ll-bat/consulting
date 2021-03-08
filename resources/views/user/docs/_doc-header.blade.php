


<table width="100%" style="margin-bottom: 40px;">
    <tbody>
    <tr>
        <td height="22" colspan="15"></td>
    </tr>
    <tr>
        <td width='5' height='30'></td>
        <td class="font-weight-bold"
            align='center'
            colspan="12"
            height="30"
            style="padding: 20px 0;
            background-color:#EAECEB;
            border:7px solid #b8b894">
           <b> რისკების შეფასების დოკუმენტი </b>
        </td>
        <td class="text-right font-weight-bold text-sm" align="right" colspan="3" height="30"  style="background: #DEEBF7; border:7px solid #b8b894">
           <b> დოკუმენტის N: </b>
        </td>
        <td class="text-sm px-3" colspan="1" height="30" style="border:7px solid #b8b894">
            {{ $docAbout['number'] }}
        </td>
    </tr>
    <tr style="background: #efeeee">
        <td width='5' height='22'></td>
        <td width="20%" class="text-sm font-weight-bold" colspan="2" style="background: #DEEBF7; padding: 10px 0; border:7px solid #b8b894">
            <b>  შემფასებლის/ების სახელი და გვარი: </b>
        </td>
        <td class="text-sm" colspan="10" align="center" style="background: #f4f8f8; border:7px solid #b8b894">
            {{ $docAbout['author-names'] }}
        </td>
        <td class="text-left text-sm font-weight-bold" colspan="3" style="background: #deebf7; padding: 10px 0">
            <b> რისკების შეფასების თარიღი: </b>
        </td>
        <td class="text-sm" colspan="1" align="right" style="border:7px solid #b8b894">
            {{ $docAbout['first_date'] }}
        </td>
    </tr>
    <tr style="background: #efeeee">
        <td width='5' height='22'></td>
        <td class="text-sm font-weight-bold" colspan="2" style="background: #DEEBF7; padding: 10px 0; border:7px solid #b8b894">
            <b> სამუშაო ობიექტის დასახელება და მისამართი: </b>
        </td>
        <td class="text-sm" colspan="10" align="center" style="background: #f4f8f8; border:7px solid #b8b894">
            {{ $docAbout['address'] }}
        </td>
        <td class="text-left text-sm font-weight-bold" colspan="3" style="background: #DEEBF7; padding: 10px 0; border:7px solid #b8b894">
            <b> დოკუმენტის გადახედვის სავარაუდო თარიღი: </b>
        </td>
        <td class="text-sm" colspan="1" align="right" style="border:7px solid #b8b894">
            {{ $docAbout['second_date'] }}
        </td>
    </tr>
    <tr style="background: #efeeee">
        <td width='5' height='22'></td>
        <td class="text-sm font-weight-bold" colspan="2" style="background: #DEEBF7; padding: 10px 0; border:7px solid #b8b894">
            <b> სამუშაოს მოკლე აღწერა: </b>
        </td>
        <td class="text-sm" colspan="14" align="center" height="40" style="background: #f4f8f8; border:7px solid #b8b894">
            {{ $docAbout['description'] }}
        </td>
    </tr>
    </tbody>
</table>
