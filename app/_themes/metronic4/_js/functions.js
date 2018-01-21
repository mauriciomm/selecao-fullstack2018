

$(function() {
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
});

/**
 *
 * @param {type} div
 * @param {type} acao
 * @param {type} acaoTitulo
 * @param {type} tab
 * @returns {undefined}
 */
function showForm(div, acao, acaoTitulo, tab) {
    $('#divTable').hide();
    $('.divForm').hide();
    $('#' + div).show();

    if (tab !== undefined)
        $('#' + div + ' a[href="#' + tab + '"]').tab('show');

    if (acao === 'ins') {
        $('#f__btn_excluir').hide();

        var filtro = $('#filter').serializeObject();

        $.each(filtro, function(k, v) {
            if (v.length > 0) {
                var i = k.replace('p__', '');
                $('#' + div + ' #' + i).val(v);
                $('#' + div + ' #' + i + '_group button[rel="' + v + '"]').trigger('click');
            }
        });

        $(':input:visible:enabled:not([readonly="readonly"]):first').focus();
    } else {
        $('#f__btn_excluir').show();
    }

    if (Object.keys($.uniform.elements).length > 0) {
        $.uniform.update('input:checkbox');
    }

    $('#' + div + ' .acao').val(acao);
    $('#' + div + ' .acaoTitulo').html(acaoTitulo);
}
function showList(reload) {
    scrollTop();
    $('.divForm').hide();
    $('#divTable').show();
    clearForm('.form');

    if (reload === true) {
        filtrar(1);
    }
}
function showView() {
    $('.divForm').hide();
    $('#divTable').hide();
    $('#divView').show();
}
/**
 * Carrega via ajax os dados e coloca no form
 *
 * @param string pag
 * @param array param
 * @param function callback
 */
function loadForm(pag, callback) {
    $.ajax({
        type: "GET",
        url: pag,
        dataType: 'json',
        async: false,
        beforeSend: function() {
            $.gDisplay.loadStart('html');
        },
        error: function(json) {
            var msg = (json.responseJSON.msg == undefined) ? "Error loading page..." : json.responseJSON.msg;
            $.gDisplay.loadError('html', msg);
        },
        success: function(json) {
            $.gDisplay.loadStop('html');
            if (json.status === undefined) {
                $.each(json, function(k, v) {
                    if (isNaN(k)) {
                        if (v !== null) {
                            $('#' + k).val(v);
                            $('#' + k + '_group button[rel="' + v + '"]').click();
                        }
                    }
                });
                $('.combobox').trigger("liszt:updated");
            } else {
                $.gDisplay.showError(json.msg);
            }

            if (typeof callback === 'function') {
                callback.call(this, json);
            }

            return true;
        }
    });
}
function loadView(pag, param, div) {
    $.ajax({
        type: "POST",
        url: pag,
        data: param,
        dataType: 'html',
        beforeSend: function() {
            $.gDisplay.loadStart('html');
        },
        error: function() {
            $.gDisplay.loadError('html', "Erro ao carregar a página...");
        },
        success: function(html) {
            $.gDisplay.loadStop('html');
            $(div).html(html);
        }
    });
}
function selectLine(codigo) {
    unselectLines();
    $('tr[id="' + codigo + '"]').addClass('selectedLine');
}
function unselectLines() {
    $('tr').removeClass('selectedLine');
}

function maskTel(obj) {
    $(obj).each(function() {
        var numero = $(this).val().replace(/\D/g, '');
        if (numero.length === 11) {
            $(this).mask('(99) 99999-9999');
        } else {
            $(this).mask('(99) 9999-9999?9');
        }
    });

    $(document).on('keyup', obj, function() {
        var val = $(this).val().replace(/\D/g, '');
        if (val.length === 11) {
            $(this).unmask();
            $(this).mask('(99) 99999-9999');
        } else if (val.length === 10) {
            $(this).unmask();
            $(this).mask('(99) 9999-9999?9');
        }
    });
}

function formataValor(valor) {
    if (valor !== null)
        return (valor.replace('.', ',')).replace(',00', '');
    else
        return valor;
}