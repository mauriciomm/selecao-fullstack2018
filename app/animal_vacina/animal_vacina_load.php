<?php

require_once("../_inc/global.php");

$html = '';
$mysql = new GDbMysql();
$form = new GForm();
//------------------------------ Parâmetros ----------------------------------//
$type = $_POST['type'];
$page = $_POST['page'];
$count = $_POST['count'];
$rp = (int) $_POST['rp'];
$start = (($page - 1) * $rp);
//------------------------------ Parâmetros ----------------------------------//
//-------------------------------- Filtros -----------------------------------//
$filter = new GFilter();

$ani_var_nome = $_POST['p__ani_var_nome'];

if (!empty($ani_var_nome)) {
    $filter->addFilter('AND', 'ani_var_nome', 'LIKE', 's', '%' . str_replace(' ', '%', $ani_var_nome) . '%');
}

//-------------------------------- Filtros -----------------------------------//

try {
    if ($type == 'C') {
        $query = "SELECT count(1) FROM vw_animal_vacina " . $filter->getWhere();
        $param = $filter->getParam();
        $mysql->execute($query, $param);
        if ($mysql->fetch()) {
            $count = ceil($mysql->res[0] / $rp);
        }
        $count = $count == 0 ? 1 : $count;
        echo json_encode(array('count' => $count));
    } else if ($type == 'R') {
        $filter->setOrder(array('ani_var_nome' => 'ASC'));
        $filter->setLimit($start, $rp);

        $query = "SELECT anv_int_codigo, ani_var_nome, vac_var_nome, anv_dtf_programacao, anv_dtf_aplicacao, usu_var_nome FROM vw_animal_vacina " . $filter->getWhere();
        $param = $filter->getParam();

        $mysql->execute($query, $param);

        if ($mysql->numRows() > 0) {
            $html .= '<table class="table table-striped table-hover">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th>Nome do Animal</th>';
            $html .= '<th>Vacina</th>';
            $html .= '<th>Data de Programação</th>';
            $html .= '<th>Data de Aplicação</th>';
            $html .= '<th>Usuário</th>';
            $html .= '<th class="__acenter hidden-phone" width="100px">Actions</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            while ($mysql->fetch()) {
                $class = ($_POST['p__selecionado'] == $mysql->res['anv_int_codigo']) ? 'success' : '';
                $html .= '<tr id="' . $mysql->res['anv_int_codigo'] . '" class="linhaRegistro ' . $class . '">';
                $html .= '<td>' . $mysql->res['ani_var_nome'] . '</td>';
                $html .= '<td>' . $mysql->res['vac_var_nome'] . '</td>';
                $html .= '<td>' . $mysql->res['anv_dtf_programacao'] . '</td>';
                $html .= '<td>' . $mysql->res['anv_dtf_aplicacao'] . '</td>';
                $html .= '<td>' . $mysql->res['usu_var_nome'] . '</td>';

                //<editor-fold desc="Actions">
                    $html .= '<td class="__acenter hidden-phone acoes" style="width:140px;">';
                    if ($mysql->res['usu_var_nome'] == null) {
                        $html .= $form->addButton('l__btn_vacinar', '<i class="fa fa-medkit"></i>', array('class' => 'btn btn-small btn-icon-only green l__btn_vacinar', 'title' => 'Vacinar'));
                        $html .= $form->addButton('l__btn_editar', '<i class="fa fa-pencil"></i>', array('class' => 'btn btn-small btn-icon-only l__btn_editar', 'title' => 'Editar'));
                    }
                    $html .= $form->addButton('l__btn_excluir', '<i class="fa fa-trash"></i>', array('class' => 'btn btn-small btn-icon-only l__btn_excluir', 'title' => 'Remove'));
                    $html .= '</td>';
                //</editor-fold>
                $html .= '</tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
        } else {
            $html .= '<div class="nenhumResultado">Nenhum resultado encontrado.</div>';
        }

        echo $html;
    }
} catch (GDbException $exc) {
    echo $exc->getError();
}
?>