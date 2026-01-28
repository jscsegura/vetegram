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
            <h1>Resetear su contraseña de acceso</h1>
            <p>Hola <strong>{{ $name }}</strong></p>
            <p>Hemos recibido una solicitud para resetear su contraseña de acceso, a continuación le brindamos su nueva contraseña de ingreso al sistema.</p>
            <p>Contraseña: {{ $token }}</p>
            <p>Recuerde mantener la privacidad de su contraseña.</p>

            <p>&nbsp;</p>
            <p>Atentamente,</p>
            <p>Equipo Vetegram.</p>
        </td>
    </tr>

</table>
<br>
<br>
<br>