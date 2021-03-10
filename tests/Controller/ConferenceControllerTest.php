<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConferenceControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Give your feedback');
    }

    public function testConferencePage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertCount(2, $crawler->filter('h4'));

        $client->clickLink('View');

        $this->assertPageTitleContains('Samara');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Samara 2020');
        $this->assertSelectorExists('div:contains("There are 1 comments")');
    }

    public function testCommentSubmission(): void {
        $client = static::createClient();
        $client->request('GET', '/conference/samara-2020');
        $client->submitForm('Submit', [
            'comment_form[author]' => 'PhpUnit',
            'comment_form[text]' => 'Functional testing in action!',
            'comment_form[email]' => 'testing@local.tld',
        ]);
        $this->assertResponseRedirects('/conference/samara-2020');
        $client->followRedirect();
        $this->assertSelectorExists('div:contains("There are 2 comments")');
    }
}
