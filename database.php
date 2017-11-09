<?php
Class Database {

    private $conexao;

    public function __construct(){
        $this->conexao = new mysqli('localhost','user','password','db');
        // Verifica se ocorreu algum erro
        if (mysqli_connect_errno()) {
            die('Não foi possível conectar-se ao banco de dados: ' . mysqli_connect_error());
            exit();
        }
    }

    public function randomizarPacientes(){
        $pacientes = $this->conexao->query("SELECT * FROM pacientes");

        if($pacientes->num_rows % 2 == 0){
            $tamanhoGrupoControle = $pacientes->num_rows / 2;
            $tamanhoGrupoIntervencao = $pacientes->num_rows / 2;
        }
        else {
            if(mt_rand(1,2) == 2){
                $tamanhoGrupoIntervencao = intval($pacientes->num_rows / 2);
                $tamanhoGrupoControle = $pacientes->num_rows - $tamanhoGrupoIntervencao;
            }
            else {
                $tamanhoGrupoControle = intval($pacientes->num_rows / 2);
                $tamanhoGrupoIntervencao = $pacientes->num_rows - $tamanhoGrupoControle;
            }
        }

        $arrayDePacientes = array();
        $grupoControle = array();
        $grupoIntervencao = array();

        foreach ($pacientes as $paciente) {
            $arrayDePacientes[] = $paciente;
        }

        for ($i=0; $i < $tamanhoGrupoControle; $i++) {
            do {
                $idPaciente = mt_rand(0,count($arrayDePacientes) - 1);
            } while ($grupoControle[array_search($idPaciente,$grupoControle)] == $idPaciente);

            $grupoControle[] = $idPaciente;
        }

        for ($i=0; $i < $tamanhoGrupoIntervencao; $i++) {
            do {
                $idPaciente = mt_rand(0,count($arrayDePacientes) - 1);
            } while($grupoControle[array_search($idPaciente,$grupoControle)] == $idPaciente || $grupoIntervencao[array_search($idPaciente,$grupoIntervencao)] == $idPaciente);

            $grupoIntervencao[] = $idPaciente;
        }

        if(!$this->conexao->query("DELETE FROM grupoPaciente"))
            throw new Exception("Não foi possível resetar a tabela que relaciona o grupo aos pacientes");

        foreach ($grupoControle as $id) {
            if(!$this->conexao->query("INSERT INTO grupoPaciente (idPaciente,idGrupo) VALUES ($id,0);"))
                throw new Exception("Não foi possível registrar a randomização do paciente ".$arrayDePacientes[$id]->getNome());
        }

        foreach ($grupoIntervencao as $id) {
            if(!$this->conexao->query("INSERT INTO grupoPaciente (idPaciente,idGrupo) VALUES ($id,1);"))
                throw new Exception("Não foi possível registrar a randomização do paciente ".$arrayDePacientes[$id]->getNome());
        }
    }

    public function addPacienteByObject($paciente){
        $query = "INSERT INTO pacientes (
            nome,
            idade,
            sexo,
            endereco,
            cpf,
            telefone,
            escolaridade,
            tempoDeFumo
        ) VALUES (
            '".$paciente->getNome()."',
            ".$paciente->getIdade().",
            '".$paciente->getSexo()."',
            '".$paciente->getEndereco()."',
            '".$paciente->getCpf()."',
            '".$paciente->getTelefone()."',
            ".$paciente->getEscolaridade().",
            ".$paciente->getTempoDeFumo()."
        )";

        if(!$this->conexao->query($query))
            throw new Exception("O paciente não foi cadastrado! Nenhum comando foi realizado.");

        $this->randomizarPacientes();
    }

    public function updatePaciente($paciente){
        $query = "UPDATE pacientes SET
            nome = '".$paciente->getNome()."',
            idade = ".$paciente->getIdade().",
            sexo = '".$paciente->getSexo()."',
            endereco = '".$paciente->getEndereco()."',
            cpf = '".$paciente->getCpf()."',
            telefone = '".$paciente->getTelefone()."',
            escolaridade = ".$paciente->getEscolaridade().",
            tempoDeFumo = ".$paciente->getTempoDeFumo()."
        WHERE
        id = ".$paciente->getId();

        if(!$this->conexao->query($query))
            throw new Exception("O paciente não foi atualizado! Nenhum comando foi realizado.");
    }

    public function getPacientes(){
        return $this->conexao->query("SELECT * FROM pacientes");
    }

    public function getPaciente($id){
        $rows = $this->conexao->query("SELECT * FROM pacientes WHERE id = ".$id);
        foreach ($rows as $result) {
            $paciente = new Paciente();
            $paciente->setId($result["id"]);
            $paciente->setNome($result["nome"]);
            $paciente->setIdade($result["idade"]);
            $paciente->setSexo($result["sexo"]);
            $paciente->setEndereco($result["endereco"]);
            $paciente->setEscolaridade($result["escolaridade"]);
            $paciente->setCpf($result["cpf"]);
            $paciente->setTelefone($result["telefone"]);
            $paciente->setTempoDeFumo($result["tempoDeFumo"]);
        }
        return $paciente;
    }

    public function getPacienteByCpf($cpf){
        $query = "SELECT * FROM pacientes WHERE cpf = '".$cpf. "'";
        echo '<script>alert('.$query.')</script>';
        $rows = $this->conexao->query($query);
        foreach ($rows as $result) {
            $paciente = new Paciente();
            $paciente->setId($result["id"]);
            $paciente->setNome($result["nome"]);
            $paciente->setIdade($result["idade"]);
            $paciente->setSexo($result["sexo"]);
            $paciente->setEndereco($result["endereco"]);
            $paciente->setEscolaridade($result["escolaridade"]);
            $paciente->setCpf($result["cpf"]);
            $paciente->setTelefone($result["telefone"]);
            $paciente->setTempoDeFumo($result["tempoDeFumo"]);
        }
        return $paciente;
    }

    public function deletePaciente($id){
        if(!$this->conexao->query("DELETE FROM pacientes WHERE id = ".$id))
            throw new Exception("Não foi possível excluir o registro");
    }

    public function getEscolaridades(){
        return $this->conexao->query("SELECT * FROM escolaridade");
    }
}
