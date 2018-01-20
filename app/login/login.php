<?php
require_once '../_inc/global.php';

$header = new GHeader('Login');
$header->show(false, 'login/login.php','', false);
// ---------------------------------- Header ---------------------------------//

$form = new GForm();

$htmlForm .= $form->open('form', 'form-vertical form');
$htmlForm .= $form->addInput('text', 'usu_var_email', 'Email*', array('maxlength' => '100', 'validate' => 'required;email'));
$htmlForm .= $form->addInput('password', 'usu_var_senha', 'Senha*', array('validate' => 'required'));
$htmlForm .= '<div class="form-actions">';
$htmlForm .= getBotaoLogin(true);
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

        var btn = document.getElementById('f__btn_cadastro');
        btn.addEventListener('click', function() {
            document.location.href = '<?php echo 'cadastro.php'; ?>';
        });

        $('#form').submit(function() {
            if ($('#form').gValidate()) {
                var method = 'POST';
                var endpoint = URL_API + 'usuario/login';
                $.gAjax.exec(method, endpoint, $('#form').serializeArray(), false, function(json) {
                    console.log(json.status);
                    if (json.status) {
                        document.location.href = '<?php echo 'logado.php'; ?>';
                    }
                });
            }
            return false;
        });
    });
</script>