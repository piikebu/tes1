<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty_model extends CI_Model {

    public function get_all()
    {
        $this->db->order_by('name', 'ASC');
        return $this->db->get('faculties')->result();
    }

    public function get_by_slug($slug)
    {
        return $this->db->get_where('faculties', ['slug' => $slug])->row();
    }

    public function get_departments($faculty_id)
    {
        $this->db->where('faculty_id', $faculty_id);
        $this->db->order_by('name', 'ASC');
        return $this->db->get('departments')->result();
    }

    public function count_staff($faculty_id)
    {
        $this->db->select('COUNT(s.id) as total');
        $this->db->from('staff s');
        $this->db->join('departments d', 'd.id = s.department_id');
        $this->db->where('d.faculty_id', $faculty_id);
        return $this->db->get()->row()->total;
    }
}
