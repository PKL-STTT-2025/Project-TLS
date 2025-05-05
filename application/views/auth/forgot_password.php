<?php $this->load->view('templates/auth_header'); ?>

<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <!-- LOGO -->
                                    <img src="<?= base_url('assets/img/logo.jpg'); ?>" width="100" class="mb-4">
                                    <h1 class="h4 text-gray-900 mb-2 font-weight-bold">Forgot Your Password?</h1>
                                    <p class="mb-4">Masukkan NIK kamu untuk reset password akunmu.</p>
                                </div>

                                <?= $this->session->flashdata('message'); ?>

                                <form action="<?= site_url('auth/forgotpassword'); ?>" method="POST" class="user">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-id-card"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control form-control-user" id="nik" name="nik" placeholder="Enter your NIK...">
                                        </div>
                                        <?= form_error('nik', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Reset Password
                                    </button>
                                </form>

                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth'); ?>">← Back to Login</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->load->view('templates/auth_footer'); ?>