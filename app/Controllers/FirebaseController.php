<?php

namespace NextG\RwAdminApp\Controllers;

use NextG\RwAdminApp\App\View;

class FirebaseController
{
    public function crashlyticView()
    {
        View::render('layouts/app', 'firebase/crashlytic');
    }
}
