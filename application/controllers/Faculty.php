<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Faculty_model');
        $this->load->model('Staff_model');
    }

    public function view($slug)
    {
        $faculty = $this->Faculty_model->get_by_slug($slug);

        if (!$faculty) {
            show_404();
        }

        $letter  = $this->input->get('letter');
        $keyword = trim($this->input->get('q') ?: '');

        $data['title']          = $faculty->name . ' - UNSRAT';
        $data['faculty']        = $faculty;
        $data['departments']    = $this->Faculty_model->get_departments($faculty->id);
        $data['staff_list']     = $this->Staff_model->get_by_faculty($faculty->id, $letter, $keyword ?: null);
        $data['current_letter'] = $letter;
        $data['current_keyword']= $keyword;
        $data['total_staff']    = $this->Faculty_model->count_staff($faculty->id);

        $this->load->view('templates/header', $data);
        $this->load->view('faculty/view', $data);
        $this->load->view('templates/footer');
    }

    public function suggest($slug)
    {
        $faculty = $this->Faculty_model->get_by_slug($slug);
        if (!$faculty) {
            echo json_encode([]); return;
        }

        $keyword = trim($this->input->get('q') ?: '');
        if (strlen($keyword) < 2) {
            echo json_encode([]); return;
        }

        $results = $this->Staff_model->get_by_faculty($faculty->id, null, $keyword);
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
