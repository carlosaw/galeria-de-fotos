<?php
class Fotos extends model {

	public function saveFotos() {
		//print_r($_FILES);

		if(isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['tmp_name'])) {

			//Tipos de arquivos aceitos.
			$permitidos = array('image/jpeg', 'image/jpg', 'image/png');
			// Se for do tipo permitido...
			if(in_array($_FILES['arquivo'] ['type'], $permitidos)) {
				$nome = md5(time().rand(0, 999)).'.jpg';
				//Cria arquivo tempor�rio e envia para pasta..
				move_uploaded_file($_FILES['arquivo']['tmp_name'], 'assets/images/galeria/'.$nome);

				$titulo = '';
				if(isset($_POST['titulo']) && !empty($_POST['titulo'])) {
					$titulo = addslashes($_POST['titulo']);///cria nome do arquivo.
				}
				//Insere no Banco de Dados.
				$sql = "INSERT INTO fotos SET titulo = '$titulo', url = '$nome'";
				$this->db->query($sql);

				header("Location: index.php");//Anti f5	
			}
		}
	}
	//Mostra as fotos 
	public function getFotos() {
		$array = array();

		$sql = "SELECT * FROM fotos ORDER BY id DESC";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
	}
}