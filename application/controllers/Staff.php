<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Staff_model');
    }

    public function view($slug)
    {
        $staff = $this->Staff_model->get_by_slug($slug);

        if (!$staff) {
            show_404();
        }

        $data['title'] = ($staff->full_title_name ?: $staff->name) . ' - UNSRAT';
        $data['staff'] = $staff;
        $data['grants'] = $this->Staff_model->get_grants($staff->id);
        $data['publications'] = $this->Staff_model->get_publications($staff->id);
        $data['research'] = $this->Staff_model->get_research($staff->id);
        $data['community_service'] = $this->Staff_model->get_community_service($staff->id);
        $this->load->view('templates/header', $data);
        $this->load->view('staff/view', $data);
        $this->load->view('templates/footer');
    }

    public function update_profile($staff_id)
    {
        if (!is_admin_or_dosen()) redirect('');

        $update = [
            'nip'      => $this->input->post('nip'),
            'nidn'     => $this->input->post('nidn'),
            'position'       => $this->input->post('position'),
            'email'          => $this->input->post('email'),
            'scopus_id'      => $this->input->post('scopus_id')      ?: null,
            'sinta_id'       => $this->input->post('sinta_id')        ?: null,
            'google_scholar' => $this->input->post('google_scholar')  ?: null,
        ];

        $this->Staff_model->update_profile($staff_id, $update);

        $staff = $this->db->get_where('staff', ['id' => $staff_id])->row();
        if ($staff) redirect('staff/' . $staff->slug);
        redirect('');
    }

    public function save_grant($staff_id)
    {
        if (!is_admin_or_dosen()) redirect('');

        $grant_id = $this->input->post('grant_id') ?: null;
        $data = [
            'title'       => $this->input->post('title'),
            'funder'      => $this->input->post('funder'),
            'role'        => $this->input->post('role'),
            'year_start'  => $this->input->post('year_start') ?: null,
            'year_end'    => $this->input->post('year_end') ?: null,
            'amount'      => $this->input->post('amount') ?: null,
            'description' => $this->input->post('description'),
        ];

        $doc = $this->_upload_document('document', $staff_id, 'grant');
        if ($doc) $data['document_path'] = $doc;

        $this->Staff_model->save_grant($staff_id, $data, $grant_id);

        $staff = $this->db->get_where('staff', ['id' => $staff_id])->row();
        if ($staff) redirect('staff/' . $staff->slug . '#grants');
        redirect('');
    }

    public function save_publication($staff_id)
    {
        if (!is_admin_or_dosen()) redirect('');

        $pub_id = $this->input->post('pub_id') ?: null;
        $data = [
            'title'              => $this->input->post('title'),
            'type'               => $this->input->post('type') ?: 'journal',
            'journal_name'       => $this->input->post('journal_name'),
            'year'               => $this->input->post('year') ?: null,
            'volume'             => $this->input->post('volume'),
            'pages'              => $this->input->post('pages'),
            'doi'                => $this->input->post('doi'),
            'url'                => $this->input->post('url'),
            'authors'            => $this->input->post('authors'),
            'abstract'           => $this->input->post('abstract'),
            'group_of_knowledge' => $this->input->post('group_of_knowledge'),
            'original_language'  => $this->input->post('original_language'),
            'level'              => $this->input->post('level'),
            'status'             => $this->input->post('status'),
        ];

        $doc = $this->_upload_document('document', $staff_id, 'publikasi');
        if ($doc) $data['document_path'] = $doc;

        $this->Staff_model->save_publication($staff_id, $data, $pub_id);

        $staff = $this->db->get_where('staff', ['id' => $staff_id])->row();
        if ($staff) redirect('staff/' . $staff->slug . '#publications');
        redirect('');
    }

    public function save_research($staff_id)
    {
        if (!is_admin_or_dosen()) redirect('');

        $research_id = $this->input->post('research_id') ?: null;
        $data = [
            'title'              => $this->input->post('title'),
            'authors'            => $this->input->post('authors'),
            'research_date'      => $this->input->post('research_date') ?: null,
            'abstract'           => $this->input->post('abstract'),
            'group_of_knowledge' => $this->input->post('group_of_knowledge'),
            'original_language'  => $this->input->post('original_language'),
            'level'              => $this->input->post('level'),
            'status'             => $this->input->post('status'),
        ];

        $doc = $this->_upload_document('document', $staff_id, 'penelitian');
        if ($doc) $data['document_path'] = $doc;

        $this->Staff_model->save_research($staff_id, $data, $research_id);

        $staff = $this->db->get_where('staff', ['id' => $staff_id])->row();
        if ($staff) redirect('staff/' . $staff->slug . '#research');
        redirect('');
    }

    public function save_community_service($staff_id)
    {
        if (!is_admin_or_dosen()) redirect('');

        $cs_id = $this->input->post('cs_id') ?: null;
        $data = [
            'title'              => $this->input->post('title'),
            'authors'            => $this->input->post('authors'),
            'service_date'       => $this->input->post('service_date') ?: null,
            'abstract'           => $this->input->post('abstract'),
            'group_of_knowledge' => $this->input->post('group_of_knowledge'),
            'original_language'  => $this->input->post('original_language'),
            'level'              => $this->input->post('level'),
            'status'             => $this->input->post('status'),
        ];

        $doc = $this->_upload_document('document', $staff_id, 'pengabdian');
        if ($doc) $data['document_path'] = $doc;

        $this->Staff_model->save_community_service($staff_id, $data, $cs_id);

        $staff = $this->db->get_where('staff', ['id' => $staff_id])->row();
        if ($staff) redirect('staff/' . $staff->slug . '#community');
        redirect('');
    }

    public function delete_grant($staff_id)
    {
        if (!is_admin_or_dosen()) redirect('');
        $this->Staff_model->delete_grant($this->input->post('grant_id'), $staff_id);
        $staff = $this->db->get_where('staff', ['id' => $staff_id])->row();
        if ($staff) redirect('staff/' . $staff->slug . '#grants');
        redirect('');
    }

    public function delete_publication($staff_id)
    {
        if (!is_admin_or_dosen()) redirect('');
        $this->Staff_model->delete_publication($this->input->post('pub_id'), $staff_id);
        $staff = $this->db->get_where('staff', ['id' => $staff_id])->row();
        if ($staff) redirect('staff/' . $staff->slug . '#publications');
        redirect('');
    }

    public function delete_research($staff_id)
    {
        if (!is_admin_or_dosen()) redirect('');
        $this->Staff_model->delete_research($this->input->post('research_id'), $staff_id);
        $staff = $this->db->get_where('staff', ['id' => $staff_id])->row();
        if ($staff) redirect('staff/' . $staff->slug . '#research');
        redirect('');
    }

    public function delete_community_service($staff_id)
    {
        if (!is_admin_or_dosen()) redirect('');
        $this->Staff_model->delete_community_service($this->input->post('cs_id'), $staff_id);
        $staff = $this->db->get_where('staff', ['id' => $staff_id])->row();
        if ($staff) redirect('staff/' . $staff->slug . '#community');
        redirect('');
    }

    /**
     * Handle file upload, return relative path or null if no file / error.
     * Allowed: pdf, doc, docx. Max 10MB.
     */
    private function _upload_document($field, $staff_id, $category)
    {
        if (empty($_FILES[$field]['name'])) return null;

        $upload_path = FCPATH . 'assets/uploads/documents/';

        $this->load->library('upload', [
            'upload_path'   => $upload_path,
            'allowed_types' => 'pdf|doc|docx',
            'max_size'      => 10240,
            'file_name'     => $category . '_' . $staff_id . '_' . time(),
        ]);

        if ($this->upload->do_upload($field)) {
            return 'assets/uploads/documents/' . $this->upload->data('file_name');
        }
        return null;
    }
}
