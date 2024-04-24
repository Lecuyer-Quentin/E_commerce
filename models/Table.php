<?php

class Table{
    private $data;
    public $id;
    public $items;
    private $columns;
    private $actions;
    private $header;
    private $footer;
    private $class;

    public function __construct(){
        $this->data = array();
    }

    public function setData($data){
        $this->data = $data;
        $this->id = $data['id'];
        $this->items = $data['items'];
        $this->columns = $data['columns'];
        $this->actions = $data['actions'] ?? null;
        $this->header = $data['header'] ?? null;
        $this->footer = $data['footer'] ?? null;
        $this->class = $data['class'] ?? null;
    }

    private function generateAlert(){
        $alert = "<div id='table_alert_$this->id' class='alert d-none' role='alert'>";
        $alert .= "</div>";
        return $alert;
    }

    private function generateHeader() {
        $head = null;
        if($this->header) {
            $head .= "<tr>";
                    $head .= "<th colspan='" . (count($this->columns) + 1) . "'>";
                    foreach($this->header as $line) {
                        $type = $line['type'];
                        $content = $line['content'];
                        if($type == 'form') {
                            $value = $line['value'];
                            $head .= "<form method='post' class='action_btn'>";
                                $head .= "<button type='submit' name='button' value='$value'>$content</button>";
                            $head .= "</form>";                           
                        } else {
                            $head .= "<$type>$content</$type>";
                        }
                    }
                    $head .= $this->generateAlert();  

                    $head .= "</th>"; 
            $head .= "</tr>";
        }
            return $head;
    }
    private function generateTableHead() {
            $thead = "<tr>";
                foreach($this->columns as $col) {
                    $thead .= "<th>" . $col['label'] . "</th>";
                }
                if($this->actions) {
                    $thead .= "<th class='text-center'>Actions</th>";
                }

            $thead .= "</tr>";
        return $thead;

    }
    private function generateFooter() {
        $foot = "<tr>";
            $foot .= "<td colspan='" . (count($this->columns) + 1) . "'>";
                foreach($this->footer as $line) {
                    $type = $line['type'];
                    $content = $line['content'];
                    $foot .= "<$type>$content</$type>";
                }
            $foot .= "</td>";
        $foot .= "</tr>";
        return $foot;
    }

    private function action_item($action, $item) {
        $value = $action['value'] ?? null;
        $act = $action['action'] ?? null;
        $label = $action['label'];
        $type = $action['type'];
        $icon = $action['icon'] ?? null;
        $id = null;

        if($value) {
            $id = $item->get_value_of($value);
        }
        $action_btn = null;
       switch($type) {
           case 'form':
               $action_btn = "<form method='post' action='$act' id='action_btn_$this->id' class='my-2'>";
                   $action_btn .= "<input type='hidden' name='id' value='$id'>";
                   $action_btn .= "<button type='submit' class='btn btn-light w-100 text-start '>";
                     if($icon) {
                          $action_btn .= "<img src='$icon' alt='$label' class='mx-1'>";
                     }
                     $action_btn .= "$label</button>";
               $action_btn .= "</form>";
               break;
        }
       return $action_btn;
    }

    private function generateColumn() {
        $column = "";
        foreach($this->items as $item) {
            $column .= "<tr class='table_row'>";
            foreach($this->columns as $col) {
                if(is_array($item->get_value_of($col['name']))) {
                    $column .= "<td class='table_cell'>";
                        $column .= "<p>";
                            foreach($item->get_value_of($col['name']) as $value) {
                                $column .= $value . "<br>";
                            }
                        $column .= "</p>";
                    $column .= "</td>";
                } else {
                    $column .= "<td class='table_cell'>" . $item->get_value_of($col['name']) . "</td>";
                }
            }
            
            if($this->actions) {
                $column .= "<td class='table_cell text-center'>";
                $column .= '<div class="dropdown">';
                $column .= '<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                $column .= '</button>';
                $column .= '<ul class="dropdown-menu border-0">';
                foreach($this->actions as $action) {
                    
                    $column .= '<li>';
                    $column .= $this->action_item($action, $item);
                    $column .= '</li>';
                }
                $column .= '</ul>';
                $column .= '</div>';
                $column .= "</td>";
            }
            $column .= "</tr>";
        }    
        return $column;
    }

    public function generateTable(){
        $table = "<table class='table table-striped table-hover table-responsive " . $this->class . "'>";
            $table .= "<thead>";
                $table .= $this->generateHeader();
                $table .= $this->generateTableHead();
            $table .= "</thead>";
            $table .= "<tbody>";
                $table .= $this->generateColumn();
            $table .= "</tbody>";
            $table .= "<tfoot>";
                $table .= $this->generateFooter();
            $table .= "</tfoot>";
        $table .= "</table>";
        return $table;
    }
}
