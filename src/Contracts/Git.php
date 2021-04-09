<?php

namespace RyanChandler\Git\Contracts;

interface Git
{
    public function author(string $name, string $email): Git;

    public function add($paths, array $options = []): Git;

    public function commit(string $message, array $options = []): Git;

    public function environment(array $variables): Git;

    public function fetch(array $options = []): Git;

    public function checkout($paths, array $options = []): Git;

    public function push(string $remote = null, string $branch = null, array $options = []): Git;

    public function pull(string $remote = null, string $branch = null, array $options = []): Git;

    public function root(string $path = null): Git;
}