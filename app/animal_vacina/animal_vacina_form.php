<?php
$form = new GForm();

//<editor-fold desc="Header">
$title = '<span class="acaoTitulo"></span>';
$tools = '<a id="f__btn_voltar"><i class="fa fa-arrow-left font-blue-steel"></i> <span class="hidden-phone font-blue-steel bold uppercase">Voltar</span></a>';
$htmlForm .= getWidgetHeader($title, $tools);
//</editor-fold>
//<editor-fold desc="Formulário">
$htmlForm .= $form->open('form', 'form-vertical form');
$htmlForm .= $form->addInput('hidden', 'acao', false, array('value' => 'ins', 'class' => 'acao'), false, false, false);
$htmlForm .= $form->addInput('hidden', 'anv_int_codigo', false, array('value' => ''), false, false, false);

$array_animal = [];
$array_vacina = [];
$array_usuario = [];

try {
    // Buscas de animais e vacinas para preenchimento do comboBox na tela
    $mysql = new GDbMysql();
    
    $query = "SELECT ani_int_codigo, ani_var_nome FROM vw_animal order by ani_var_nome";
    $array_animal = $mysql->executeCombo($query);

    $query = "SELECT vac_int_codigo, vac_var_nome FROM vw_vacina order by vac_var_nome";
    $array_vacina = $mysql->executeCombo($query);

    $query = "SELECT usu_int_codigo, usu_var_nome FROM vw_usuario order by usu_var_nome";
    $array_usuario = $mysql->executeCombo($query);

} catch (GDbException $exc) {
    echo $exc->getError();
}

$htmlForm .= $form->addSelect('ani_int_codigo', $array_animal, '', 'Animal*', array(), false, false, true, '', 'Selecione...');
$htmlForm .= $form->addSelect('vac_int_codigo', $array_vacina, '', 'Vacina*', array(), false, false, true, '', 'Selecione...');

$htmlForm .= $form->addInput('date', 'anv_dat_programacao', 'Data de Programação*', array('maxlength' => '10'));

$htmlForm .= $form->addSelect('usu_int_codigo', $array_usuario, '', 'Usuário*', array(), false, false, true, '', 'Selecione...');

$htmlForm .= '<div class="form-actions">';
$htmlForm .= getBotoesAcao(true);
$htmlForm .= '</div>';
$htmlForm .= $form->close();
//</editor-fold>
$htmlForm .= getWidgetFooter();

echo $htmlForm;
?>
<script>
    $(function() {

        $('#form').submit(function() {
            var anv_int_codigo = $('#anv_int_codigo').val();
            $('#p__selecionado').val();
            if ($('#form').gValidate()) {
                var method = ($('#acao').val() == 'ins') ? 'POST' : 'PUT';
                
                var usu_int_codigo = $('#usu_int_codigo_text').val();
                console.log(usu_int_codigo);
                if ($('#acao').val() == 'ins') {
                    var endpoint = URL_API + 'animais_vacinas';
                }
                else {
                    var endpoint = URL_API + 'animais_vacinas/' + anv_int_codigo;
                    if (usu_int_codigo) endpoint += '/vacinar'
                }
                console.log(endpoint);
                $.gAjax.exec(method, endpoint, $('#form').serializeArray(), false, function(json) {
                    if (json.status) {
                        showList(true);
                    }
                });
            }
            return false;
        });

        $('#f__btn_cancelar, #f__btn_voltar').click(function() {
            showList();
            return false;
        });

        $('#f__btn_excluir').click(function() {
            var anv_int_codigo = $('#anv_int_codigo').val();

            $.gDisplay.showYN("Quer realmente deletar o item selecionado?", function() {
                $.gAjax.exec('DELETE', URL_API + 'animais_vacinas/' + anv_int_codigo, false, false, function(json) {
                    if (json.status) {
                        showList(true);
                    }
                });
            });
        });
    });
</script>