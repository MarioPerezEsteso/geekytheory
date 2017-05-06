<?php

use \App\Http\Controllers\FeedController;

class FeedTest extends TestCase
{
    /**
     * Test feed is not null.
     */
    public function testFeedIsNotEmpty()
    {
        /** @var SimpleXMLElement $xmlFeed */
        $xmlFeed = $this->getFeed();
        $this->assertNotNull($xmlFeed);
    }

    /**
     * Test if feed has mandatory element channel.
     */
    public function testFeedHasChannel()
    {
        /** @var SimpleXMLElement $xmlFeed */
        $xmlFeed = $this->getFeed();
        $this->assertNotNull($xmlFeed->channel);
    }

    /**
     * Test if channel feed has mandatory element title.
     */
    public function testChannelHasTitle()
    {
        /** @var SimpleXMLElement $xmlFeed */
        $xmlFeed = $this->getFeed();
        $this->assertNotNull($xmlFeed->channel->title);
    }

    /**
     * Test if channel feed has mandatory element link.
     */
    public function testChannelHasLink()
    {
        /** @var SimpleXMLElement $xmlFeed */
        $xmlFeed = $this->getFeed();
        $this->assertNotNull($xmlFeed->channel->link);
    }

    /**
     * Test if channel feed has mandatory element description.
     */
    public function testChannelHasDescription()
    {
        /** @var SimpleXMLElement $xmlFeed */
        $xmlFeed = $this->getFeed();
        $this->assertNotNull($xmlFeed->channel->description);
    }

    /**
     * Test if channel feed has items.
     */
    public function testFeedHasItems()
    {
        /** @var SimpleXMLElement $xmlFeed */
        $xmlFeed = $this->getFeed();
        $this->assertTrue(count($xmlFeed->channel->item) > 0);
    }

    /**
     * Test if the number of items is lower or equals than the maximum allowed.
     */
    public function testFeedHasValidCountOfItems()
    {
        /** @var SimpleXMLElement $xmlFeed */
        $xmlFeed = $this->getFeed();
        $this->assertTrue(count($xmlFeed->channel->item) <= FeedController::MAX_ITEMS);
    }

    /**
     * Test if the items have title.
     */
    public function testFeedItemsHaveTitle()
    {
        /** @var SimpleXMLElement $xmlFeed */
        $xmlFeed = $this->getFeed();
        foreach ($xmlFeed->channel->item as $item) {
            $this->assertNotNull($item->title);
        }
    }

    /**
     * Test if the items have link.
     */
    public function testFeedItemsHaveLink()
    {
        /** @var SimpleXMLElement $xmlFeed */
        $xmlFeed = $this->getFeed();
        foreach ($xmlFeed->channel->item as $item) {
            $this->assertNotNull($item->link);
        }
    }

    /**
     * Test if the items have pubDate.
     */
    public function testFeedItemHavePubDate()
    {
        /** @var SimpleXMLElement $xmlFeed */
        $xmlFeed = $this->getFeed();
        foreach ($xmlFeed->channel->item as $item) {
            $this->assertNotNull($item->pubDate);
        }

    }

    /**
     * Test if the pubDate of the items is in RSS format.
     */
    public function testFeedItemHaveValidPubDateInRSSFormat()
    {
        /** @var SimpleXMLElement $xmlFeed */
        $xmlFeed = $this->getFeed();
        foreach ($xmlFeed->channel->item as $item) {
            $dateStr = ltrim($item->pubDate, ' ');
            $dateStr = rtrim($dateStr, ' ');
            $date = DateTime::createFromFormat(DateTime::RSS, $dateStr);
            $this->assertTrue($date && DateTime::getLastErrors()["warning_count"] == 0 && DateTime::getLastErrors()["error_count"] == 0);
        }
    }

    /**
     * Test if the items have description.
     */
    public function testFeedItemHaveDescription()
    {
        /** @var SimpleXMLElement $xmlFeed */
        $xmlFeed = $this->getFeed();
        foreach ($xmlFeed->channel->item as $item) {
            $this->assertNotNull($item->description);
        }
    }

    /**
     * Get the XML RSS feed.
     *
     * @return SimpleXMLElement
     */
    public function getFeed()
    {
        $xmlFeed = $this->call('GET', '/feed')->getContent();
        $xmlFeed = trim(preg_replace('/\s+/', ' ', $xmlFeed));
        return simplexml_load_string($xmlFeed);
    }

}