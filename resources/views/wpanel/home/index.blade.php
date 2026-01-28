@extends('layouts.wpanel')

@section('title', 'Panel de administración')

@section('content')
<div class="page-title">
    <h3>Panel de administración</h3>
</div>
<div id="container">
    <div class="row">
        <div class="col-md-12">
            En las diferentes áreas podrá añadir, editar y eliminar la información de las secciones del sitio web.
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="grid simple vertical green">
                <div class="grid-title no-border">
                    <h4><span class="semi-bold">Administraci&oacute;n de im&aacute;genes</span></h4>
                </div>
                <div class="grid-body no-border" style="padding-left: 15px; padding-right: 10px; text-align: justify;">
                    Para lograr la carga del sitio Web de manera optima, se recomienda que las imagénes estén optimizadas para Web en formato jpg. Se recomienda dar uso del formato png sólo cuando la imagen tiene colores planos y la misma no tenga más de 5.<br /><br />
                    Con la siguiente herramienta se pueden optimizar:<br />
                    <a href="https://squoosh.app/" target="_blank">https://squoosh.app</a><br /><br />
                    -Seleccionar en el método de comprensión: MozJPEG o Browser JPEG, a una calidad de 80.<br /><br />
                </div>
            </div> 
        </div>
        <div class="col-md-6">
            <div class="grid simple vertical green">
                <div class="grid-title no-border">
                    <h4><span class="semi-bold">Administraci&oacute;n de contenido</span></h4>
                </div>
                <div class="grid-body no-border" style="padding-left: 15px; padding-right: 10px; text-align: justify;">
                    Si pega contenido de Microsoft Word en los editores de texto, probablemente el contenido publicado no coincide con el estilo del sitio. Las fuentes pueden ser diferentes, las imágenes faltan y el formato no es el mismo que el del documento original. Esto se debe a que de manera oculta Word transmite estilos y etiquetas que afectan la visualización del contenido en el sitio Web.<br /><br />
                    Se recomienda pegar de Word a un editor de texto no formateado (Bloc de notas, Notepad, TextEdit, entre otros) para limpiar estilos extras, posteriormente pegar el texto en el editor de este panel administrador.<br /><br />
                </div>
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>
    </div>
</div>

@stop