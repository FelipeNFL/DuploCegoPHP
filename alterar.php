<?php
include 'database.php';
include 'paciente.php';

$db = new Database();

if($_POST['acaoLocal']){
    $paciente = new Paciente();
    $paciente->setId($_POST['id']);
    $paciente->setNome($_POST['nome']);
    $paciente->setIdade($_POST['idade']);
    $paciente->setSexo($_POST['sexo']);
    $paciente->setEndereco($_POST['endereco']);
    $paciente->setCpf($_POST['cpf']);
    $paciente->setTelefone($_POST['telefone']);
    $paciente->setEscolaridade($_POST['escolaridade']);
    $paciente->setTempoDeFumo($_POST['tempoDeFumo']);
    try {
        $db = new Database();
        $db->updatePaciente($paciente);
        echo "<script>alert('Paciente atualizado com sucesso!')</script>";
    }
    catch(Exception $e){
        echo "<script>alert('Erro ao alterar registro! $e')</script>";
    }
}

if(!$_POST['acaoIndex'])
    header("Location:index.php");
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/stylesheet.css">
        <title>Atualizar Paciente</title>
        <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script>
        <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript" /></script>
        <script type="text/javascript">
    			$(document).ready(function(){	$("#idade").mask("99");});
                $(document).ready(function(){	$("#cpf").mask("999.999.999-99");});
                $(document).ready(function(){	$("#telefone").mask("99999-9999");});
                $(document).ready(function(){	$("#tempoDeFumo").mask("99");});

        //Algoritmo retirado de: http://www.geradorcpf.com/javascript-validar-cpf.htm
          function TestaCPF(cpf) {
              cpf = cpf.replace(/[^\d]+/g,'');
              if(cpf == '') return false;
              // Elimina CPFs invalidos conhecidos
              if (cpf.length != 11 ||
                  cpf == "00000000000" ||
                  cpf == "11111111111" ||
                  cpf == "22222222222" ||
                  cpf == "33333333333" ||
                  cpf == "44444444444" ||
                  cpf == "55555555555" ||
                  cpf == "66666666666" ||
                  cpf == "77777777777" ||
                  cpf == "88888888888" ||
                  cpf == "99999999999")
                  return false;
                  // Valida 1o digito
                  add = 0;
                  for (i=0; i < 9; i ++)
                    add += parseInt(cpf.charAt(i)) * (10 - i);
                    rev = 11 - (add % 11);
                    if (rev == 10 || rev == 11)
                        rev = 0;
                    if (rev != parseInt(cpf.charAt(9)))
                        return false;
                    // Valida 2o digito
                    add = 0;
                    for (i = 0; i < 10; i ++)
                        add += parseInt(cpf.charAt(i)) * (11 - i);
                    rev = 11 - (add % 11);
                    if (rev == 10 || rev == 11)
                        rev = 0;
                    if (rev != parseInt(cpf.charAt(10)))
                        return false;
                    return true;
          }
          </script>
    </head>
    <body>
      <div id="alert"></div>
      <script>
          function Validar(){
            document.alteracao.nome.style = "";
            document.alteracao.idade.style = "";
            document.alteracao.sexo.style = "";
            document.alteracao.endereco.style = "";
            document.alteracao.cpf.style = "";
            document.alteracao.telefone.style = "";
            document.alteracao.tempoDeFumo.style = "";

            var div = document.getElementById("alert");
            var styleErrorTextBox = "box-shadow: 0px 0px 1em #CD5C5C; border-color: #a94442;";

            if(document.alteracao.nome.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O nome do paciente não pode ficar em branco.</div>';
                document.alteracao.nome.style = styleErrorTextBox;
                return false;
            }
            else if(document.alteracao.idade.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> A idade do paciente não pode ficar em branco.</div>';
                document.alteracao.idade.style = styleErrorTextBox;
                return false;
            }
            else if(document.alteracao.sexo.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O sexo do paciente não pode ficar em branco.</div>';
                return false;
            }
            else if(document.alteracao.endereco.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O endereço do paciente não pode ficar em branco.</div>';
                document.alteracao.endereco.style = styleErrorTextBox;
                return false;
            }
            else if(document.alteracao.cpf.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O CPF do paciente não pode ficar em branco.</div>';
                document.alteracao.cpf.style = styleErrorTextBox;
                return false;
            }
            else if(!TestaCPF(document.alteracao.cpf.value)){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O CPF digitado é inválido.</div>';
                document.alteracao.cpf.style = styleErrorTextBox;
                return false;
            }
            else if(document.alteracao.telefone.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O telefone do paciente não pode ficar em branco.</div>';
                document.alteracao.telefone.style = styleErrorTextBox;
                return false;
            }
            else if(document.alteracao.tempoDeFumo.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O tempo de fumo do paciente não pode ficar em branco.</div>';
                document.alteracao.tempoDeFumo.style = styleErrorTextBox;
                return false;
            }
            else if(document.alteracao.tempoDeFumo.value >= document.alteracao.idade.value){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O tempo de fumo do paciente não pode ser maior ou igual a sua idade.</div>';
                document.alteracao.tempoDeFumo.style = styleErrorTextBox;
                document.alteracao.idade.style = styleErrorTextBox;
                return false;
            }
            else {
                return true;
            }
        }
      </script>
      <nav class="navbar navbar-inverse">
              <div class="container">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="index.php">Pesquisa sobre fumo - sistema de randomização para teste duplo cego</a>
                </div>
                <div class="navbar-collapse collapse">
                  <ul class="nav navbar-nav">
                      <li class="active"><a href="cadastrar.php">Cadastrar pacientes</a></li>
                  </ul>
                </div><!--/.nav-collapse -->
              </div>
            </nav>
        <div>
            <form method="POST" name="alteracao" onsubmit="return Validar();">
                <?php
                $paciente = $db->getPaciente($_POST['id']);

                echo '<input type="hidden" name="id" value="'.($paciente->getId()).'">';
                echo '<label>Nome: </label><input type="text" name="nome" id="nome" value="'.$paciente->getNome().'" class="form-control"><br>';
                echo '<label>Idade: </label><input type="text" name="idade" id="idade" value="'.$paciente->getIdade().'" class="form-control"><br>';
                echo '<div class="form-group">';
                echo'<label>Sexo: </label><br>';
                echo '<div class="radio-inline"><label><input type="radio" name="sexo" value="Feminino" checked="'.($paciente->getSexo() == 'Masculino').'">Feminino</label></div>';
                echo '<div class="radio-inline"><label><input type="radio" name="sexo" value="Masculino" checked="'.($paciente->getSexo() == 'Feminino').'"><label>Masculino</label></div>';
                echo '</div>';
                echo '<label>Endereço: </label><input type="text" name="endereco" maxlength="45" value="'.$paciente->getEndereco().'" class="form-control"><br>';
                echo '<label>CPF: </label><input type="text" name="cpf" id="cpf" value="'.$paciente->getCpf().'" class="form-control"><br>';
                echo '<label>Telefone: </label><input type="text" name="telefone" id="telefone" value="'.($paciente->getTelefone()).'" class="form-control"><br>';
                echo '<label>Escolaridade: </label>';
                echo '<select name="escolaridade" class="form-control">';

                $escolaridades = $db->getEscolaridades();

                foreach ($escolaridades as $escolaridade){
                    if($paciente->getEscolaridade() == $escolaridade["id"]){
                        echo '<option value="'.$escolaridade["id"].'" selected>'.$escolaridade['escolaridade'].'</option>';
                    }
                    else {
                        echo '<option value="'.$escolaridade["id"].'">'.$escolaridade['escolaridade'].'</option>';
                    }
                }

                echo '</select><br>';
                echo '<label>Tempo de fumo: </label><input type="text" class="form-control" name="tempoDeFumo" id="tempoDeFumo" value="';
                if(strlen($paciente->getTempoDeFumo()) == 1)
                    echo str_pad($paciente->getTempoDeFumo(), 2, '0', STR_PAD_LEFT);
                else
                    echo $paciente->getTempoDeFumo();
                echo '"><br>';
                 ?>
                <input type="submit" value="Alterar" name="acaoLocal" class="btn btn-lg btn-primary">
            </form>
        </div>
    </body>
</html>
