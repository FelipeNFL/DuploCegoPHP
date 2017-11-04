<?php

Class Paciente {
	private $id;
	private $nome;
	private $idade;
	private $sexo;
	private $endereco;
	private $cpf;
	private $telefone;
	private $escolaridade;
	private $tempoDeFumo;

	public function getId(){
		return $this->id;
	}

	public function getNome(){
		return $this->nome;
	}

    public function getIdade()
    {
        return $this->idade;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getEscolaridade()
    {
        return $this->escolaridade;
    }

    public function getTempoDeFumo()
    {
        return $this->tempoDeFumo;
    }

	public function setId($id){
		if(intval($id))
			$this->id = $id;
		else
			throw new Exception("O valor do ID precisa ser numérico e não nulo!");
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

    public function setIdade($idade)
    {
		if(intval($idade))
			$this->idade = $idade;
		else
			throw new Exception("O valor da idade precisa ser numérico e não nulo!");
    }

    public function setSexo($sexo)
    {
		if($sexo == "Masculino" or $sexo == "Feminino")
        	$this->sexo = $sexo;
		else
			throw new Exception("O sexo precisa ser masculino ou feminino!");
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    public function setCpf($cpf)
    {
		if(intval(str_replace(array(".","-"), "", $cpf)) and strlen(str_replace(array(".","-"), "", $cpf)) == 11)
			$this->cpf = str_replace(array(".","-"), "", $cpf);
		else
			throw new Exception("O CPF é inválido!");
    }

    public function setTelefone($telefone)
    {
		if(intval(str_replace("-","",$telefone)))
			$this->telefone = str_replace("-","",$telefone);
		else
			throw new Exception("O telefone é inválido");
    }

    public function setEscolaridade($escolaridade)
    {
        $this->escolaridade = $escolaridade;
    }

    public function setTempoDeFumo($tempoDeFumo)
    {
		if(intval($tempoDeFumo))
			$this->tempoDeFumo = $tempoDeFumo;
		else
			throw new Exception("O tempo de fumo precisa ser numérico e não nulo!");
    }
}
