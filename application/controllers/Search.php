<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Staff_model');
    }

    public function suggest()
    {
        $keyword = trim($this->input->get('q') ?: '');
        if (strlen($keyword) < 2) {
            $this->output->set_content_type('application/json');
            echo json_encode([]);
            return;
        }

        $results = $this->Staff_model->search($keyword);
        $out = [];
        foreach (array_slice($results, 0, 8) as $s) {
            $out[] = [
                'name'            => $s->full_title_name ?: $s->name,
                'slug'            => $s->slug,
                'department_name' => $s->department_name,
            ];
        }

        $this->output->set_content_type('application/json');
        echo json_encode($out);
    }
}
