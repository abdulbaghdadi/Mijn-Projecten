<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $message = $_POST["message"];

  $to = "abdulrhmanbaghdadi@gmail.com";
  $subject = "New Contact Form Submission";
  $body = "Name: $name\nEmail: $email\n\n$message";

  if (mail($to, $subject, $body)) {
    echo "Bedankt voor je bericht!";
  } else {
    echo "probeer nog een keer later!";
  }
}
?>
