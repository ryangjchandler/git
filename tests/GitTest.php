<?php

namespace RyanChandler\Git\Tests;

use RyanChandler\Git\Git;
use TitasGailius\Terminal\Terminal;

class GitTest extends TestCase
{
    public function test_git_add()
    {
        Git::open()->add('tests');

        Terminal::assertExecuted('/usr/bin/git add tests');
    }

    public function test_git_with_options()
    {
        Git::open()->add('tests', [
            '--all',
        ]);

        Terminal::assertExecuted('/usr/bin/git add tests --all');
    }

    public function test_git_commit()
    {
        Git::open()->commit('Testing');

        Terminal::assertExecuted('/usr/bin/git commit -m \'Testing\'');
    }

    public function test_git_commit_with_author()
    {
        Git::open()
            ->author('Testing', 'testing@test.com')
            ->commit('Testing');

        Terminal::assertExecuted("/usr/bin/git commit -m 'Testing' --author 'Testing <testing@test.com>'");
    }

    public function test_git_commit_with_options()
    {
        Git::open()->commit('Testing', [
            '--dry-run'
        ]);

        Terminal::assertExecuted("/usr/bin/git commit -m 'Testing' --dry-run");
    }

    public function test_git_pull()
    {
        Git::open()->pull();

        Terminal::assertExecuted('/usr/bin/git pull');
    }

    public function test_git_pull_with_remote()
    {
        Git::open()->pull('origin');

        Terminal::assertExecuted('/usr/bin/git pull origin');
    }

    public function test_git_pull_with_remote_and_branch()
    {
        Git::open()->pull('origin', 'main');

        Terminal::assertExecuted('/usr/bin/git pull origin main');
    }

    public function test_git_pull_with_options()
    {
        Git::open()->pull(null, null, [
            '--force'
        ]);

        Terminal::assertExecuted('/usr/bin/git pull --force');
    }

    public function test_git_push()
    {
        Git::open()->push();

        Terminal::assertExecuted('/usr/bin/git push');
    }

    public function test_git_push_with_remote()
    {
        Git::open()->push('origin');

        Terminal::assertExecuted('/usr/bin/git push origin');
    }

    public function test_git_push_with_remote_and_branch()
    {
        Git::open()->push('origin', 'main');

        Terminal::assertExecuted('/usr/bin/git push origin main');
    }

    public function test_git_push_with_options()
    {
        Git::open()->push(null, null, [
            '--force'
        ]);

        Terminal::assertExecuted('/usr/bin/git push --force');
    }
}