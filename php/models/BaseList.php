<?php
abstract class BaseList{
    protected $dataArray;
    protected $id;
    public function __construct(){
        $this->dataArray=array();
        $this->id=0;
    }
    public abstract function add($params);
    public function display(){
        foreach($this->dataArray as $item){
            $item->displayInfo();
        }
    }
    public function update($params){
        foreach($this->dataArray as $item){
            if($item->getId()==$params['id']){
                $item->update($params);
                break;
            }
            
        }
    }
    public function delete($id){
        for($i=0;$i<count($this->dataArray);$i++){
            if($this->dataArray[$i]->getId()==$id){
                array_splice($this->dataArray,$i,1);
                break;
            }
            
        }
    }
    public function exportAsJSON(){
        $result=array();
        foreach($this->dataArray as $item){
            array_push($result,$item->getAsAssocArray());
        }
        return json_encode($result,JSON_UNESCAPED_UNICODE);
    }
    public function exportAsAssocArrays(){
        $result=array();
        foreach($this->dataArray as $item){
            array_push($result,$item->getAsAssocArray());
        }
        return $result;
    }
    public function exportAsTableData(){
        $result='';
        foreach($this->dataArray as $item){
            $result.=$item->getAsTableRow();
        }
        return $result;
    }
    public function getItemById($id){
        foreach($this->dataArray as $item){
            if($item->getId()==$id){
                return $item->getAsAssocArray();
            }
        }
    }
}