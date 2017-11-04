<?php
include 'database.php';
include 'paciente.php';

$db = new Database();

if($_POST['btnLimpar']){
    header("Location:cadastrar.php");
}

if($_POST['btnEnviarArquivos']){

    $escolaridades = $db->getEscolaridades();

    foreach ($_FILES['arquivos']["tmp_name"] as $arquivo) {
        foreach (file($arquivo) as $linha) {

            $dadosPaciente = explode(", ",$linha);

            if(count($dadosPaciente) == 8){
                $paciente = new Paciente();
                $paciente->setNome($dadosPaciente[0]);
                $paciente->setIdade(str_replace(array(" ","anos"), "", $dadosPaciente[1]));
                $paciente->setSexo($dadosPaciente[2]);
                $paciente->setEndereco($dadosPaciente[3]);
                $paciente->setCpf(str_replace(array(".","-"), "", $dadosPaciente[4]));
                $paciente->setTelefone(str_replace("-","",$dadosPaciente[5]));

                foreach ($escolaridades as $escolaridade) {
                    if($escolaridade["escolaridade"] == $dadosPaciente[6])
                        $paciente->setEscolaridade($escolaridade["id"]);
                }

                $paciente->setTempoDeFumo(intval(str_replace(array("anos"), "", $dadosPaciente[7])));

                if($paciente->getEscolaridade() == ''){
                    $paciente->setEscolaridade(0);
                    echo '<div class="alert alert-warning" role="alert">
                          <strong>Atenção!</strong> A escolaridade do paciente '.$dadosPaciente[0].' não é válida! Ela foi definida automaticamente como <strong>Nenhuma</strong>.
                          </div>';
                }
                else if($paciente->getIdade() <= $paciente->getTempoDeFumo()){
                    echo '<div class="alert alert-danger" role="alert">
                          <strong>Erro!</strong> O paciente.'.$paciente->getNome().' não foi cadastrado pois o tempo de fumo é maior do que a idade
                          </div>';
                }
                else {
                    try {
                        $db->addPacienteByObject($paciente);
                        echo '<div class="alert alert-success" role="alert">
                              <strong>Concluído!</strong> O paciente '.$paciente->getNome().' foi cadastrado com sucesso!
                              </div>';
                    }
                    catch(Exception $e){
                        echo '<div class="alert alert-danger" role="alert">
                              <strong>Erro!</strong> Não foi possível cadastrar o paciente.'.$paciente->getNome().'. '.$e->getMessage().'
                              </div>';
                    }
                }
            }
            else {
                echo '<div class="alert alert-danger" role="alert">
                      <strong>Erro!</strong> O arquivo não possui um número de colunas adequado.
                      </div>';
                break;
            }
        }
    }
}


