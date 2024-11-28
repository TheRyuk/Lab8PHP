<?php
class Example {
    private $id;
    private $command_id;
    private $example_code;
    private $description;

    public function __construct($params) {
        $this->id = $params['id'];
        $this->command_id = $params['command_id'];
        $this->example_code = $params['example_code'];
        $this->description = $params['description'];
    }

    public function update($params) {
        if (isset($params['command_id'])) $this->command_id = $params['command_id'];
        if (isset($params['example_code'])) $this->example_code = $params['example_code'];
        if (isset($params['description'])) $this->description = $params['description'];
    }

    public function displayInfo() {
        echo "Example ID: {$this->id} Command id {$this->command_id} - Code: {$this->example_code} - Description: {$this->description}<br>";
    }

    public function getId() {
        return $this->id;
    }

    public function getAsArray(){
        return array($this->command_id,$this->example_code,$this->description);
    }

    public function getAsAssocArray(){
        return array('id'=>$this->id,'command_id'=>$this->command_id,'example_code'=>$this->example_code,'description'=>$this->description);
    }

    public function getAsXML(){
        return '<example>
                    <id>'.$this->id.'</id>
                    <command_id>'.$this->command_id.'</command_id>
                    <example_code>'.$this->example_code.'</example_code>
                    <description>'.$this->description.'</description>
                </example>';
    }

    public function getAsTableRow(){
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->command_id.'</td>
                    <td>'.$this->example_code.'</td>
                    <td>'.$this->description.'</td>
                    <td><a href="add-example.php?id='.$this->id.'">Редагувати</a><a href="example-list.php?action=delete&id='.$this->id.'">Видалити</a></td>
                </tr>';
    }


}