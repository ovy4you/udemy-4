<?php

namespace App\Twig;

use App\Service\MarkdownHelper;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
{
    private $container;
    /**
     * @var string
     */
    private $locale;

    public function __construct(ContainerInterface $container,string $locale)
    {
        $this->container = $container;
        $this->locale = $locale;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('cached_markdown', [$this, 'processMarkdown'], ['is_safe' => ['html']]),
            new TwigFilter('price', [$this, 'priceFilter'], ['is_safe' => ['html']]),
        ];
    }

    public function processMarkdown($value)
    {
        return $this->container
            ->get(MarkdownHelper::class)
            ->parse($value);
    }

    public function priceFilter($value)
    {
        return '$'.number_format($value,2,'.',',');
    }

    public function getGlobals(){
        return ['locale'=>$this->locale];
    }
    public static function getSubscribedServices()
    {
        return [
            MarkdownHelper::class,
        ];
    }
}
