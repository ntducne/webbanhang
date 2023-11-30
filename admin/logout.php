<?php

include "../config/session.php";
Session::checkSession();
Session::destroy();

