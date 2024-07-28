<?php
if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $human = intval($_POST['human']);
    $from = $email;

    // WARNING: Be sure to change this. This is the address that the email will be sent to
    $to = 'mentenstuurbusiness@gmail.com';

    $subject = "Message from " . $name . " ";

    $body = "From: $name\n E-Mail: $email\n Message:\n $message";

    // Check if name has been entered
    if (!$_POST['name']) {
        $errName = 'Please enter your name';
    }

    // Check if email has been entered and is valid
    if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errEmail = 'Please enter a valid email address';
    }

    // Check if message has been entered
    if (!$_POST['message']) {
        $errMessage = 'Please enter your message';
    }

    // Check if simple anti-bot test is correct
    if ($human !== 5) {
        $errHuman = 'Your anti-spam is incorrect';
    }

    // If there are no errors, send the email
    if (!$errName && !$errEmail && !$errMessage && !$errHuman) {
        $receiving_email_address = 'mentenstuurbusiness@gmail.com';

        // Assuming PHP_Email_Form class is already included in the script
        $contact = new PHP_Email_Form;
        $contact->ajax = true;

        $contact->to = $receiving_email_address;
        $contact->from_name = $name;
        $contact->from_email = $email;
        $contact->subject = $subject;

        $contact->smtp = array(
            'host' => 'example.com',
            'username' => 'example',
            'password' => 'pass',
            'port' => '587'
        );

        $contact->add_message($name, 'From');
        $contact->add_message($email, 'Email');
        $contact->add_message($message, 'Message', 10);

        if ($contact->send()) {
            $result = '<div class="alert alert-success">Thank You! I will be in touch</div>';
        } else {
            $result = '<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later</div>';
        }
    }
}
?>