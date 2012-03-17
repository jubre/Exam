<?php

$notifier = new Sismo\Notifier\DBusNotifier();

// add a project with custom settings
$sf2 = new Sismo\Project('exam');
$sf2->setRepository('/home/cordoval/sites-2/exam');
$sf2->setBranch('master');

// phpspec command
$phpspecCommand = '/home/cordoval/sites-2/exam/phpspec-composer.php';
$phpspecFolder = '/home/cordoval/sites-2/exam/lib/PHPPeru/Exam/Spec';
//$longCommand = 'find ' . $phpspecFolder . '*.php -exec ' . $phpspecCommand . ' \'{}\' -f documentation --color \\;';
//$longCommand = 'composer install;'. $phpspecCommand . ' ' . $phpspecFolder . ' -f documentation --color';
$longCommand = 'composer install; ./develop';

// sets command, slug, commit links and notifier
$sf2->setCommand($longCommand);
$sf2->setSlug('exam');
$sf2->setUrlPattern('http://localhost:8000/?p=.git;a=commitdiff;h=%commit%');
$sf2->addNotifier($notifier);

$subject = '[%status_code%] %name% (%short_sha%)';
$message = <<<MESSAGE
  Build status changed to %STATUS%.

    commit: %sha%
    Author: %author%

    %message%

    Sismo reports:

    %output%
MESSAGE;

$emailNotifier = new Sismo\Notifier\MailNotifier('cordoval@gmail.com', $subject, $message);
$sf2->addNotifier($emailNotifier);

return $sf2;

