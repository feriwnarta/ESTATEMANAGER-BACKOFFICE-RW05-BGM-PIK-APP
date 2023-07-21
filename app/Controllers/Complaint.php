<?php

namespace NextG\RwAdminApp\Controllers;

use NextG\RwAdminApp\App\View;

class Complaint
{

    public function complaintView() {

        View::render('layouts/app', 'complaint/complaint');
    }

}