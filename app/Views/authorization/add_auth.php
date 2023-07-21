
<div class="col-6 position-relative">
    <form action="" id="formAddAuth">

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="status" placeholder="status" required>
            <label for="status">Status</label>
        </div>

        <div class="checkbox-access mb-3">

            <div class="row g-2">

                <?php

                if (!isset($data) || empty($data)) {
                    echo '<h1>Akses kosong, Silahkan tambah akses baru</h1>';
                    return;
                }

                foreach ($data as $access) {
                    echo "
                <div class='col-sm-4'>
                    <div class='input-group'>
                        <div class='input-group-text'>
                            <input class='form-check-input mt-0' id='{$access["id"]}' type='checkbox' value=''
                                   aria-label='Checkbox for following text input'>
                        </div>
                        <input type='text' class='form-control' value='{$access["status"]}' disabled>
                    </div>
                </div>
                ";
                }


                ?>


            </div>


        </div>


        <button type="submit" id="btnSaveAuth" class="btn btn-primary position-absolute end-0">
            Simpan
        </button>

    </form>
</div>

<script src="public/js/add_auth.js"></script>