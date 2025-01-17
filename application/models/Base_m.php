<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Base_m extends CI_Model
{

    public function all($table, $order_by = null, $direction = 'DESC')
    {
        if ($order_by) {
            $this->db->order_by($order_by, $direction);
        }
        return $this->db->get($table)->result();
    }

    public function find($table, $id)
    {
        return $this->db->get_where($table, ['id' => $id])->row();
    }

    public function find_where($table, $where)
    {
        return $this->db->get_where($table, $where)->row();
    }

    // Product
    public function get_all_where($table, $where)
    {
        return $this->db->get_where($table, $where)->result();
    }

    public function all_product()
    {
        $this->db->select('product.*, category.name as category');
        $this->db->from('product');
        $this->db->join('category', 'category.id=product.category_id');
        return $this->db->get()->result();
    }

    public function create($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function update($table, $data, $id)
    {
        //
        return $this->db->update($table, $data, ['id' => $id]);
    }

    public function delete($table, $id)
    {
        return $this->db->delete($table, ['id' => $id]);
    }

}