if($_POST['btnCadastrar']){
    $paciente = new Paciente();
    $paciente->setNome($_POST['nome']);
    $paciente->setIdade($_POST['idade']);
    $paciente->setSexo($_POST['sexo']);
    $paciente->setEndereco($_POST['endereco']);
    $paciente->setCpf(str_replace(array(".","-"), "", $_POST['cpf']));
    $paciente->setTelefone(str_replace("-","",$_POST['telefone']));
    $paciente->setEscolaridade($_POST['escolaridade']);
    $paciente->setTempoDeFumo($_POST['tempoDeFumo']);

    try {
        $db->addPacienteByObject($paciente);
        echo '<div class="alert alert-success" role="alert">
              <strong>Concluído!</strong> Paciente cadastrado com sucesso!
              </div>';
    }
    catch(Exception $e){
        echo '<div class="alert alert-danger" role="alert">
              <strong>Erro!</strong> Não foi possível cadastrar o paciente.'.$e->getMessage().'
              </div>';
    }
}
?>
<html>
    <head>
        <title>Cadastrar Novo Paciente</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/stylesheet.css">
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

            document.cadastro.nome.style = "";
            document.cadastro.idade.style = "";
            document.cadastro.sexo.style = "";
            document.cadastro.endereco.style = "";
            document.cadastro.cpf.style = "";
            document.cadastro.telefone.style = "";
            document.cadastro.tempoDeFumo.style = "";

            var div = document.getElementById("alert");
            var styleErrorTextBox = "box-shadow: 0px 0px 0.5em #CD5C5C; border-color: #a94442;";

            if(document.cadastro.nome.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O nome do paciente não pode ficar em branco.</div>';
                document.cadastro.nome.style = styleErrorTextBox;
                return false;
            }
            else if(document.cadastro.idade.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> A idade do paciente não pode ficar em branco.</div>';
                document.cadastro.idade.style = styleErrorTextBox;
                return false;
            }
            else if(document.cadastro.sexo.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O sexo do paciente não pode ficar em branco.</div>';
                return false;
            }
            else if(document.cadastro.endereco.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O endereço do paciente não pode ficar em branco.</div>';
                document.cadastro.endereco.style = styleErrorTextBox;
                return false;
            }
            else if(document.cadastro.cpf.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O CPF do paciente não pode ficar em branco.</div>';
                document.cadastro.cpf.style = styleErrorTextBox;
                return false;
            }
            else if(!TestaCPF(document.cadastro.cpf.value)){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O CPF digitado é inválido.</div>';
                document.cadastro.cpf.style = styleErrorTextBox;
                return false;
            }
            else if(document.cadastro.telefone.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O telefone do paciente não pode ficar em branco.</div>';
                document.cadastro.telefone.style = styleErrorTextBox;
                return false;
            }
            else if(document.cadastro.tempoDeFumo.value == ''){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O tempo de fumo do paciente não pode ficar em branco.</div>';
                document.cadastro.tempoDeFumo.style = styleErrorTextBox;
                return false;<input type="button" name="btnLimparArquivos" class="btn btn-lg btn-default" value="Limpar Arquivos">
            }
            else if(document.cadastro.tempoDeFumo.value >= document.cadastro.idade.value){
                div.innerHTML = '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> O tempo de fumo do paciente não pode ser maior ou igual a sua idade.</div>';
                document.cadastro.tempoDeFumo.style = styleErrorTextBox;
                document.cadastro.idade.style = styleErrorTextBox;
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
                <form method="POST" enctype="multipart/form-data" name="formUpload">
                    <div class="form-group">
                      <label>Escolha arquivos de texto para cadastrar: </label>
                      <input type="file" class="form-control-file" name="arquivos[]" accept=".txt" multiple>
                    </div>
                    <input type="submit" name="btnEnviarArquivos" value="Cadastrar Pacientes" class="btn btn-lg btn-primary">
                </form>
            </div>
        <div>
            <form method="POST" name="cadastro" onsubmit="return Validar();">
                <label>Nome: </label><input type="text" name="nome" id="nome" class="form-control"><br>
                <label>Idade: </label><input type="text" name="idade" id="idade" class="form-control"><br>
                <div class="form-group">
                  <label>Sexo: </label><br>
                  <div class="radio-inline"><label><input type="radio" name="sexo" value="Feminino"> Feminino</label></div>
                  <div class="radio-inline"><label><input type="radio" name="sexo" value="Masculino">Masculino</label></div><br>
                </div>
                <label>Endereço: </label><input type="text" name="endereco" maxlength="45" class="form-control"><br>
                <label>CPF: </label><input type="text" name="cpf" id="cpf" class="form-control"><br>
                <label>Telefone: </label><input type="text" name="telefone" id="telefone" class="form-control"><br>
                <label>Escolaridade: </label>
                    <select name="escolaridade" class="form-control">
                        <?php
                            $escolaridades = $db->getEscolaridades();
                            foreach ($escolaridades as $escolaridade)
                                echo '<option value='.$escolaridade["id"].'>'.$escolaridade['escolaridade']. '</option>';
                        ?>
                    </select><br>
                <label>Tempo de fumo: </label><input type="text" name="tempoDeFumo" id="tempoDeFumo" class="form-control"><br>
                <input type="submit" value="Cadastrar" name="btnCadastrar" class="btn btn-lg btn-primary">
                <input type="button" value="Limpar Formulário" name="btnLimpar" class="btn btn-lg btn-default">
            </form>
        </div>
    </body>
</html>
