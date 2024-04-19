<?php
//require_once 'Form.php';

class Table{
    private $data;
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
        $this->items = $data['items'];
        $this->columns = $data['columns'];
        $this->actions = $data['actions'] ?? null;
        $this->header = $data['header'] ?? null;
        $this->footer = $data['footer'] ?? null;
        $this->class = $data['class'] ?? null;
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

    private function action_item($id, $label, $type, $action) {
       switch($type) {
           case 'form':
               $action_btn = "<form method='post' class='action_btn' action='$action'>";
                   $action_btn .= "<input type='hidden' name='id' value='$id'>";
                   $action_btn .= "<button type='submit' name='id' value='$id'>$label</button>";
               $action_btn .= "</form>";
               break;
           case 'link':
               $action_btn = "<button class='action_btn'><a href='$action'>$label</a></button>";
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
                $column .= '<ul class="dropdown-menu">';
                foreach($this->actions as $action) {
                    $value = $action['value'] ?? null;
                    $act = $action['action'] ?? null;
                    $label = $action['label'];
                    $type = $action['type'];

                    $id = null;
                    if($action instanceof Produit){
                        $id = $action->get_idProduit();
                    } elseif ($action instanceof Utilisateur){
                        $id = $action->get_idUtilisateur();
                    }
                    $column .= '<li>';
                    $column .= $this->action_item($id, $label, $type, $act);
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
