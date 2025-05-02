<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_DB $db
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 */
class Auth extends CI_Controller
{
    public function index()
    {
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required|callback_valid_nik');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {

            $data['title'] = 'TLS QC Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {

            $this->_login();
        }
    }

    private function _login()
    {
        $nik = $this->input->post('nik');
        $password = $this->input->post('password');

        $user = $this->db->get_where('master_user', ['nik' => $nik])->row_array();

        if ($user) {
            // Cek apakah user aktif
            if ($user['is_active'] == 1) {
                // Cek password
                if (password_verify($password, $user['password'])) {
                    // Password benar, set session
                    $data = [
                        'id_user' => $user['id_user'],
                        'nama' => $user['nama'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);

                    // Redirect berdasarkan role ENUM
                    if ($user['role_id'] === 'Admin') {
                        redirect('admin/dashboard');
                    } elseif ($user['role_id'] === 'Supervisor') {
                        redirect('supervisor/dashboard');
                    } elseif ($user['role_id'] === 'QCInline') {
                        redirect('qcinline/dashboard');
                    } else {
                        // Kalau role_id aneh, logoutkan
                        $this->session->set_flashdata('message', '<div class="alert alert-danger">Role tidak dikenali!</div>');
                        redirect('auth');
                    }
                } else {
                    // Password salah
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Password salah!</div>');
                    redirect('auth');
                }
            } else {
                // User belum aktif
                $this->session->set_flashdata('message', '<div class="alert alert-danger">NIK ini belum aktif. Hubungi admin!</div>');
                redirect('auth');
            }
        } else {
            // NIK tidak ditemukan
            $this->session->set_flashdata('message', '<div class="alert alert-danger">NIK tidak ditemukan!</div>');
            redirect('auth');
        }
    }


    public function registration()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|callback_valid_nik|is_unique[master_user.NIK]', [
            'is_uniqe' => 'This NIK has already registered!'
        ]);
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[5]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'TLS QC Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'nama' => htmlspecialchars($this->input->post('name', true)),
                'nik' => htmlspecialchars($this->input->post('nik', true)),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => htmlspecialchars($this->input->post('role_id', true)),
                'is_active' => 1,
                'date_created' => time(),
                'date_update' => time()
            ];

            $this->db->insert('master_user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulation your account has been created. Please login!</div>');
            redirect('auth');
        }
    }

    public function valid_nik($str)
    {
        if (!is_string($str)) {
            $this->form_validation->set_message('valid_nik', 'NIK tidak valid.');
            return FALSE;
        }

        if (preg_match('/^[0-9]{9}$/', $str)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('valid_nik', 'NIK harus terdiri dari 16 digit angka.');
            return FALSE;
        }
    }

    public function forgotpassword()
    {
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'TLS QC Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot_password');
            $this->load->view('templates/auth_footer');
        } else {
            $nik = $this->input->post('nik');
            $user = $this->db->get_where('master_user', ['nik' => $nik, 'is_active' => 1])->row_array();

            if ($user) {
                $this->session->set_userdata('reset_nik', $user['NIK']);
                $this->session->userdata('reset_nik');
                redirect('auth/reset_password');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIK tidak ditemukan atau belum aktif!</div>');
                redirect('auth/forgotpassword');
            }
        }
    }
    public function reset_password()
    {
        $nik = $this->session->userdata('reset_nik');
        $user = $this->db->get_where('master_user', ['nik' => $nik, 'is_active' => 1])->row_array();

        if (!$this->session->userdata('reset_nik')) {
            redirect('auth/forgotpassword');
        }
        $user = $this->db->get_where('master_user', ['nik' => $nik, 'is_active' => 1])->row_array();
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[5]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Reset Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/reset_password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $nik = $this->session->userdata('reset_nik');

            $this->db->set('password', $password);
            $this->db->where('nik', $nik);
            $this->db->update('master_user');

            $this->session->unset_userdata('reset_nik');
            $this->session->set_flashdata('message', '<div class="alert alert-success">Password berhasil direset! Silakan login.</div>');
            redirect('auth');
        }
    }
}
