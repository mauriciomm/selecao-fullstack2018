<?php
require_once '../_inc/global.php';

$form = new GForm();

$header = new GHeader('Vacinações');
$header->addLib(array('paginate', 'maskMoney'));
$header->show(false, 'aplicar_vacina/aplicar_vacina.php');
// ---------------------------------- Header ---------------------------------//


$html .= '<div id="divTable" class="row">';
$html .= getWidgetHeader();
//<editor-fold desc="Formulário de Filtro">
$html .= $form->open('filter', 'form-inline filterForm');
$html .= $form->addInput('text', 'p__ani_var_nome', false, array('placeholder' => 'Nome do Animal', 'class' => 'sepV_b m-wrap small'), false, false, false);

$html .= getBotoesFiltro();
$html .= getBotaoAdicionarProgramacaoVacina();
$html .= $form->close();
//</editor-fold>

$paginate = new GPaginate('animal_vacina', 'animal_vacina_load.php', SYS_PAGINACAO);
$html .= $paginate->get();
$html .= '</div>'; //divTable
$html .= getWidgetFooter();
echo $html;

echo '<div id="divForm" class="row divForm">';
include 'animal_vacina_form.php';
echo '</div>';

// ---------------------------------- Footer ---------------------------------//
$footer = new GFooter();
$footer->show();
?>
<script>
    var pagCrud = 'animal_vacina_crud.php';
    var pagView = 'animal_vacina_view.php';
    var pagLoad = 'animal_vacina_load.php';

    function filtrar(page) {
        animal_vacinaLoad('', '', '', $('#filter').serializeObject(), page);
        return false;
    }

    $(function() {
        var ani_int_codigo = $('#ani_int_codigo');
        var lbl_ani_int_codigo = $('#lbl_ani_int_codigo');
        var vac_int_codigo = $('#vac_int_codigo');
        var lbl_vac_int_codigo = $('#lbl_vac_int_codigo');
        var anv_dat_programacao = $('#anv_dat_programacao');
        var lbl_anv_dat_programacao = $('#lbl_anv_dat_programacao');
        var usu_int_codigo = $('#usu_int_codigo');
        var lbl_usu_int_codigo = $('#lbl_usu_int_codigo');
        
        filtrar(1);
        $('#filter select').change(function() {
            filtrar(1);
            return false;
        });
        $('#filter').submit(function() {
            if ($('#filter').attr('action').length === 0) {
                filtrar(1);
                return false;
            }
        });
        $('#p__btn_limpar').click(function() {
            clearForm('#filter');
            filtrar(1);
        });

        function configFormAdicionar() {
            ani_int_codigo.show();
            ani_int_codigo.attr('validate', 'required');
            lbl_ani_int_codigo.show();
            vac_int_codigo.show();            
            vac_int_codigo.attr('validate', 'required');
            lbl_vac_int_codigo.show();            
            anv_dat_programacao.show();
            anv_dat_programacao.attr('validate', 'required');
            lbl_anv_dat_programacao.show();
            
            usu_int_codigo.hide();
            usu_int_codigo.removeAttr('validate');
            lbl_usu_int_codigo.hide();
        }

        function configFormVacinar() {
            ani_int_codigo.hide();
            ani_int_codigo.removeAttr('validate');
            lbl_ani_int_codigo.hide();
            vac_int_codigo.hide();      
            vac_int_codigo.removeAttr('validate');      
            lbl_vac_int_codigo.hide();            
            anv_dat_programacao.hide();
            anv_dat_programacao.removeAttr('validate');
            lbl_anv_dat_programacao.hide();

            usu_int_codigo.show();
            usu_int_codigo.attr('validate', 'required');
            lbl_usu_int_codigo.show();
        }
        
        $(document).on('click', '#p__btn_adicionar', function() {
            scrollTop();
            unselectLines();

            showForm('divForm', 'ins', 'Adicionar');
            configFormAdicionar();
        });

        $(document).on('click', '.l__btn_editar', function() {            
            var anv_int_codigo = $(this).parents('tr.linhaRegistro').attr('id');
            
            scrollTop();
            selectLine(anv_int_codigo);
            
            loadForm(URL_API + 'animais_vacinas/' + anv_int_codigo, function(json) {
                showForm('divForm', 'upd', 'Editar');
            });
            configFormAdicionar();
        });

        $(document).on('click', '.l__btn_vacinar', function() {
            
            // configFormVacinar();

            var anv_int_codigo = $(this).parents('tr.linhaRegistro').attr('id');
            
            scrollTop();
            selectLine(anv_int_codigo);

            loadForm(URL_API + 'animais_vacinas/' + anv_int_codigo, function(json) {
                showForm('divForm', 'upd', 'Vacinar');
            });
            configFormVacinar();
        });

        $(document).on('click', '.l__btn_excluir', function() {
            var anv_int_codigo = $(this).parents('tr.linhaRegistro').attr('id');

            $.gDisplay.showYN("Quer realmente deletar o item selecionado?", function() {
                $.gAjax.exec('DELETE', URL_API + 'animais_vacinas/' + anv_int_codigo, false, false, function(json) {
                    if (json.status) {
                        filtrar();
                    }
                });
            });
        });
    });
</script>