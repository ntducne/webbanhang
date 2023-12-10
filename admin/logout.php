<?php

include "../config/session.php";
Session::checkSession();
session_destroy();

