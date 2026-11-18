<?php
$name = $email = $subject = $message = $error = '';
$notice = $_SESSION['contact_notice'] ?? '';
unset($_SESSION['contact_notice']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    $name = post('name');
    $email = post('email');
    $subject = post('subject');
    $message = post('message');
    if (!limitRequest($db, 'contact', 5, 600)) $error = 'Too many attempts. Try again in 10 minutes.';
    elseif (post('website') !== '') $error = 'Unable to submit this message.';
    elseif (strlen($name) < 2 || strlen($name) > 120 || strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL) || $subject === '' || strlen($subject) > 200 || strlen($message) < 10 || strlen($message) > 5000) $error = 'Please enter a valid name, email, subject and message (10–5000 characters).';
    else {
        run($db, 'INSERT INTO messages (name,email,subject,message) VALUES (?,?,?,?)', [$name,$email,$subject,$message]);
        $_SESSION['contact_notice'] = 'Message saved successfully.';
        go('contact.php');
    }
}
