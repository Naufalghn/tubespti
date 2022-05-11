<?php

class Poin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //checkAksesModule();

    }

    function index()
    {
        $id = $this->input->get('id');
        $siswa = $this->db->get_where('tbl_siswa', ['nim' => $id])->row();
        $poin = $this->db->get_where('poin', ['siswa_id' => $id])->result();
        $total_poin = $this->db->query('SELECT SUM(poin) as total_poin FROM poin where siswa_id="' . $id . '"')->row()->total_poin ?? 0;
        $this->template->load('template', 'poin/view', ['siswa' => $siswa, 'poin' => $poin, 'total_poin' => $total_poin]);
    }
    function addpoin()
    {
        $id = $this->input->post('siswa_id');
        // $siswa = $this->db->get_where('tbl_siswa', ['nim' => $id])->row();

        $data = array(
            'poin' => $this->input->post('poin'),
            'deskripsi' => $this->input->post('deskripsi'),
            'siswa_id' => $id,
            'tanggal' => $this->input->post('tanggal'),
        );
        $this->db->insert('poin', $data);


        $this->load->library('user_agent');
        redirect($this->agent->referrer());
    }
    function hapus($id)
    {
        // $id = $this->input->get('id');
        $this->db->delete('poin', ['id' => $id]);

        $this->load->library('user_agent');
        redirect($this->agent->referrer());
    }
}
