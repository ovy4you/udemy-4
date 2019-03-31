<?php
/**
 * Created by PhpStorm.
 * User: ovy_4
 * Date: 3/16/2019
 * Time: 6:53 PM
 */

namespace App\Service;


use Psr\Log\LoggerInterface;

class Greeting
{
    /**
     * @var LoggerInterface
     */
    private $log;
    /**
     * @var string
     */
    private $message;

    public function __construct(LoggerInterface $log,string $message)
    {
        $this->log = $log;
        $this->message = $message;
    }

    public function greet(string $name): string
    {
        $this->log->info($name);
        return $this->message.$name;
    }

}