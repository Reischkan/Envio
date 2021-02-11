<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class APIController extends ResourceController{
    protected $modelName = 'App\Models\avionesModelo';
    protected $format    = 'json';

    public function index(){
        
        return $this->respond($this->model->findAll());
    }

    
    public function registraravion(){

        //1.Recibir los datos del conductor desde el cliente
        $id=$this->request->getPost('id');
        $nombre=$this->request->getPost('nombre');
        $codigo=$this->request->getPost('codigo');
        $idvuelo=$this->request->getPost('idvuelo');

        //2. Armar un arreglos asociativo donde las claves
        //seran los nombres de las columnas o atributos de la tabla con los datos que llegan de la peticion

        $datosEnvio=array(
            "id"=>$id,
            "nombre"=>$nombre,
            "codigo"=>$codigo,
            "idvuelo"=>$idvuelo
        );

        //3. Ejecutamos validacion y agregamos el registro
        if($this->validate('aviones')){
            
            $this->model->insert($datosEnvio);
            $mensaje=array('estado'=>true,'mensaje'=>"registro agregado con exito");
            return $this->respond($mensaje);

        }else{
            $validation =  \Config\Services::validation();
            return $this->respond($validation->getErrors(),400);

        }


    }

    public function editaravion($id){

        //1. Recibir los datos que llegan de la peticion
        $datosPeticion=$this->request->getRawInput();
        
        //2. Obtener SOLO los datos que deseo editar
        $nombre=$datosPeticion["nombre"];
        $telefono=$datosPeticion["codigo"];

        //3. Creamos un arreglo asociativo con los datos para enviar al modelo
        $datosEnvio=array(
            "nombre"=>$nombre,
            "codigo"=>$codigo
        );

        //4. Validamos y ejecutamos la operación en BD
        if($this->validate('avionesPUT')){
            
            $this->model->update($id,$datosEnvio);
            $mensaje=array('estado'=>true,'mensaje'=>"registro editado con exito");
            return $this->respond($mensaje);

        }else{
            $validation =  \Config\Services::validation();
            return $this->respond($validation->getErrors(),400);

        }


        




    }

    public function eliminaravion($id){

        //1. Ejecutar la operación de delete en BD
        $consulta=$this->model->where('id',$id)->delete();
        $filasAfectadas=$consulta->connID->affected_rows;

        //2. Validar si el registro a eliminar existe o no
        if($filasAfectadas==1){

            $mensaje=array('estado'=>true,'mensaje'=>"registro eliminado con exito");
            return $this->respond($mensaje);

        }else{
            $mensaje=array('estado'=>false,'mensaje'=>"El conductor a eliminar no se encontro en BD");
            return $this->respond($mensaje,400);
        }
        

    }


}

