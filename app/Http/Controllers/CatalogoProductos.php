<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CatalogoProducto;
use Carbon\Carbon;
use App\Events\Actualizacion;

 
class CatalogoProductos extends Controller
{
    public function store(Request $request){

      if ($request->type == "import") {

         $productos = $request->data;
         $CatalogoProducto = new CatalogoProducto();
         $correctos=0;
         $incorrectos=0;
         $productos2 = [];
         foreach($productos as $clave => $producto){
            $date = Carbon::now();
            $date = $date->format('Y-m-d h:i:s');
            $producto2=[];
            $duplicado = $CatalogoProducto::where('CodigoDeBarras', $producto["CodigoDeBarras"])->get();  
              if(count($duplicado)<=0){
                $data = array(
                  "CodigoDeBarras" => $producto["CodigoDeBarras"],
                    "NombreGenerico" => $producto["NombreGenerico"],
                    "NombreComercial" => $producto["NombreComercial"],
                    "FormaFarmaucetica" => $producto["FormaFarmaucetica"],
                    "Contenido" => $producto["Contenido"],
                    "Presentacion" => $producto["Presentacion"],
                    "Comentarios" => $producto["Comentarios"],
                    "Estado" => true,
                    "created_at" => $date,
                    "updated_at"=> $date
    
                );
                if($CatalogoProducto::insert($data)){
                  $producto2 = $producto;
                  $id = $CatalogoProducto::where('CodigoDeBarras', $producto["CodigoDeBarras"])->first();
                  $producto2["Id"] = $id->id;
                  $producto2["updated_at"] = $date;
                  array_push($productos2,$producto2);
                  $correctos++;
                }else{
                  $incorrectos++;
                }  
            }

           
          }

          if($incorrectos<=0){
            event(new Actualizacion($productos2,"store_catalogos_productos_multiple"));
            $respuesta = [
              "solicitud"=>true,
              "tipo_solicitud"=>'insercion_multiple',
              "estatus"=>true
            ];
            return json_encode($respuesta);
          }
          
        



       }else if($request->type == "single"){
        $producto = $request->data;
        $CatalogoProducto = new CatalogoProducto();
        $date = Carbon::now();
        $date = $date->format('Y-m-d h:i:s');

        $duplicado = $CatalogoProducto::where('CodigoDeBarras', $producto["CodigoDeBarras"])->get();  
          if(count($duplicado)<=0){
            $data = array(
                "CodigoDeBarras" => $producto["CodigoDeBarras"],
                "NombreGenerico" => $producto["NombreGenerico"],
                "NombreComercial" => $producto["NombreComercial"],
                "FormaFarmaucetica" => $producto["FormaFarmaucetica"],
                "Contenido" => $producto["Contenido"],
                "Presentacion" => $producto["Presentacion"],
                "Comentarios" => $producto["Comentarios"],
                "Estado" => true,
                "created_at" => $date,
                "updated_at"=> $date

            );

            $query = $CatalogoProducto::insert($data);
            if($query){
              $id = $CatalogoProducto::where('CodigoDeBarras', $producto["CodigoDeBarras"])->first(); 
              $producto["Id"] = $id->id;
              $producto["updated_at"] = $date;
              event(new Actualizacion($producto,"store_catalogos_productos_single"));
              $respuesta = [
                
                "solicitud"=>true,
                "tipo_solicitud"=>'insercion_multiple',
                "estatus"=>true
              ];
              return json_encode($respuesta);
            }else{
              $respuesta = [
                "solicitud"=>false,
                "tipo_solicitud"=>'insercion',
                "estatus"=>false
              ];
            }  


       }

    }


  }
    public function get(){

      /*\Config::set("database.connections.mysql", [
        "host" => "logisticademedicamentos.com",
        "database" => "logisti2_sistema_nasalud",
        "username" => "logisti2_sistema",
        "password" => "sistemaMYSQL",
        "driver"=>"mysql"
    ]);*/

   /* \DB::statement('CREATE DATABASE test'); */



        $CatalogoProducto = new CatalogoProducto();
        $get = $CatalogoProducto::all();
        $items = count($get);
        $data=[];
        for($i=$items-1; $i >=0; $i--) { 
         $data[] =  $get[$i];
        }
        echo json_encode($data);

        
    }

    public function validator(Request $request){

      if($request->type=="product-only"){
        $CatalogoProducto = new CatalogoProducto();
        $validar = $CatalogoProducto::where('CodigoDeBarras', $request->token)->get();  

        if(count($validar)<=0){
          return 1;
      }else{
        return 0;
      }

      }

    }

    public function update(Request $request){
      $CatalogoProducto = new CatalogoProducto();
      if($request->type=="Desactivar"){
        $accion = $request->type;
        $actualizacion = $CatalogoProducto::where('CodigoDeBarras', $request->data)
      ->update(['Estado' => 0]);
      }else if($request->type=="Activar"){
        $accion = $request->type;
        $actualizacion = $CatalogoProducto::where('CodigoDeBarras', $request->data)
        ->update(['Estado' => 1]);
      }else if($request->type=="Desactivar_Multiple"){
        $accion = $request->type;
        $errores=0;
        foreach($request->data as $key => $valor){
          $actualizacion = $CatalogoProducto::where('CodigoDeBarras', $valor)
          ->update(['Estado' => 0]);
          if(!$actualizacion){
            $errores++;
          }

        }

        if($errores<=0){
          $actualizacion = true;
        }else{
          $actualizacion = false;
        }
      }else if($request->type=="Activar_Multiple"){
        $accion = $request->type;
        $errores=0;
        foreach($request->data as $key => $valor){
          $actualizacion = $CatalogoProducto::where('CodigoDeBarras', $valor)
          ->update(['Estado' => 1]);
          if(!$actualizacion){
            $errores++;
          }

        }

        if($errores<=0){
          $actualizacion = true;
        }else{
          $actualizacion = false;
        }
      }else if($request->type=="update_single"){
        $accion = $request->type;
        $actualizacion = $CatalogoProducto::where('id', $request->data['Id'])
        ->update(
          [
            "CodigoDeBarras" => $request->data['CodigoDeBarras'],
                "NombreGenerico" => $request->data['NombreGenerico'],
                "NombreComercial" => $request->data['NombreComercial'],
                "FormaFarmaucetica" => $request->data['FormaFarmaucetica'],
                "Contenido" => $request->data['Contenido'],
                "Presentacion" => $request->data['Presentacion'],
                "Comentarios" => $request->data['Comentarios'],
                "Estado" => true,

            
          ]
        
        );


      }
      
      if($actualizacion){
        if($request->type=="Desactivar_Multiple" or $request->type=="Activar_Multiple"){
          event(new Actualizacion(["data"=>$request->data,"task"=>$accion],"update_catalogos_productos_multiple"));
        }else{
          event(new Actualizacion(["data"=>$request->data,"task"=>$accion],"update_catalogos_productos_single"));
        }
        return 1;
      }else{
        return 0;
      }

    }
    
}
