<?
require_once('pmailer/class.phpmailer.php');

$bodytext = "This is test message.";

$email = new PHPMailer();
$email->From      = 'contact@jobs972.com';
$email->FromName  = 'Jobs972.com';
$email->Subject   = 'Test Email With Attachment';
$email->Body      = $bodytext;
$email->AddAddress( 'quadro13@yandex.ru' );

$email->AddAttachment($_SERVER['DOCUMENT_ROOT']."/app_data/resumes/r1.docx");

return $email->Send();

?>