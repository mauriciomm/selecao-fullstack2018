<?php
require_once '../_inc/global.php';

$header = new GHeader('Cadastro');
$header->show(false, 'login/cadastro.php','', false);
// ---------------------------------- Header ---------------------------------//

$form = new GForm();

$htmlForm .= $form->open('form', 'form-vertical form');
$htmlForm .= $form->addInput('text', 'usu_var_nome', 'Nome*', array('maxlength' => '100', 'validate' => 'required'));
$htmlForm .= $form->addInput('text', 'usu_var_email', 'Email*', array('maxlength' => '100', 'validate' => 'required;email'));
$htmlForm .= $form->addInput('password', 'usu_var_senha', 'Senha*', array('validate' => 'required'));
$htmlForm .= $form->addInput('password', 'usu_var_senha_confirmacao', 'Confirmação de Senha*', array('validate' => 'required'));
$htmlForm .= '<div class="form-actions">';
$htmlForm .= getBotaoCadastrar(true);
$htmlForm .= '</div>';
$htmlForm .= $form->close();

echo $htmlForm;

// ---------------------------------- Footer ---------------------------------//
$footer = new GFooter();
$footer->show();
?>
<script>
    $(document).load(function () {
        $('#page-header-menu').hide();
    });

    $(function() {

        
        $(document).on('click', '.l__btn_editar, tr.linhaRegistro td:not([class~="acoes"])', function() {
            var usu_int_codigo = $(this).parents('tr.linhaRegistro').attr('id');

            scrollTop();
            selectLine(usu_int_codigo);

            loadForm(URL_API + 'usuarios/' + usu_int_codigo, function(json) {
                showForm('divForm', 'upd', 'Editar');
            });
        });
    });
</script>