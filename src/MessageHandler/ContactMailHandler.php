<?php 

namespace App\MessageHandler;

use App\Message\ContactMail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

#[AsMessageHandler]
class ContactMailHandler 
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(ContactMail $mailContent)
    {
        $contentArray = $mailContent->getContent();

        $email = (new TemplatedEmail())
        ->from('a.barbier@studio-okai.com')
        ->to('hello@studio-okai.com')
        ->subject('Nouvelle demande de contact [Cabinet Okaï]')
        ->htmlTemplate('mail/contact_mail.html.twig')
        ->context([
            'mail' => $contentArray["mail"],
            'name' => $contentArray["name"],
            "lastname" => $contentArray["lastname"],
            "phone" => $contentArray["phone"],
            "message" => $contentArray["message"]
        ]);

        try {
            $this->mailer->send($email);

        } catch (TransportExceptionInterface $e) {
            // some error prevented the email sending; display an
            // error message or try to resend the message
        }
    }
}