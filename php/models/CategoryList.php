<?php
require_once('../models/BaseList.php');
require_once('../models/Category.php');

class CategoryList extends BaseList {
    public function add($params){
        if(isset($params['id'])){
            $this->id++;
        } else{
            $this->id++;
            $params['id']=$this->id;
        }
        $newObj=new Category($params);
        array_push($this->dataArray,$newObj);
    }

    public function exportAsArray(){
        $result=array(['name','description']);
        foreach($this->dataArray as $item){
            array_push($result,$item->getAsArray());
        }
        return $result;
    }
    public function exportAsXML(){
        $result='<?xml version="1.0" encoding="UTF-8"?><categories>';
        foreach($this->dataArray as $item){
            $result.=$item->getAsXML();
        }
        $result.='</categories>';
        return $result;
    }
    public function exportAsDropdownItems(){
        $result='';
        foreach($this->dataArray as $item){
            
            $itemData=$item->getAsAssocArray();
            $result.='<option value="'.$itemData['id'].'">'.$itemData['name'].'</option>';
        }
        
        return $result;
    }
    public function readFromFile(){
        $row=0;
        if (($handle = fopen("../data/categories.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
              if($row>0){
                $dataArray=array('name'=>$data[0],'description'=>$data[1]);
                $this->add($dataArray);
                }
              $row++;
                }
            fclose($handle);
             }
            }

    public function saveToFile(){
        $fp = fopen('../data/categories.csv', 'w');
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
            $stmt = $conn->prepare("DELETE from categories WHERE id=?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            return true;
        }

        public function addToDatabase($conn,$params){
            $stmt = $conn->prepare("INSERT INTO `categories` VALUES (DEFAULT,?,?)");
            $stmt->bind_param("ss", $name, $description);
        $name = $params['name'];
        $description = $params['description'];
            $stmt->execute();
            return true;
        }

        public function updateDatabaseRecord($conn,$params){
            $stmt = $conn->prepare("UPDATE `categories` SET `name`=?, `description` = ? WHERE id=?");
            $stmt->bind_param("sss", $name, $description, $id);
            $name=$params['name'];
            $description = $params['description'];
            $id=$params['id'];
            $stmt->execute();
            return true;
        }

        public function getAllFromDatabase($conn){
            $sql = "SELECT * FROM categories";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $this->add($row);
                }
            }
        }
}