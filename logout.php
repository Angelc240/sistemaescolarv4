<?php
    require_once 'functions.php';

    echo'

    <title>logout</title>

    </head>

    <body>';
    if (isset($_SESSION['user']))
    {
        destroySession();
    }

    echo'

        <p class="mt-6 is-size-4 has-text-centered">Usted ha cerrado sesió <a href="login.php">click aquí</a> para ir al login</p>

    </body>

    </html>
    ';

?>
