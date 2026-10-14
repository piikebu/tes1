<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_model extends CI_Model {

    public function get_by_faculty($faculty_id, $letter = null, $keyword = null)
    {
        $this->db->select('s.*, d.name as department_name');
        $this->db->from('staff s');
        $this->db->join('departments d', 'd.id = s.department_id');
        $this->db->where('d.faculty_id', $faculty_id);

        if ($keyword) {
            $this->db->group_start();
                $this->db->like('s.name', $keyword);
                $this->db->or_like('s.nip', $keyword);
                $this->db->or_like('s.expertise', $keyword);
            $this->db->group_end();
        } elseif ($letter) {
            $this->db->like('s.name', $letter, 'after');
        }

        $this->db->order_by('s.name', 'ASC');
        return $this->db->get()->result();
    }

    public function get_by_slug($slug)
    {
        $this->db->select('s.*, d.name as department_name, d.program_type, d.faculty_id, f.name as faculty_name');
        $this->db->from('staff s');
        $this->db->join('departments d', 'd.id = s.department_id');
        $this->db->join('faculties f', 'f.id = d.faculty_id');
        $this->db->where('s.slug', $slug);
        return $this->db->get()->row();
    }

    public function search($keyword)
    {
        $this->db->select('s.*, d.name as department_name, f.name as faculty_name');
        $this->db->from('staff s');
        $this->db->join('departments d', 'd.id = s.department_id');
        $this->db->join('faculties f', 'f.id = d.faculty_id');
        $this->db->group_start();
            $this->db->like('s.name', $keyword);
            $this->db->or_like('s.nip', $keyword);
            $this->db->or_like('s.expertise', $keyword);
        $this->db->group_end();
        $this->db->order_by('s.name', 'ASC');
        return $this->db->get()->result();
    }

    public function get_grants($staff_id)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->order_by('year_start', 'DESC');
        return $this->db->get('staff_grants')->result();
    }

    public function get_publications($staff_id)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->order_by('year', 'DESC');
        return $this->db->get('staff_publications')->result();
    }

    public function get_research($staff_id)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->order_by('research_date', 'DESC');
        return $this->db->get('staff_research')->result();
    }

    public function get_community_service($staff_id)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->order_by('service_date', 'DESC');
        return $this->db->get('staff_community_service')->result();
    }

    public function update_profile($staff_id, $data)
    {
        $this->db->where('id', $staff_id);
        return $this->db->update('staff', $data);
    }

    public function save_grant($staff_id, $data, $grant_id = null)
    {
        $data['staff_id'] = $staff_id;
        if ($grant_id) {
            $this->db->where('id', $grant_id);
            $this->db->where('staff_id', $staff_id);
            return $this->db->update('staff_grants', $data);
        }
        return $this->db->insert('staff_grants', $data);
    }

    public function save_publication($staff_id, $data, $pub_id = null)
    {
        $data['staff_id'] = $staff_id;
        if ($pub_id) {
            $this->db->where('id', $pub_id);
            $this->db->where('staff_id', $staff_id);
            return $this->db->update('staff_publications', $data);
        }
        return $this->db->insert('staff_publications', $data);
    }

    public function save_research($staff_id, $data, $research_id = null)
    {
        $data['staff_id'] = $staff_id;
        if ($research_id) {
            $this->db->where('id', $research_id);
            $this->db->where('staff_id', $staff_id);
            return $this->db->update('staff_research', $data);
        }
        return $this->db->insert('staff_research', $data);
    }

    public function save_community_service($staff_id, $data, $cs_id = null)
    {
        $data['staff_id'] = $staff_id;
        if ($cs_id) {
            $this->db->where('id', $cs_id);
            $this->db->where('staff_id', $staff_id);
            return $this->db->update('staff_community_service', $data);
        }
        return $this->db->insert('staff_community_service', $data);
    }

    public function delete_grant($id, $staff_id)
    {
        $this->db->where('id', $id)->where('staff_id', $staff_id);
        return $this->db->delete('staff_grants');
    }

    public function delete_publication($id, $staff_id)
    {
        $this->db->where('id', $id)->where('staff_id', $staff_id);
        return $this->db->delete('staff_publications');
    }

    public function delete_research($id, $staff_id)
    {
        $this->db->where('id', $id)->where('staff_id', $staff_id);
        return $this->db->delete('staff_research');
    }

    public function delete_community_service($id, $staff_id)
    {
        $this->db->where('id', $id)->where('staff_id', $staff_id);
        return $this->db->delete('staff_community_service');
    }

    public function count_all()
    {
        return $this->db->count_all('staff');
    }
}
