<?php require_once __DIR__ . '/header.php' ?>

<div class="wrapper">
    <?php require_once __DIR__ . '/sidebar.php' ?>

    <!-- Page Content  -->
    <div id="content">

        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                    </svg>
                </button>


            </div>
        </nav>

        <div id="wrapper">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <?php
                        if (!empty($yield_view)) {
                            require_once __DIR__ . "/../{$yield_view}.php";
                        }
                        ?>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php' ?>