<?php


class WelcomeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->visit('/')
            ->see('Laravel')
            ->see('Facebook')
            ->see('Github')
            ->see('Website');
    }
}
