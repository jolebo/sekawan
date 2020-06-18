<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index(){
		$this->load->view('home');
	}

	public function fetch(){
		if($this->input->is_ajax_request()){
			$json = file_get_contents('http://static.sekawanmedia.co.id/data.json');
			$data = json_decode($json);

			if(!empty($data->status) && $data->status == true){
				$this->output->set_content_type('application/json')->set_output(json_encode($data->data));
			}
			else{
				show_error('Remote server not respond');
			}
		}
		else{
			show_404();
		}
	}

	public function save(){
		if($this->input->is_ajax_request()){
			$data = $this->input->post('data');

			$this->db
				->where_in('id_peg', array_column($data, 'id'))
				->delete('pegawai');

			$datainsert = array();
			foreach($data as $item){
				$datainsert[] = array(
					'id_peg' => $item['id'],
					'nama_pegawai' => $item['employee_name'],
					'gaji' => $item['employee_salary'],
					'usia' => $item['employee_age'],
					'foto' => $item['profile_image']
				);
			}

			$this->db->insert_batch('pegawai', $datainsert);

			$this->output->set_content_type('application/json')->set_output(json_encode(array(
				'status' => true,
				'message' => count($datainsert).' data tersimpan'
			)));
		}
		else{
			show_404();
		}
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */