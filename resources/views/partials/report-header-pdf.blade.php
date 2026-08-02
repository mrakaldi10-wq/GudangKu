<table style="width:100%">
    <tr>
        <td style="text-align: right; width: 100px;">
            @php
            $imageData = base64_encode(file_get_contents(public_path('img/logo.png')));
            @endphp
            <img width="100px" height="100px"
                src="data:image/png;base64, {{ $imageData }}"
                alt="Logo">
        </td>
        <td style="text-align: center; width: 200px;">
            <div style="font-size: 24px">PT. WINAKA MEDIKA INDOTAMA</div>
            <div style="font-size: 16px">Jl. Cabang 2 Ciomas Permai No 8, Sukamakmur, Ciomas, Kab. Bogor 16610</div>
            <div style="font-size: 16px">Email: ptwinakamedikaindotama@gmail.com</div>
            <div style="font-size: 16px">WA & Telp 08111040413</div>
        </td>
        <td style="text-align: right; width: 50px;">
        </td>
    </tr>
</table>
<div class="garis"></div>