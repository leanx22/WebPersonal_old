"use strict";
$(() => {
    $('#btnGit').on('click', (e) => {
        e.preventDefault();
        abrirGitHub();
    });
    $('#btnLinkedIn').on('click', (e) => {
        e.preventDefault();
        abrirLinkedIn();
    });
    $('#btnCV').on('click', (e) => {
        e.preventDefault();
        abrirCV();
    });
    $.ajax({
        type: 'POST',
        url: URL_PAGINA + "estadisticas/general",
        dataType: "json",
        async: true,
    }).fail(() => {
        console.warn("Error al intentar modificar estadistica de vista general.");
    });
});
function abrirGitHub() {
    window.open('https://github.com/leanx22', '_blank');
    $.ajax({
        type: 'POST',
        url: URL_PAGINA + "estadisticas/github",
        dataType: "json",
        async: true,
    }).fail(() => {
        console.warn("Error al intentar modificar estadistica de vista en gitHub.");
    });
}
;
function abrirLinkedIn() {
    window.open('https://www.linkedin.com/in/leandro-guia-dev/', '_blank');
    $.ajax({
        type: 'POST',
        url: URL_PAGINA + "estadisticas/linkedin",
        dataType: "json",
        async: true,
    }).fail(() => {
        console.warn("Error al intentar modificar estadistica de vista en linkedin.");
    });
}
;
function abrirCV() {
    window.open(URL_PAGINA + 'files/CV_Leandro_Guia.pdf', '_blank');
    $.ajax({
        type: 'POST',
        url: URL_PAGINA + "estadisticas/cv",
        dataType: "json",
        async: true,
    }).fail(() => {
        console.warn("Error al intentar modificar estadistica de vista de CV.");
    });
}
;
//# sourceMappingURL=home.js.map