<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JournalistResetPassword extends Notification
{
    use Queueable;

    /**
     * URL complète de réinitialisation.
     */
    protected string $resetUrl;

    /**
     * Crée une nouvelle notification.
     */
    public function __construct(string $resetUrl)
    {
        $this->resetUrl = $resetUrl;
    }

    /**
     * Canaux utilisés pour la notification.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Notification par email.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Réinitialisation de votre mot de passe - YAA'Scientia")
            ->greeting('Bonjour ' . trim(($notifiable->prenom ?? '') . ' ' . ($notifiable->nom ?? '')) . ',')
            ->line('Vous avez demandé la réinitialisation du mot de passe de votre compte journaliste YAA\'Scientia.')
            ->line('Cliquez sur le bouton ci-dessous pour définir un nouveau mot de passe.')
            ->action('Réinitialiser mon mot de passe', $this->resetUrl)
            ->line('Ce lien est valable pendant 60 minutes.')
            ->line('Si vous n\'êtes pas à l\'origine de cette demande, vous pouvez ignorer cet email.');
    }
}
