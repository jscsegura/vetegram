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
            <h1>Formulario de contacto</h1>

            <p>Hemos recibido una solicitud de contacto, a continuación los datos recibidos:</p>
            
            <p>Nombre: {{ $contact->name }}<br>
            Correo: {{ $contact->email }}<br>
            Mensaje: {{ $contact->message }}</p>

            <p>Atentamente<br>
            Vetegram</p>
        </td>
    </tr>

</table>
<br>
<br>
<br>