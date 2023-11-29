<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\EmployeeModel;
class EmployeesController extends ResourceController
{
    //POST
    public function createEmploye(){

        $rules = [
            "name"=>"required",
            "email" => "required|valid_email|is_unique[employees.email] "
        ];
        if(!$this->validate($rules)){
            //error
            $response = [
                "status" => 500,
                "message"=> $this->validator->getErrors(),
                "data"=> [],
                "error" => true,
            ];

    }
    else{
        

        // no validation error
        $file = $this->request->getFile("profile_image");
        if(!empty($file)){
            //has image

            $image_name= $file->getName();
            $temp = explode(".",$image_name);
            $newImageName = round(microtime(true)).'.'.end($temp);
            if($file->move("images", $newImageName)){
                //image uploaded
                $emp_obj = new EmployeeModel();
                $data = [
    "name"=> $this->request->getVar("name"),
    "email"=> $this->request->getVar("email"),
    "profile_image"=> "/images/".$newImageName
    ];
    
    if($emp_obj->insert($data)){
        //data has been inserted
        $response = [
            "status" => 200,
            "message"=> "Employee has been created",
            "data"=> [],
            "error" => false,
        ];
    }
    else{
        //data failed to insert
        $response = [
            "status" => 500,
            "message"=> "Failed to create an employee",
            "data"=> [],
            "error" => true,
        ];
    }
        }
        else{
            //image failed tto upload
            $response = [
                "status" => 500,
                "message"=> "Failed to upload an employee image",
                "data"=> [],
                "error" => true,
            ];
    
        }


        }

        else{
            //no image 
       
              
                $emp_obj = new EmployeeModel();
                $data = [
    "name"=> $this->request->getVar("name"),
    "email"=> $this->request->getVar("email"),
    
    ];
    
    if($emp_obj->insert($data)){
        //data has been inserted
        $response = [
            "status" => 200,
            "message"=> "Employee has been created",
            "data"=> [],
            "error" => false,
        ];
    }
    else{
        //data failed to insert
        $response = [
            "status" => 500,
            "message"=> "Failed to create an employee",
            "data"=> [],
            "error" => true,
        ];
    }
        }


        
        
    }
    return $this->respondCreated($response);
}


    

 //GET
    public function listEmployees(){

        $emp_obj = new EmployeeModel();
        $response = [
            "status" => 200,
            "message"=> "Employees List",
            "data"=> [
                $emp_obj->findAll(),
            ],
            "error" => false,
        ];

        return $this->respondCreated($response);



    }

    //GET
    public function singleEmployeeDetail($emp_id){
        $emp_obj = new EmployeeModel();
        $emp_data = $emp_obj->find($emp_id);
        if(!empty($emp_data)){
            $response = [

                "status" => 200,
                "message"=> "Single Employee Detail",
                "data"=> $emp_data,
                "error" => false,

            ];
        }
        else{
            $response = [

                "status" => 404,
                "message"=> "No Employee found",
                "data"=> [],
                "error" => true,

            ];
        }
        return $this->respondCreated($response);
    }

//POST->PUT
    public function editEmployee($emp_id){

    }

    //DELETE
    public function deleteEmployee($emp_id){

}
}
