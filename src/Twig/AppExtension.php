<?php

namespace App\Twig;

use App\Entity\Event;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extra\Intl\IntlExtension;

class AppExtension extends AbstractExtension
{
    private $intlExtension;
    private $router;

    public function __construct(IntlExtension $intlExtension, RouterInterface $router)
    {
        $this->intlExtension = $intlExtension;
        $this->router = $router;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('datetime', [$this, 'formatDateTime']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_price', [$this, 'formatPrice'], ['is_safe' => ['html']]),

            new TwigFunction('pluralize', [$this, 'pluralize']),

            new TwigFunction('register_link_or_sold_out', [$this, 'registerLinkOrSoldOut'], ['is_safe' => ['html']])];
    }

    public function formatPrice(Event $event): string
    {
        return $event->isFree()
            ? '<span class="badge badge-primary">Free</span>'
            : $this->intlExtension->formatCurrency($event->getPrice(), 'USD');
    }

    public function formatDateTime(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format('F d, Y \\a\\t H:i A');

    }

    public function pluralize(int $count, string $singular, ?string $plural = null): string
    {
        $plural = $plural ?? $singular . 's';

        $string = $count == 1 ? $singular : $plural;

        return "$count $string";
    }

    public function registerLinkOrSoldOut(Event $event): string
    {
        if ($event->isSoldOut()) {
            return '<h3><span class="badge badge-warning text-uppercase">Sold out !</span></h3>';
        } else {
            return sprintf(
                '<p><a href="%s" class="text-uppercase btn btn-primary">Register</a></p>',
                $this->router->generate('events_registrations_create', ['event' => $event->getId()]));
        }
    }
}
