<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Carbon::setLocale('ru_RU');

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Подтверждение вашей почты') // Кастомный заголовок
                ->greeting('Здравствуйте!') // Приветствие
                ->line('Спасибо за регистрацию! Пожалуйста, подтвердите ваш email, нажав на кнопку ниже.') // Основной текст
                ->action('Подтвердить Email', $url) // Кнопка
                ->line('Если вы не регистрировались, просто проигнорируйте это письмо.')
                ->salutation('С уважением, команда вашего приложения'); // Завершение письма
        });
    }
}
