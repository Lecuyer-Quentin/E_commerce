<?php

class Modal
{
    public $data;
    public $btn_name;
    public $btn_target;
    public $modal_id;
    public $modal_label;
    public $modal_body;

    public function __construct($data)
    {
        $this->data = $data;
        $this->btn_name = $this->data['btn_name'];
        $this->btn_target = $this->data['btn_target'];
        $this->modal_id = $this->data['modal_id'];
        $this->modal_label = $this->data['modal_label'];
        $this->modal_body = $this->data['modal_body'];
    }

    public function modal_trigger()
    {
        $btn = '<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="'.$this->btn_target.'">';
        $btn .= $this->btn_name;
        $btn .= '</button>';
        return $btn;
    }

    public function render()
    {
        $modal = '<div class="modal fade" id="'.$this->modal_id.'" tabindex="-1" aria-labelledby="'.$this->modal_label.'" aria-hidden="true">';
            $modal .= '<div class="modal-dialog modal-dialog-centered">';
                $modal .= '<div class="modal-content border-0 bg-transparent">';
                    $modal .= '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    $modal .= '<div class="modal-body d-flex justify-content-center align-items-center">';
                        $modal .= $this->modal_body;
                    $modal .= '</div>';
                $modal .= '</div>';
            $modal .= '</div>';
        $modal .= '</div>';
        return $modal;
    }

    
}
