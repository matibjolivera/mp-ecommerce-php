<?php

file_put_contents("php://stderr", json_encode($_POST) . "\n");

http_response_code(200);