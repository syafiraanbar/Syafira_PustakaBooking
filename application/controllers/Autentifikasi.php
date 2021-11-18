<?php

class Autentifikasi extreds CI-Controller
{

    public function index()
    {
        //jika statusnya sudah login, maka tidak bisa mengakses halaman login alias dikembalikan ke tampilan user
        if($this->sessioin->userdata('email')){
            redirect('user');
    }
    $this->form_validation->set_rules('email', 'Alamat Email','required|trim|valid_email', [
                'required' => 'Email Harus Diisi!!',
                'vaild_email' => 'Email Tidak Benar!!'
    ]);
    if ($this->form_validation->run() == false) {

                $data['judul'] = 'Login';
                $data['user'] = ' ';
                //kata 'login' merupakan nilai dari variabel judul dalam array $data dikirimkan ke view aute_header
                $this->load->view('templates/aute_header', $data);
                $this->load->view('autentifikasi/login');
                $this->load->view('templates/aute_footer');
        } else {
            $this->_login();
        }
    }
private function_login()
    {
        $email = htmlspecialchars($this->input->post('email',true));
        $password = $this->input->post('password', true);
        $user = $this->ModelUser->cekData(['email' => $email])->row_array();

                //jika usernya ada
                if ($user) {
                    //jika sudah aktif
                if ($user['is_active'] == 1) {
                    //cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' =>$user['role_id']
                    ];                
				 $this->session->set_userdata($data)
				 
				 if ($user['role_id'] == 1) {
					 redirect('admin');
				 } else{
					 if ($user['image'] == 'default.jpg') {
						 $this->session->set_flashdata('pesan','<div class="alert-info alert-message" role="alert">silahkan
						 ubah profile anda untuk ubah photo profile</div'>;
					 }
					           redirect('user');
				 }
				 } else {
					 $this->session->set_flasdata('pesan','<div class="alert-danger aletrt-messsge" role="alert">password
					 salah!!</div>);
				 }
					          redirect('autifikasi')
				 }
				 } else {
					 $this->session->set_flasdata('pesan','<div class="alert-danger aletrt-messsge" role="alert">User belum
					 diaktifasi!!</div>);
					           redirect('autifikasi')
				 }
				 } else {
					 $this->session->set_flasdata('pesan','<div class="alert-danger aletrt-messsge" role="alert">Email tidak
					 terdaftar!!</div>);
					 redirect('autifikasi')
				 }
		}
}