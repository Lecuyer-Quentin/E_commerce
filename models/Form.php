<?php

class Form {
    private $data;
    private $class;
    private $id;
    private $name;
    private $content;
    private $action;
    private $fields;
    private $header;
    private $footer;
    private $row;
    private $btn_value;
    private $method;
    private $enctype;

    public function __construct(){
        $this->data = array();
    }

    public function setData($data){
        $this->data = $data;
        $this->class = $this->data['class'] ?? null;
        $this->id = $this->data['id'] ?? null;
        $this->name = $this->data['name'] ?? null;
        $this->content = $this->data['content'] ?? null;
        $this->action = $this->data['action'] ?? null;
        $this->fields = $this->data['fields'] ?? null;
        $this->header = $this->data['header'] ?? null;
        $this->footer = $this->data['footer'] ?? null;
        $this->row = $this->data['row'] ?? null;
        $this->btn_value = $this->data['btn_value'] ?? null;
        $this->method = $this->data['method'] ?? 'post';
        $this->enctype = $this->data['enctype'] ?? 'application/x-www-form-urlencoded';
    }

    public function getData(){
        return $this->data;
    }


    public function generateError(){
            $error = "<div id='alert_message_$this->id' class='d-none'></div>";
        return $error;
    }

    private function generateHeader() {
        $head = null;
        if($this->header) {
            $head = "<div>";
                foreach($this->header as $line) {
                    $type = $line['type'];
                    $content = $line['content'];
                    $head .= "<$type>$content</$type>";
                }

            $head .= "</div>";
        }
        return $head;
    }

    private function generateFooter() {
        $foot = null;
        if($this->footer) {
            $foot = "<div>";
            foreach($this->footer as $line) {
                $type = $line['type'];
                $content = $line['content'];
                $foot .= "<$type>$content</$type>";
            }
            $foot .= "</div>";
        }
        return $foot;
    }
    private function generateField() {
        $input = null;
        foreach($this->fields as $field) {
            $type = $field['type'] ?? null;
            $name = $field['name'] ?? null;
            $label = $field['label'] ?? null;
            $value = $field['value'] ?? null;
            $required = $field['required'] ?? null;

            if(is_callable($value)) {//? If value is a function, call it
                $value = $value();
            }
            switch($type){
                case 'input':
                case 'number':
                    $input .= "<div class='form-group'>"; 
                        $input .= "<label for='$name'>$label</label>";
                        $input .= "<input type='$type' name='$name' id='$name' value='$value' required='$required'>";
                    $input .= "</div>";
                    break;
                case 'textarea':
                    $input .= "<div class='form-group'>";
                        $input .= "<label for='$name'>$label</label>";
                        $input .= "<textarea name='$name' id='$name' required='$required'>$value</textarea>";
                    $input .= "</div>";
                    break;
                case 'hidden':
                    $input .= "<input type='hidden' name='$name' value='$value'>";
                    break;
                case "password":
                    $input .= "<div class='form-group'>"; 
                        $input .= "<label for='$name'>$label</label>";
                        $input .= "<input type='$type' name='$name' id='$name' required='$required'>";
                    $input .= "</div>";
                    break;
                case 'date':
                    $input .= "<div class='form-group'>";
                        $input .= "<label for='$name'>$label</label>";
                        $input .= "<input type='$type' name='$name' id='$name' required='$required'>";
                    $input .= "</div>";
                    break;
                case 'select':
                    $options = $field['options'];
                    $input .= "<div class='form-group'>";
                        $input .= "<label for='$name'>$label</label>";
                        $input .= "<select name='$name' id='$name' required='$required'>";
                        foreach($options as $option) {
                            $name = $option->get_nom();
                            if($option instanceof Role){
                                $value = $option->get_idRole();
                            }else if($option instanceof Categorie){
                                $value = $option->get_idCategorie();
                            }else if($option instanceof Special){
                                $value = $option->get_idSpecial();
                            }else if(is_array($option)) {
                                $value = $option['value'];
                            //}else if(is_object($option)) {
                            //    $value = $option->get_id();
                            }else{
                                $value = $option;
                            }

                            $input .= "<option value='$value'>$name</option>";
                        }
                        $input .= "</select>";
                    $input .= "</div>";
                    break;
                case 'file':
                    $input .= "<div class='form-group'>";  
                        $input .= "<label for='$name'>$label</label>";
                        $input .= "<input type='$type' name='$name' id='$name' required='$required' accept='image/*'>";
                    $input .= "</div>";
                    break;
                case "link":
                    $input .= "<a href='$value'>$label</a>";
                    break;
            }
    }
        return $input;
    }
    private function generateBtn() {
        $btn = "<button value='$this->btn_value' type='submit'>$this->content</button>";
        return $btn;
    }

    public function generateForm() {
        $form = "<form id='$this->id' action='$this->action' class='$this->class' method='$this->method' enctype='$this->enctype'>";
            $form .= $this->generateHeader();
            $form .= $this->generateField();
            $form .= $this->generateBtn();
            $form .= $this->generateError();
            $form .= $this->generateFooter();
        $form .= "</form>";
        return $form;
    }
}