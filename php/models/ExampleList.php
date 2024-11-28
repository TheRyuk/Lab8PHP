<?php
require_once('../models/BaseList.php');
require_once('../models/Example.php');
class ExampleList extends BaseList {
    public function add($params){
        if(isset($params['id'])){
            $this->id++;
        } else{
            $this->id++;
            $params['id']=$this->id;
        }
        $newObj=new Example($params);
        array_push($this->dataArray,$newObj);
    }

    public function exportAsArray(){
        $result=array(['command_id','example_code','description']);
        foreach($this->dataArray as $item){
            array_push($result,$item->getAsArray());
        }
        return $result;
    }

    public function exportAsXML(){
        $result='<?xml version="1.0" encoding="UTF-8"?><examples>';
        foreach($this->dataArray as $item){
            $result.=$item->getAsXML();
        }
        $result.='</examples>';
        return $result;
    }


    public function readFromFile(){
        $row=0;
        if (($handle = fopen("../data/examples.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
              if($row>0){
                $dataArray=array('command_id'=>$data[0],'example_code'=>$data[1],'description'=>$data[2]);
                $this->add($dataArray);
              }
              $row++;
            }
            fclose($handle);
        }
    }

    public function saveToFile(){
        $fp = fopen('../data/examples.csv', 'w');
            foreach ($this->exportAsArray() as $row) {
                    fputcsv($fp, $row);
            }
                fclose($fp);
        }

        public function getItemById($id){
            foreach($this->dataArray as $item){
                if($item->getId()==$id){
                    return $item->getAsAssocArray();
                }
            }
        }

        public function deleteFromDatabaseById($conn,$id){
            $stmt = $conn->prepare("DELETE from examples WHERE id=?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            return true;
        }

        public function addToDatabase($conn,$params){
            $stmt = $conn->prepare("INSERT INTO `examples` VALUES (DEFAULT,?,?,?)");
            $stmt->bind_param("sss", $command_id,$example_code, $description);
            $command_id = $params['command_id'];
            $example_code = $params['example_code'];
            $description = $params['description'];
            $stmt->execute();
            return true;
        }

        public function updateDatabaseRecord($conn,$params){
            $stmt = $conn->prepare("UPDATE `examples` SET `command_id`=?,`example_code`=?, `description` = ? WHERE id=?");
            $stmt->bind_param("ssss", $command_id,$example_code, $description, $id);
            $command_id=$params['command_id'];
            $example_code = $params['example_code'];
            $description = $params['description'];
            $id=$params['id'];
            $stmt->execute();
            return true;
        }
        public function getAllFromDatabase($conn){

            $sql = "SELECT examples.*, commands.command_name AS command_id FROM examples INNER JOIN commands ON examples.command_id = commands.id";
    
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $this->add($row);
                }
            }
        }

}