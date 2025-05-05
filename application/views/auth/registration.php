    <div class="container">

        <div class="row justify-content-center">
            <div class="card o-hidden border-0 shadow-lg my-5 col-lg-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <img src="<?= base_url('assets/img/logo.jpg'); ?>" width="100" class="mb-4">
                                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                </div>
                                <form class="user" method="post" action="<?= base_url('auth/registration'); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="name"
                                            placeholder="Full Name" value="<?= set_value('name'); ?>">
                                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="nik"
                                            placeholder="NIK" value="<?= set_value('nik'); ?>">
                                        <?= form_error('NIK', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <select name="role_id" class="form-control">
                                            <option value="" disabled selected>-- Pilih Role --</option>
                                            <option value="Admin" <?= set_select('role_id', 'Admin'); ?>>Admin</option>
                                            <option value="Supervisor" <?= set_select('role_id', 'Supervisor'); ?>>Supervisor</option>
                                            <option value="QCInline" <?= set_select('role_id', 'QCInline'); ?>>QC Inline</option>
                                        </select>
                                        <?= form_error('role_id', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" name="password1"
                                                placeholder="Password" value="<?= set_value('password1'); ?>">
                                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" name="password2"
                                                placeholder="Repeat Password" value="<?= set_value('password2'); ?>">
                                            <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Register Account
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= site_url('forgot_password'); ?>">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth'); ?>">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>