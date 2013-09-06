<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <!--title>Building blocks demo</title-->
        <!-- Building blocks -->
        <link rel="stylesheet" href="css/style/buttons.css">
        <link rel="stylesheet" href="css/style/headers.css">
        <link rel="stylesheet" href="css/style/input_areas.css">
        <link rel="stylesheet" href="css/style_unstable/lists.css">
        <link rel="stylesheet" href="css/style/action_menu.css">
        <link rel="stylesheet" href="css/style/confirm.css">
        <!--link rel="stylesheet" href="css/style/edit_mode.css"-->
        <!--link rel="stylesheet" href="css/style/status.css"-->
        <!--link rel="stylesheet" href="css/style/switches.css"-->
        <!--link rel="stylesheet" href="css/style_unstable/drawer.css"-->
        <!--link rel="stylesheet" href="css/style_unstable/progress_activity.css"-->
        <!--link rel="stylesheet" href="css/style_unstable/scrolling.css"-->
        <!--link rel="stylesheet" href="css/style_unstable/seekbars.css"-->
        <!--link rel="stylesheet" href="css/style_unstable/tabs.css"-->
        <!--link rel="stylesheet" href="css/style_unstable/toolbars.css"-->

        <!-- Icons -->
        <!--link rel="stylesheet" href="css/icons/styles/action_icons.css">
        <link rel="stylesheet" href="css/icons/styles/media_icons.css">
        <link rel="stylesheet" href="css/icons/styles/comms_icons.css">
        <link rel="stylesheet" href="css/icons/styles/settings_icons.css"-->

        <!-- Transitions -->
        <link rel="stylesheet" href="css/transitions.css">

        <!-- Util CSS: some extra tricks -->
        <link rel="stylesheet" href="css/util.css">
        <link rel="stylesheet" href="css/fonts.css">

        <!-- Additional markup to make Building Blocks kind of cross browser -->
        <link rel="stylesheet" href="css/cross_browser.css">
        <style>
        </style>
        <script type="text/javascript" src="js/jquery-2.0.3.js"></script>
        <script>
            $(document).ready(function(){   
                localStorage['btnMenu'] = '';
                function mostrar(section) {
                    $('section').fadeOut('fast');
                    $(section).fadeIn('fast');
                }
                $('.goto_ivss').click(function(){
                    mostrar('#inicio_ivss');
                });
                $('.goto_cne').click(function(){
                    mostrar('#inicio_cne');
                });
                $('.goto_seniat').click(function(){
                    mostrar('#inicio_seniat');
                });
                $('.goto_inicio').click(function(){
                    mostrar('#inicio');
                });
                $('.btnNac').click(function(){
                    localStorage['btnMenu'] = this.id;
                    if (this.id == "btnNacIVSS") {
                        $('#btnOptionNacT').css('display', 'block');
                    } else {
                        $('#btnOptionNacT').css('display', 'none');
                    }
                    $('#mnuNac').fadeIn('fast');
                });
                $('.btnSENIAT').click(function(){
                    $('#mnuSENIAT').fadeIn('fast');
                });
                $('.btnOptionNac').click(function(){
                    $('#' + localStorage['btnMenu']).attr('data-opt', $('#' + this.id).attr('data-opt'));
                    $('#' + localStorage['btnMenu']).text($('#' + this.id).text());
                    $('#mnuNac').fadeOut('fast');
                });
                $('.btnOptionSENIAT').click(function(){
                    $('#btnSENIAT').attr('data-opt', $('#' + this.id).attr('data-opt'));
                    $('#btnSENIAT').text($('#' + this.id).attr('data-opt'));
                    $('#mnuSENIAT').fadeOut('fast');
                });
                $('#btnCancelarNac').click(function(){
                    $('#mnuNac').fadeOut('fast');
                });
                $('#btnCancelarNacSENIAT').click(function(){
                    $('#mnuSENIAT').fadeOut('fast');
                });
                $('#btnBuscarIVSS').click(function(){
                    $('#loading-frame').fadeIn('fast');
                    var get = $.get(
                        "get_ivss.php", 
                        {nacionalidad: $('#btnNacIVSS').attr('data-opt'), cedula: $('#txtCedulaIVSS').val()},
                        function(r){
                            console.log(r);
                            if (r['error'] != 0) {
                                strHTML = '<li style="height:auto;">\n';
                                strHTML += '<p>Error</p>\n';
                                strHTML += '<p style="white-space:normal !important; color: #844">' + r['error'] + '</p>\n';
                                strHTML += '</li>\n';
                            } else {
                                strHTML = '<li>\n<p>Cédula</p>\n<p>' + r['cedula'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Nombre</p>\n<p>' + r['nombre'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Sexo</p>\n<p>' + r['sexo'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Fecha de Nacimiento</p>\n<p>' + r['fnac'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Número Patronal</p>\n<p>' + r['npat'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Nombre de la Empresa</p>\n<p>' + r['nemp'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Fecha de Ingreso</p>\n<p>' + r['fing'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Estatus del Asegurado</p>\n<p>' + r['estatus'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Fecha de Primera Afiliación</p>\n<p>' + r['afiliacion'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Fecha de Contingencia</p>\n<p>' + r['contingencia'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Total Semanas Cotizadas</p>\n<p>' + r['semanas'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Total Salarios Cotizados</p>\n<p>' + r['salarios'] + '</p>\n</li>\n'; // 
                            }
                            $('#lstResultIVSS').html(strHTML);
                            mostrar('#resultado_ivss');
                        }, 
                        'json'
                    );
                    get.fail(function(){
                        console.log("error");
                    });
                    get.always(function(){
                        $('#loading-frame').fadeOut('fast');
                    });
                });
                $('#btnBuscarCNE').click(function(){
                    $('#loading-frame').fadeIn('fast');
                    strHTML = '';
                    var get = $.get(
                        "get_cne.php", 
                        {nacionalidad: $('#btnNacCNE').attr('data-opt'), cedula: $('#txtCedulaCNE').val()},
                        function(r){
                            console.log(r);
                            if (r['error'] != 0) {
                                strHTML = '<li style="height:auto;">\n';
                                strHTML += '<p>Error</p>\n';
                                strHTML += '<p style="white-space:normal !important; color: #844">' + r['error'] + '</p>\n';
                                strHTML += '</li>\n';
                            } else {
                                if (r['modo'] == 1) {
                                    strHTML = '<li>\n<p>Cédula</p>\n<p>' + r['cedula'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li>\n<p>Nombre</p>\n<p>' + r['nombre'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li>\n<p>Estado</p>\n<p>' + r['estado'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li>\n<p>Municipio</p>\n<p>' + r['municipio'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li>\n<p>Parroquia</p>\n<p>' + r['parroquia'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li style="height:auto;">\n<p>Centro</p>\n<p style="white-space:normal !important;">' + r['centro'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li style="height:auto;">\n<p>Dirección</p>\n<p style="white-space:normal !important;">' + r['direccion'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li style="height:auto;">\n<p>Servicio Electoral</p>\n<p style="white-space:normal !important;">' + r['servicio'] + '</p>\n</li>\n'; // 
                                } else if (r['modo'] == 2) {
                                    strHTML = '<li>\n<p>Cédula</p>\n<p>' + r['cedula'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li>\n<p>Nombre</p>\n<p>' + r['nombre'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li style="height:auto;">\n<p>Estatus</p>\n<p style="white-space:normal">' + r['estatus'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li style="height:auto;">\n<p>Objeción</p>\n<p style="white-space:normal;">' + r['objecion'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li style="height:auto;">\n<p>Descripción</p>\n<p style="white-space:normal;">' + r['descripcion'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li style="height:auto;">\n<p>Institución</p>\n<p style="white-space:normal;">' + r['institucion'] + '</p>\n</li>\n'; // 
                                    strHTML += '<li style="height:auto;">\n<p>Requisitos</p>\n<p style="white-space:normal;">' + r['requisitos'] + '</p>\n</li>\n'; // 
                                }
                            }
                            $('#lstResultCNE').html(strHTML);
                            mostrar('#resultado_cne');
                        }, 
                        'json'
                    );
                    get.fail(function(){
                        console.log("error");
                    });
                    get.always(function(){
                        $('#loading-frame').fadeOut('fast');
                    });
                });
                $('#btnBuscarSENIAT').click(function(){
                    rif = (VerifRIF($('#txtCedulaSENIAT').val()) == true) ? $('#txtCedulaSENIAT').val() : genRIF('V' + $('#txtCedulaSENIAT').val());
                    if (rif == false) {
                        alert('El RIF escrito no es válido');
                        return;
                    }
                    console.log(rif);
                    $('#loading-frame').fadeIn('fast');
                    strHTML = '';
                    var get = $.get(
                        "get_seniat.php", 
                        {rif: rif},
                        function(r){
                            console.log(r);
                            $('#tituloSENIAT').text(r['rif']);
                            if (r['error'] != 0) {
                                strHTML = '<li style="height:auto;">\n';
                                strHTML += '<p>Error</p>\n';
                                strHTML += '<p style="white-space:normal !important; color: #844">' + r['error'] + '</p>\n';
                                strHTML += '</li>\n';
                            } else {
                                strHTML = '<li>\n<p>Razón Social o Nombre</p>\n<p>' + r['nombre'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Agente de Retención del IVA</p>\n<p>' + r['retencion'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Contribuyente Ordinario</p>\n<p>' + r['contribuyente'] + '</p>\n</li>\n'; // 
                                strHTML += '<li>\n<p>Tasa de Retención</p>\n<p>' + r['tasa'] + ' %</p>\n</li>\n'; // 
                            }
                            $('#lstResultSENIAT').html(strHTML);
                            mostrar('#resultado_seniat');
                        }, 
                        'json'
                    );
                    get.fail(function(){
                        console.log("error");
                    });
                    get.always(function(){
                        $('#loading-frame').fadeOut('fast');
                    });
                });
                function VerifRIF(RIF) {
                    var SumRIF;
                    var NumRif;
                    NumRif = RIF
                    var cadena = new Array();
                    if (NumRif.length == 10) {
                        for (i = 0; i < 10; i++) {
                            cadena[i] = NumRif.substr(i,1);
                        }
                        cadena[0] = 0;
                        if ((NumRif.substr(0,1) == "V")||(NumRif.substr(0,1) == "v")) cadena[0] = 1
                        if ((NumRif.substr(0,1) == "E")||(NumRif.substr(0,1) == "e")) cadena[0] = 2
                        if ((NumRif.substr(0,1) == "J")||(NumRif.substr(0,1) == "j")) cadena[0] = 3
                        if ((NumRif.substr(0,1) == "P")||(NumRif.substr(0,1) == "p")) cadena[0] = 4
                        if ((NumRif.substr(0,1) == "G")||(NumRif.substr(0,1) == "g")) cadena[0] = 5
                        cadena[0] = cadena[0] * 4
                        cadena[1] = cadena[1] * 3
                        cadena[2] = cadena[2] * 2
                        cadena[3] = cadena[3] * 7
                        cadena[4] = cadena[4] * 6
                        cadena[5] = cadena[5] * 5
                        cadena[6] = cadena[6] * 4
                        cadena[7] = cadena[7] * 3
                        cadena[8] = cadena[8] * 2
                        SumRIF = cadena[0] + cadena[1] + cadena[2] + cadena[3] +
                        cadena[4] + cadena[5] + cadena[6] + cadena[7] + cadena[8];
                        EntRIF = parseInt(SumRIF/11);
                        Residuo = SumRIF - (EntRIF * 11)
                        DigiVal = 11 - Residuo;
                        if (DigiVal > 9) DigiVal = 0;
                        if (DigiVal == cadena[9]) return true;
                        else return false;
                    }
                    else return false;
                }
                function genRIF(RIF) {
                    var SumRIF;
                    var NumRif;
                    NumRif = RIF
                    var cadena = new Array();
                    if (NumRif.length == 9) {
                        for (i = 0; i < 9; i++) {
                            cadena[i] = NumRif.substr(i,1);
                        }
                        cadena[0] = 0;
                        if ((NumRif.substr(0,1) == "V")||(NumRif.substr(0,1) == "v")) cadena[0] = 1
                        if ((NumRif.substr(0,1) == "E")||(NumRif.substr(0,1) == "e")) cadena[0] = 2
                        if ((NumRif.substr(0,1) == "J")||(NumRif.substr(0,1) == "j")) cadena[0] = 3
                        if ((NumRif.substr(0,1) == "P")||(NumRif.substr(0,1) == "p")) cadena[0] = 4
                        if ((NumRif.substr(0,1) == "G")||(NumRif.substr(0,1) == "g")) cadena[0] = 5
                        cadena[0] = cadena[0] * 4
                        cadena[1] = cadena[1] * 3
                        cadena[2] = cadena[2] * 2
                        cadena[3] = cadena[3] * 7
                        cadena[4] = cadena[4] * 6
                        cadena[5] = cadena[5] * 5
                        cadena[6] = cadena[6] * 4
                        cadena[7] = cadena[7] * 3
                        cadena[8] = cadena[8] * 2
                        SumRIF = cadena[0] + cadena[1] + cadena[2] + cadena[3] +
                        cadena[4] + cadena[5] + cadena[6] + cadena[7] + cadena[8];
                        EntRIF = parseInt(SumRIF/11);
                        Residuo = SumRIF - (EntRIF * 11)
                        DigiVal = 11 - Residuo;
                        if (DigiVal > 9) DigiVal = 0;
                        //if (DigiVal == cadena[9]) return true;
                        else return RIF + DigiVal;
                    }
                    else return false;
                }
            });
        </script>
        <style>
            .inicio {
                background-image: url(img/infove_mark.png), url(img/infove_min.png) !important;
                background-position: center bottom, left top !important;
                background-repeat: no-repeat, repeat !important;
            }
            .ivss {
                background-image: url(img/ivss_mark.png), url(img/ivss_min.jpg) !important;
                background-position: center bottom, left top !important;
                background-repeat: no-repeat, repeat !important;
            }
            .cne {
                background-image: url(img/cne_mark.png), url(img/cne_min.png) !important;
                background-position: center bottom, left top !important;
                background-repeat: no-repeat, repeat !important;
            }
            .seniat {
                background-image: url(img/seniat_mark.png), url(img/seniat_min.png) !important;
                background-position: center bottom, left top !important;
                background-repeat: no-repeat, repeat !important;
            }
            #loading-frame {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index:100;
                background-color: rgba(0,0,0,0.5);
                display: none;
            }
            #loading {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index:100;
                background: transparent url('img/loading.png') center no-repeat;
                animation: 0.9s rotate infinite steps(30);
            }
            @keyframes rotate {
                from { transform: rotate(1deg); }
                to   { transform: rotate(360deg); }
            }
            footer {
                position: absolute;
                left: 0;
                bottom: 0;
                width: 100%;
                z-index: 30;
            }
            footer p{
                margin: 0;
                padding: 0;
                font-size: 10px;
                text-align: center;
            }
            small { 
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        <!-- Ventana Principal -->
        <section role="region" class="skin-organic" id="inicio">
            <header class="fixed">
                <h1>InfoVE</h1>
            </header>
            <article class="content scrollable header inicio">
                <div data-type="list">
                    <ul id="lstMenu">
                        <li>
                            <a class="goto_ivss" href="#">
                                <aside class="pack-end"><img alt="photo" src="img/ivss.png"></aside>
                                <p>IVSS</p><p>Consulta del Seguro Social</p>
                            </a>
                        </li>
                        <li>
                            <a class="goto_cne" href="#">
                                <aside class="pack-end"><img alt="photo" src="img/cne.png"></aside>
                                <p>CNE</p><p>Consulta del Registro Electoral</p>
                            </a>
                        </li>
                        <li>
                            <a class="goto_seniat" href="#">
                                <aside class="pack-end"><img alt="photo" src="img/seniat.png"></aside>
                                <p>SENIAT</p><p>Consulta del RIF</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </article>
            <footer>
                <p>Copyleft &copy; William Cabrera<br />
                <a target="_blank" href="http://willicab.com.ve">http://willicab.com.ve</a></p>
            </footer>
        </section>
        <!-- Fin Ventana Principal -->
        <!-- Ventana IVSS -->
        <section role="region" class="skin-organic" id="inicio_ivss">
            <header class="fixed">
                <a class="go_back goto_inicio" href="#"><span class="icon icon-back">back</span></a>
                <h1>Seguro Social</h1>
            </header>
            <article class="content scrollable header ivss">
                <p>
                    <label for="btnNacIVSS">Nacionalidad</label>
                    <button class="btnNac" id="btnNacIVSS" name="btnNacIVSS" data-opt="V">Venezolano</button>
                </p>
                <p>
                    <label for="txtCedulaIVSS">Cédula</label>
                    <input type="number" id="txtCedulaIVSS" name="txtCedulaIVSS" size="10" maxlength="8" placeholder="Solo números (Ej: 95478251)"/>
                </p>
                <button id="btnBuscarIVSS">Buscar</button>
            </article>
        </section>
        <!-- Fin Ventana IVSS -->
        <!-- Ventana de resultado del IVSS -->
        <section role="region" class="skin-organic" id="resultado_ivss">
            <header class="fixed">
                <a class="goto_ivss" href="#"><span class="icon icon-back">back</span></a>
                <h1>Cuenta Individual</h1>
            </header>
            <article class="content scrollable header">
                <div data-type="list">
                    <ul id="lstResultIVSS">
                    </ul>
                </div>
            </article>
        </section>
        <!-- Fin Ventana de resultado del IVSS -->
        <!-- Ventana CNE -->
        <section role="region" class="skin-organic" id="inicio_cne">
            <header class="fixed">
                <a class="go_back goto_inicio" href="#"><span class="icon icon-back">back</span></a>
                <h1>Consejo nacional Electoral</h1>
            </header>
            <article class="content scrollable header cne">
                <p>
                    <label for="btnNacCNE">Nacionalidad</label>
                    <button class="btnNac" id="btnNacCNE" name="btnNacCNE" data-opt="V">Venezolano</button>
                </p>
                <p>
                    <label for="txtCedulaCNE">Cédula</label>
                    <input id="txtCedulaCNE" type="number" name="txtCedulaCNE" size="10" maxlength="8" placeholder="Solo números (Ej: 95478251)" />
                </p>
                <button id="btnBuscarCNE">Buscar</button>
            </article>
        </section>
        <!-- Fin Ventana CNE -->
        <!-- Ventana de resultado del CNE -->
        <section role="region" class="skin-organic" id="resultado_cne">
            <header class="fixed">
                <a class="goto_cne" class="go_back" href="#"><span class="icon icon-back">back</span></a>
                <h1>Cuenta Individual</h1>
            </header>
            <article class="content scrollable header">
                <div data-type="list">
                    <ul id="lstResultCNE">
                    </ul>
                </div>
            </article>
        </section>
        <!-- Fin Ventana de resultado del CNE -->
        <!-- Ventana SENIAT -->
        <section role="region" class="skin-organic" id="inicio_seniat">
            <header class="fixed">
                <a class="go_back goto_inicio" href="#"><span class="icon icon-back">back</span></a>
                <h1>SENIAT</h1>
            </header>
            <article class="content scrollable header seniat">
                <p>
                    <label for="txtCedulaSENIAT">Ingrese el RIF o la Cédula<sup>*</sup></label>
                    <input id="txtCedulaSENIAT" type="text" name="txtCedulaSENIAT" size="10" maxlength="10"  placeholder="Ej: V954782515 o 95478251"/>
                </p>
                <button id="btnBuscarSENIAT">Buscar</button>
                <p>
                    <small><sup>*</sup>Si su cédula es menor a 10 millones, debe anteponer un 0, si es menor a un millón debe anteponer dos 0</small>
                </p>
            </article>
        </section>
        <!-- Fin Ventana SENIAT -->
        <!-- Ventana de resultado del SENIAT -->
        <section role="region" class="skin-organic" id="resultado_seniat">
            <header class="fixed">
                <a class="goto_seniat" class="go_back" href="#"><span class="icon icon-back">back</span></a>
                <h1 id="tituloSENIAT">Seniat</h1>
            </header>
            <article class="content scrollable header">
                <div data-type="list">
                    <ul id="lstResultSENIAT">
                    </ul>
                </div>
            </article>
        </section>
        <!-- Fin Ventana de resultado del SENIAT -->
        <!-- Ventana Dialogo Nacionalidad -->
        <section id="mnuNac" data-position="back" class="fullscreen" style="display:none">
            <form role="dialog" data-type="action">
                <header>Nacionalidad</header>
                <menu>
                    <button id="btnOptionNacV" data-opt="V" class="btnOptionNac">Venezolano</button>
                    <button id="btnOptionNacE" data-opt="E" class="btnOptionNac">Extranjero</button>
                    <button id="btnOptionNacT" data-opt="T" class="btnOptionNac" style="display:none">Transeunte (5)</button>
                    <button id="btnCancelarNac">Cancelar</button>
                </menu>
            </form>
        </section>
        <!-- Fin Ventana Dialogo Nacionalidad -->
        <div id="loading-frame"><div id="loading"></div></div>
    </body>
</html>        
