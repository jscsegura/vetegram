<br>
<br>
<br>
<table class="email-container" cellspacing="0" cellpadding="0">
    <tr>
        <td class="header">
            <img src="{{ config('app.url') }}/img/logo.png" alt="Vetegram" class="logo">
        </td>
    </tr>
    <tr>
        <td class="tdPad">
            <h1>Solicitud de plan PRO</h1>
            <p>Hemos recibido la solicitud de adquirir un plan PRO para la siguiente veterinaria.</p>
        </td>
    </tr>
    <tr>
        <td class="tdPad2">
            <table class="info">
                <tr>
                    <td style="width: 110px"><strong>Clinica:</strong></td>
                    <td>{{ $clinic }}</td>
                </tr>
                <tr>
                    <td><strong>Id de usuario:</strong></td>
                    <td>{{ $adminid }}</td>
                </tr>
                <tr>
                    <td><strong>Nombre:</strong></td>
                    <td>{{ $admin }}</td>
                </tr>
                <tr>
                    <td><strong>Correo:</strong></td>
                    <td>{{ $email }}</td>
                </tr>
                <tr>
                    <td><strong>Solicitado por:</strong></td>
                    <td>{{ $createBy }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="tdPad2">
            <p>Atentamente</p>
            <p>Equipo de Vetegram.</p>
        </td>
    </tr>
</table>
<br>
<br>
<br>