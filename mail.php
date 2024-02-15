<?php
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $spam_check = trim($_POST["position"]);

        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $subject = trim($_POST["subject"]);
        $message = trim($_POST["message"]);
        if($spam_check == ""){
        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($subject) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // Note:  Update this to your desired email address.
        $recipient = "info@lambdatheta.com";

        // Set the email subject.
        $subjectname = "New Contact $subject";

        // Build the email content.
        $email_content = "Name: $name  \r\n\n";
        $email_content .= "Email: $email \r\n\n";
        $email_content .= "Subject: $subject \r\n\n";
        $email_content .= "Message: $message \r\n\n";

        // Build the email headers.
        $email_headers = "Contact us by $name <$email>";

        ini_set("SMTP", "lambdatheta.com");
    ini_set("smtp_port", 25); // Adjust the port as needed
    ini_set("sendmail_from", "info@lambdatheta.com");

        // Send the email.
        if (mail($recipient, $email_headers,$email_content, )) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            ?>
            <script>
                alert("Thank You! Your message has been sent.");
                window.history.back();
            </script>
            <?php
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            ?>
            <script>
            alert( "Oops! Something went wrong and we couldn't send your message.");

window.history.back();
            </script>
            <?php
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        ?>
            <script>
        alert( "There was a problem with your submission, please try again.");

                window.history.back();
            </script>
        <?php
    }
    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        ?>
            <script>
        alert( "There was a problem with your submission, please try again.");

                window.history.back();
            </script>
        <?php
    }


?>