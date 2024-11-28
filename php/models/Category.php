<?php
class Category {
    private $id;
    private $name;
    private $description;

    public function __construct($params) {
        $this->id = $params['id'];
        $this->name = $params['name'];
        $this->description = $params['description'];
    }

    public function update($params) {
        if (isset($params['name'])) $this->name = $params['name'];
        if (isset($params['description'])) $this->description = $params['description'];
    }

    public function displayInfo() {
        echo "ID: {$this->id} - {$this->name} ({$this->description})<br>";
    }

    public function getId() {
        return $this->id;
    }
    
    public function getAsArray(){
        return array($this->name,$this->description);
    }
    public function getAsAssocArray(){
        return array('id'=>$this->id,'name'=>$this->name,'description'=>$this->description);
    }

    public function getAsXML(){
        return '<category>
                    <id>'.$this->id.'</id>
                    <name>'.$this->name.'</name>
                    <description>'.$this->description.'</description>
                </category>';
    }

    public function getAsTableRow(){
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->name.'</td>
                    <td>'.$this->description.'</td>
                    <td><a href="add-category.php?id='.$this->id.'">Редагувати</a><a href="category-list.php?action=delete&id='.$this->id.'">Видалити</a></td>
                </tr>';
    }

}