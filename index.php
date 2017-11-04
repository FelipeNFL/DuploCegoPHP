<?php
    include 'database.php';
    include 'utils.php';

    $db = new Database();

    if($_POST['acao']){
        try {
            $db->deletePaciente($_POST['id']);
        }
        catch (Exception $e) {
            echo "<script>alert('".$e->getMessage()."')</script>";
        }
    }
 ?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/stylesheet.css">
        <title>Gerenciamento de pacientes</title>
    </head>
    <style>
      .botoesLista {
        float: left;
        margin-right: 5px;
        margin-left: 5px;
        margin-top: 0px;
        margin-bottom: 0px;
      }

      th, td{
        text-align: center;
      }
    </style>
    <body>
        <nav class="navbar navbar-inverse">
                <div class="container">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand">Pesquisa sobre fumo - sistema de randomização para teste duplo cego</a>
                  </div>
                  <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="cadastrar.php">Cadastrar pacientes</a></li>
                    </ul>
                  </div><!--/.nav-collapse -->
                </div>
              </nav>
        <div>
            <table class="table table-striped">
                <tr>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Sexo</th>
                    <th>Endereço</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Escolaridade</th>
                    <th>Tempo de fumo</th>
                    <th>Ação</th>
                </tr>
                <?php
                    $db = new Database();
                    $pacientes = $db->getPacientes();
                    foreach ($pacientes as $paciente){
                        echo '<tr>';
                        echo '<td> '.$paciente["nome"].' </td>';
                        echo '<td> '.(Utils::formatYear($paciente["idade"])).'</td>';
                        echo '<td> '.$paciente["sexo"].' </td>';
                        echo '<td> '.$paciente["endereco"].' </td>';
                        echo '<td> '.(Utils::formatCPF($paciente["cpf"])).' </td>';
                        echo '<td> '.(Utils::formatCellphone($paciente["telefone"])).' </td>';

                        foreach ($db->getEscolaridades() as $escolaridade) {
                            if($escolaridade["id"] == $paciente["escolaridade"])
                                echo '<td> '.$escolaridade["escolaridade"].' </td>';
                        }
                        echo '<td> '.(Utils::formatYear($paciente["tempoDeFumo"])).' </td>';
                        echo '<td>
                                <div class="botoesLista">
                                    <form action="alterar.php" method="POST" name="alteracao">
                                        <input type="hidden" name="id" value="'.$paciente["id"].'">
                                        <input type="submit" name="acaoIndex" value="Alterar" class="btn btn-sm btn-info">
                                    </form>
                                </div>
                                <div class="botoesLista">
                                    <form method="POST">
                                        <input type="hidden" name="id" value="'.$paciente["id"].'">
                                        <input type="submit" name="acao" value="Excluir" class="btn btn-sm btn-danger">
                                    </form>
                                </div>
                            </td>';
                        echo '</tr>';
                    }
                ?>
            </table>
        <div>
    </body>
</html>
