<?php

	class Siswa extends CI_Controller
	{
		private $filename = "import_data"; // nama file .csv
		
		function __construct() 
		{
			parent::__construct();
			//checkAksesModule();
			$this->load->library('ssp');
			$this->load->model('model_siswa');
		}

		function loadDataSiswa()
		{
			$kelas 	= $_GET['kd_kelas'];

			echo "<table class='table table-striped table-bordered table-hover table-full-width dataTable'>
					<tr>
						<th width=100 class='text-center'>FOTO</th>
						<th class='text-center'>NIS</th>
						<th class='text-center'>NAMA</th>
						<th class='text-center'>TEMPAT LAHIR</th>
						<th class='text-center'>TANGGAL LAHIR</th>
						<th class='text-center'>AKSI</th>
					</tr>";

			$this->db->where('kd_kelas', $kelas);
			$siswa = $this->db->get('tbl_siswa');
			foreach ($siswa->result() as $row) {
				echo "<tr>
						<td class='text-center'> <img width='85px' src='".base_url()."/uploads/".$row->foto."'></td>
						<td>$row->nim</td>
						<td>$row->nama</td>
						<td>$row->tempat_lahir</td>
						<td>$row->tanggal_lahir</td>
						<td class='text-center'>
						".anchor('siswa/edit/'.$row->nim, '<i class="fa fa-edit"></i>', 'class="btn btn-xs btn-primary" data-placement="top" title="Edit"')."
						".anchor('siswa/delete/'.$row->nim, '<i class="fa fa-times fa fa-white"></i>', 'class="btn btn-xs btn-danger" data-placement="top" title="Delete"')."
						</tr>";
			}
			echo "</table>";
		}

		function loadDataSiswaGuru()
		{
			$kelas 	= $_GET['kd_kelas'];

			echo "<table class='table table-striped table-bordered table-hover table-full-width dataTable'>
					<tr>
						<th width=100 class='text-center'>FOTO</th>
						<th class='text-center'>NIS</th>
						<th class='text-center'>NAMA</th>
						<th class='text-center'>TANGGAL LAHIR</th>
					</tr>";

			$this->db->where('kd_kelas', $kelas);
			$siswa = $this->db->get('tbl_siswa');
			foreach ($siswa->result() as $row) {
				echo "<tr>
						<td class='text-center'> <img width='85px' src='".base_url()."/uploads/".$row->foto."'></td>
						<td class='text-center'>$row->nim</td>
						<td>$row->nama</td>
						<td class='text-center'>$row->tanggal_lahir</td>
						</tr>";
			}
			echo "</table>";
		}

		function index()
		{
			$this->template->load('template', 'siswa/view');
		}

		function add()
		{
			if (isset($_POST['submit'])) {
				$uploadFoto = $this->upload_foto_siswa();
				$this->model_siswa->save($uploadFoto);
				redirect('siswa');
			} else {
				$this->template->load('template', 'siswa/add');
			}
		}

		function edit()
		{
			if (isset($_POST['submit'])) {
				$uploadFoto = $this->upload_foto_siswa();
				$this->model_siswa->update($uploadFoto);
				redirect('siswa');
			} else {
				$nim           = $this->uri->segment(3);
				$data['siswa'] = $this->db->get_where('tbl_siswa', array('nim' => $nim))->row_array();
				$this->template->load('template', 'siswa/edit', $data);
			}
		}

		function delete()
		{
			$nim = $this->uri->segment(3);
			if (!empty($nim)) {
				$this->db->where('nim', $nim);
				$this->db->delete('tbl_siswa');
			} 
			redirect('siswa');
		}

		function upload_foto_siswa()
		{
			//validasi foto yang di upload
			$config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 1024;
            $this->load->library('upload', $config);

            //proses upload
            $this->upload->do_upload('userfile');
            $upload = $this->upload->data();
            return $upload['file_name'];
		}

		// siswa_aktif() -> untuk menampilkan view peserta didik ->terletak di controller Siswa
		// combobox_kelas() -> untuk menampilkan data kelas sesuai jurusan yang dipilih -> terletak di controller Kelas
		// loadDataSiswa() -> untuk menampilkan data siswa nim dan nama sesuai kode_kelas yang dipilih di filter, lalu ditampilkan ke div id = kelas yang bedada di view/siswa_aktif -> terletak di controller Siswa
		function siswa_aktif()
		{
			$this->template->load('template', 'siswa/siswa_aktif');
		}



		function nilai_siswa()
		{
			$nim 					= $this->uri->segment(3);
			$sql 					= "SELECT ts.nama, tm.nama_mapel, tn.nilai
									  FROM tbl_nilai AS tn, tbl_jadwal AS tj, tbl_mapel AS tm, tbl_siswa AS ts
									  WHERE tn.id_jadwal = tj.id_jadwal AND tj.kd_mapel = tm.kd_mapel AND tn.nim = ts.nim AND tn.nim = '$nim'";
			$data['nilai_siswa'] 	= $this->db->query($sql);
			$this->template->load('template', 'siswa/nilai', $data);
		}

	}

?>