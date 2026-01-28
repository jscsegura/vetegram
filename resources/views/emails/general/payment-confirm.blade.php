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
            <h1>Pago realizado</h1>
            <p>Hola <strong>{{ $name }}</strong></p>
            <p>Le escribimos para confirmar que su pago de la suscripción a Vetegram PRO ha sido recibido exitosamente. A partir de ahora, su suscripción continua activa y podrá disfrutar de todos los beneficios y características que ofrecemos.</p>
            
            <ul class="mt-3 px-0 mb-0">
                <li>Moneda: {{ $payment->currency }}</li>
                <li>Monto: {{ $payment->amount }}</li>
                <li>Autorización: {{ $payment->auth }}</li>
                <li>Expira: {{ $expire }}</li>
            </ul>
            
            <p>Si tiene alguna pregunta o necesita asistencia, no dude en ponerse en contacto con nuestro equipo de soporte a través del correo <a href="mailto:hola@vetegram.com"><strong>hola@vetegram.com</strong></a></p>
            
            <p>Atentamente<br>
            Equipo Vetegram.</p>
        </td>
    </tr>

</table>
<br>
<br>
<br>