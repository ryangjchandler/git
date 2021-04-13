<?php

namespace RyanChandler\Git;

use RyanChandler\Git\Contracts\Git as GitContract;
use TitasGailius\Terminal\Terminal;

class Git implements GitContract
{
    protected string $root;

    protected string $binary = '/usr/bin/git';

    protected array $author = [
        'name' => null,
        'email' => null,
    ];

    protected array $environment = [];

    public function author(string $name, string $email): GitContract
    {
        $this->author = [
            'name' => $name,
            'email' => $email,
        ];

        return $this;
    }

    public function add($paths, array $options = []): GitContract
    {
        if (! is_array($paths)) {
            $paths = [$paths];
        }

        $command = trim('add '.implode(' ', $paths));
        
        $this->execute($command, $options);

        return $this;
    }

    public function commit(string $message, array $options = []): GitContract
    {
        $command = "commit -m '{$message}'";

        if ($this->author['name'] && $this->author['email']) {
            $options['--author'] = "'{$this->author['name']} <{$this->author['email']}>'";
        }

        $this->execute($command, $options);

        return $this;
    }

    public function environment(array $variables): GitContract
    {
        $this->environment = array_merge($this->environment, $variables);

        return $this;
    }

    public function fetch(array $options = []): GitContract
    {
        $this->execute('fetch', $options);

        return $this;
    }

    public function checkout($paths, array $options = []): GitContract
    {
        if (! is_array($paths)) {
            $paths = [$paths];
        }

        $command = trim('checkout '.implode(' ', $paths));

        $this->execute($command, $options);

        return $this;
    }

    public function push(string $remote = null, string $branch = null, array $options = []): GitContract
    {
        $command = 'push';

        if ($remote) {
            $command .= " {$remote}";
        }

        if ($branch) {
            $command .= " {$branch}";
        }

        $this->execute($command, $options);

        return $this;
    }

    public function pull(string $remote = null, string $branch = null, array $options = []): GitContract
    {
        $command = 'pull';

        if ($remote) {
            $command .= " {$remote}";
        }

        if ($branch) {
            $command .= " {$branch}";
        }

        $this->execute($command, $options);

        return $this;
    }

    public function root(string $path = null): GitContract
    {
        $this->root = $path ?? getcwd();

        return $this;
    }

    public function status(array $options = []): string
    {
        [$_, $output] = $this->execute('status', $options);

        return $output;
    }

    public function hasChanges(): bool
    {
        $status = $this->status(['-s']);

        return ! empty($status);
    }

    public static function open(string $path = null)
    {
        return (new static)->root($path);
    }

    public function execute(string $command, array $options = []): array
    {
        $terminal = Terminal::builder()
            ->in($this->root)
            ->withEnvironmentVariables($this->environment);

        $string = implode(' ', [
            $this->binary,
            $command,
            implode(' ', array_map(function ($key, $value) {
                if (is_numeric($key)) return $value;

                return $key . ' ' . $value;
            }, array_keys($options), $options))
        ]);

        $response = $terminal->run(trim($string));

        $response->throw();

        return [$response->ok(), $response->output()];
    }
}