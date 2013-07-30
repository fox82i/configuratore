<?php

define('EMAIL_FOR_REPORTS', '@email@');
define('RECAPTCHA_PRIVATE_KEY', '@privatekey@');
define('FINISH_URI', '@redirect@');
define('FINISH_ACTION', '@confirm@');
define('FINISH_MESSAGE', '@message@');
define('UPLOAD_ALLOWED_FILE_TYPES', 'doc, docx, xls, csv, txt, rtf, html, zip, jpg, jpeg, png, gif');

require_once '@FILES_PATH@/handler.php';

?>

<link rel="stylesheet" href="@FILES_PATH@/formoid-default.css" type="text/css" />
<? if (frmd_message()): ?>
<span class="alert alert-success"><?=FINISH_MESSAGE;?></span>
<? else: ?>
<!-- Start @APP@ form-->
@HTML@
<p class="frmd"><a href="http://formoid.com/">@KEY@ @ORG@ @VERSION@</a></p>
<!-- Stop @APP@ form-->
<? endif; ?>
