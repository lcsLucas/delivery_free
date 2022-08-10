<?php

include './src/autoload.php';

// Register API keys at https://www.google.com/recaptcha/admin
$siteKey = '6LdJdw8TAAAAAHPQqjw4RKewTptAHJoIMZcncIhd';
$secret = '6LdJdw8TAAAAAOodkxEMuslkLsyccS74O2g7407u';

// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
$lang = 'pt-br';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>reCAPTCHA Example</title>
        <link rel="shortcut icon" href="//www.gstatic.com/recaptcha/admin/favicon.ico" type="image/x-icon"/>
        <style type="text/css">
            body {
                margin: 1em 5em 0 5em;
                font-family: sans-serif;
            }
            fieldset {
                display: inline;
                padding: 1em;
            }
        </style>
    </head>
    <body>
        <h1>reCAPTCHA Example</h1>
        <?php if ($siteKey === '' || $secret === ''): ?>
            <h2>Add your keys</h2>
            <p>If you do not have keys already then visit <tt>
            <a href = "https://www.google.com/recaptcha/admin">
                https://www.google.com/recaptcha/admin</a></tt> to generate them.
        Edit this file and set the respective keys in <tt>$siteKey</tt> and
        <tt>$secret</tt>. Reload the page after this.</p>
    <?php
elseif (isset($_POST['g-recaptcha-response'])):
    // The POST data here is unfiltered because this is an example.
    // In production, *always* sanitise and validate your input'
    ?>
    <h2><tt>POST</tt> data</h2>
    <tt><pre><?php var_export($_POST); ?></pre></tt>
    <?php
// If the form submission includes the "g-captcha-response" field
// Create an instance of the service using your secret
    $recaptcha = new \ReCaptcha\ReCaptcha($secret);

// If file_get_contents() is locked down on your PHP installation to disallow
// its use with URLs, then you can use the alternative request method instead.
// This makes use of fsockopen() instead.
//  $recaptcha = new \ReCaptcha\ReCaptcha($secret, new \ReCaptcha\RequestMethod\SocketPost());

// Make the call to verify the response and also pass the user's IP address
    $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

    if ($resp->isSuccess()):
// If the response is a success, that's it!
        ?>
        <h2>Success!</h2>
        <p>That's it. Everything is working. Go integrate this into your real project.</p>
        <p><a href="/">Try again</a></p>
        <?php
    else:
// If it's not successful, then one or more error codes will be returned.
        ?>
        <h2>Something went wrong</h2>
        <p>The following error was returned: <?php
            foreach ($resp->getErrorCodes() as $code) {
                echo '<tt>' , $code , '</tt> ';
            }
            ?></p>
        <p>Check the error code reference at <tt><a href="https://developers.google.com/recaptcha/docs/verify#error-code-reference">https://developers.google.com/recaptcha/docs/verify#error-code-reference</a></tt>.
        <p><strong>Note:</strong> Error code <tt>missing-input-response</tt> may mean the user just didn't complete the reCAPTCHA.</p>
        <p><a href="/">Try again</a></p>
    <?php
    endif;
else:
// Add the g-recaptcha tag to the form you want to include the reCAPTCHA element
    ?>
    <p>Complete the reCAPTCHA then submit the form.</p>
    <form action="/" method="post">
        <fieldset>
            <legend>An example form</legend>
            <p>Example input A: <input type="text" name="ex-a" value="foo"></p>
            <p>Example input B: <input type="text" name="ex-b" value="bar"></p>

            <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
            <script type="text/javascript"
                    src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>">
            </script>
            <p><input type="submit" value="Submit" /></p>
        </fieldset>
    </form>
<?php endif; ?>
</body>
</html>
