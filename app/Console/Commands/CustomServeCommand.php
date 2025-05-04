<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;
use Illuminate\Support\Carbon;
use Illuminate\Support\Stringable;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Env;
use function Termwind\terminal;

class CustomServeCommand extends BaseServeCommand
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $name = 'serve';

    /**
     * Resolve o erro de extração de porta
     */
    public static function getRequestPortFromLine($line)
    {
        if (preg_match('/:(\d+)\s/', $line, $matches)) {
            return (int) $matches[1];
        }

        throw new \InvalidArgumentException("Failed to extract the request port: {$line}");
    }

    /**
     * Resolve o erro "Undefined array key 0"
     */
    protected function flushOutputBuffer()
    {
        $lines = (new Stringable($this->outputBuffer))->explode("\n");

        $this->outputBuffer = (string) $lines->pop();

        $lines->map(fn ($line) => trim($line))
            ->filter()
            ->each(function ($line) {
                $stringable = new Stringable($line);

                if ($stringable->contains('Development Server (http')) {
                    if ($this->serverRunningHasBeenDisplayed === false) {
                        $this->serverRunningHasBeenDisplayed = true;

                        $this->components->info("Server running on [http://{$this->host()}:{$this->port()}].");
                        $this->comment('  <fg=yellow;options=bold>Press Ctrl+C to stop the server</>');

                        $this->newLine();
                    }

                    return;
                }

                $requestPort = static::getRequestPortFromLine($line);

                if ($stringable->contains(' Accepted')) {
                    $this->requestsPool[$requestPort] = [
                        $this->getDateFromLine($line),
                        $this->requestsPool[$requestPort][1] ?? false,
                        microtime(true),
                    ];
                } elseif ($stringable->contains([' [200]: GET '])) {
                    $this->requestsPool[$requestPort][1] = trim(explode('[200]: GET', $line)[1]);
                } elseif ($stringable->contains('URI:')) {
                    $this->requestsPool[$requestPort][1] = trim(explode('URI: ', $line)[1]);
                } elseif ($stringable->contains('Closing')) {
                    $requestPort = static::getRequestPortFromLine($line);

                    // Correção do erro "Undefined array key"
                    if (!isset($this->requestsPool[$requestPort]) || count($this->requestsPool[$requestPort]) < 3) {
                        $this->requestsPool[$requestPort] = [
                            $this->getDateFromLine($line),
                            false,
                            microtime(true),
                        ];
                    }

                    [$startDate, $file, $startMicrotime] = $this->requestsPool[$requestPort];

                    $formattedStartedAt = $startDate->format('Y-m-d H:i:s');

                    unset($this->requestsPool[$requestPort]);

                    [$date, $time] = explode(' ', $formattedStartedAt);

                    $this->output->write("  <fg=gray>$date</> $time");

                    $runTime = $this->runTimeForHumans($startMicrotime);

                    if ($file) {
                        $this->output->write($file = " $file");
                    }

                    $dots = max(
                        terminal()->width() - 
                        mb_strlen($formattedStartedAt) - 
                        mb_strlen($file ?? '') - 
                        mb_strlen($runTime) - 
                        9, 
                        0
                    );

                    $this->output->write(' '.str_repeat('<fg=gray>.</>', $dots));
                    $this->output->writeln(" <fg=gray>~ {$runTime}</>");
                } elseif ($stringable->contains(['Closed without sending a request', 'Failed to poll event'])) {
                    // Ignora essas linhas
                } elseif (!empty($line)) {
                    if ($stringable->startsWith('[')) {
                        $line = $stringable->after('] ');
                    }

                    $this->output->writeln("  <fg=gray>$line</>");
                }
            });
    }

    /**
     * Configura as opções do comando
     */
    protected function getOptions()
    {
        return [
            ['host', null, InputOption::VALUE_OPTIONAL, 'The host address to serve the application on', Env::get('SERVER_HOST', '127.0.0.1')],
            ['port', null, InputOption::VALUE_OPTIONAL, 'The port to serve the application on', Env::get('SERVER_PORT')],
            ['tries', null, InputOption::VALUE_OPTIONAL, 'The max number of ports to attempt to serve from', 10],
            ['no-reload', null, InputOption::VALUE_NONE, 'Do not reload the development server on .env file changes'],
        ];
    }
}