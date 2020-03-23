
function fill_paciente(Id,Value) {
    $('#search-paciente').val(Value);
    $('#search-paciente-hidden').val(Id);
    $('#mostra-paciente').hide();
}

function fill_medico(Id, Value) {
    $('#search-medico').val(Value);
    $('#search-medico-hidden').val(Id);
    $('#mostra-medico').hide();
}
function fill_codigo_agendamento(Value) {
    $('#search-codigo_agendamento').val(Value);
    $('#mostra-codigo_agendamento').hide();
}
$(document).on('click',function(){
    $('#mostra-paciente').hide();
    $('#mostra-medico').hide();
    $('#mostra-codigo_agendamento').hide();
});

$(document).ready(function() {

    $("#search-paciente").keyup(function() {
        var nome = $('#search-paciente').val();
        if (nome == "") {
            $("#mostra-paciente").html("");
        }
        else {
            $.ajax({
                type: "POST",
                url: "index.php",
                data: {
                    classe: "Consulta",
                    metodo: "searchPaciente",
                    search_paciente: nome
                },
                success: function(html) {
                    $("#mostra-paciente").html(html).show();
                }
            });
        }
    });

    $("#search-medico").keyup(function() {
        var nome = $('#search-medico').val();
        if (nome == "") {
            $("#mostra-medico").html("");
        }
        else {
            $.ajax({
                type: "POST",
                url: "index.php",
                data: {
                    classe: "Consulta",
                    metodo: "searchMedico",
                    search_medico: nome
                },
                success: function(html) {
                    $("#mostra-medico").html(html).show();
                }
            });
        }
    });
    $("#search-codigo_agendamento").keyup(function() {
        var codigo = $('#search-codigo_agendamento').val();
        if (codigo == "") {
            $("#mostra-codigo_agendamento").html("");
        }
        else {
            $.ajax({
                type: "POST",
                url: "index.php",
                data: {
                    classe: "RegistroAtendimento",
                    metodo: "search",
                    search: codigo

                },
                success: function(html) {
                    $("#mostra-codigo_agendamento").html(html).show();
                }
            });
        }
    });
 });