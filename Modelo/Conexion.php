<?php
class Conexion{
    private $mySQLI;
    private $sql;
    private $result;
    private $filasAfectadas;
    private $id;
    public function abrir(){
        $this->mySQLI = new mysqli("localhost", "root", "", "tienda_tenis");
        if($this->mySQLI->connect_error){
                die("Fallo la conexion".$this->mySQLI->connect_error);
        }
        return $this->mySQLI;
    }
    public function cerrar(){
        $this->mySQLI->close();
    }
    public function consulta($sql){
        $this->sql = $sql;
        $this->result = $this->mySQLI->query($this->sql);
        $this->filasAfectadas = $this->mySQLI->affected_rows;
        $this->id = $this->mySQLI->insert_id;
        return $this->result;
    }
    public function obtenerResultado(){
        return $this->result;
    }
    public function obtenerUnaFila(){
        if($this->result){
            return $this->result->fetch_assoc();
        }
        return null;
    }
    public function obtenerFilasAfectadas(){
        return $this->filasAfectadas;
    }
    public function obtenerId(){
        return $this->id;
    }
    public function obtenerConexion(){
        return $this->mySQLI;
    }
}
?>