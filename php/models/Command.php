<?php

class Command {
    private $id;
    private $command_name;
    private $description;
    private $category_id;

    public function __construct($params) {
        $this->id = $params['id'];
        $this->command_name = $params['command_name'];
        $this->description = $params['description'];
        $this->category_id = $params['category_id'];
    }

    public function update($params) {
        if (isset($params['command_name'])) $this->command_name = $params['command_name'];
        if (isset($params['description'])) $this->description = $params['description'];
        if (isset($params['category_id'])) $this->category_id = $params['category_id'];
    }

    public function displayInfo() {
        echo "ID: {$this->id} - {$this->command_name} (Категорія: {$this->category_id}) - Опис: {$this->description}<br>";
    }

    public function getId() {
        return $this->id;
    }
    public function getAsArray(){
        return array($this->command_name,$this->description,$this->category_id);
    }

    public function getAsAssocArray(){
        return array('id'=>$this->id,'command_name'=>$this->command_name,'description'=>$this->description,'category_id'=>$this->category_id);
    }

    public function getAsXML(){
        return '<command>
                    <id>'.$this->id.'</id>
                    <command_name>'.$this->command_name.'</command_name>
                    <description>'.$this->description.'</description>
                    <category_id>'.$this->category_id.'</category_id>
                </command>';
    }

    public function getAsTableRow(){
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->command_name.'</td>
                    <td>'.$this->description.'</td>
                    <td>'.$this->category_id.'</td>
                    <td><a href="add-command.php?id='.$this->id.'">Редагувати</a><a href="command-list.php?action=delete&id='.$this->id.'">Видалити</a></td>
                </tr>';
    }

}