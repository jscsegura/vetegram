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
            <h1>Suscripción a Vetegram PRO cancelada</h1>
            <p>Hemos recibido la solicitud de cancelar el plan PRO para la siguiente veterinaria.</p>
        </td>
    </tr>
    <tr>
        <td class="tdPad2">
            <table class="info">
                <tr>
                    <td style="width: 110px"><strong>Clinica:</strong></td>
                    <td>{{ $vet->company }}</td>
                </tr>
                <tr>
                    <td><strong>Id de usuario:</strong></td>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <td><strong>Nombre:</strong></td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td><strong>Correo:</strong></td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td><strong>Motivo:</strong></td>
                    <td>{{ $cancel->reason }}</td>
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