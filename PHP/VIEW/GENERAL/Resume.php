<?php
header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=resume.pdf");
readfile("./PDF/Resume.pdf");
exit;
