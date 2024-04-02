<?php

    session_start();

    $BASE_URL = "http://" . "localhost:8080" . dirname($_SERVER["REQUEST_URI"]."?") . "/";
