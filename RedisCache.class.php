<?php

class RedisCache {
    /**
     * Redis connection
     *
     * @var \Redis
     */
    private $redisConn;

    /**
     * Cache expiration time in seconds
     */
    const expirationTime = 60;

    /**
     * Instantiating a new Redis Client
     */
    public function __construct() {
        $this->redisConn = new Redis();
        $this->redisConn->connect('localhost', 6379);
    }

    /**
     * Check if a request is cached in Redis
     *
     * @param string $url
     * @return bool
     */
    public function isResponseCached(string $url) {
        return $this->redisConn->exists($url);
    }

    /**
     * Stores a request's response
     *
     * @param string $url
     * @param string $response
     * @return void
     */
    public function cacheResponse(string $url, string $response) {
        $this->redisConn->setEx($url, self::expirationTime, $response);
    }

    /**
     * Get a request`s response
     *
     * @param string $url
     * @return void
     */
    public function getCachedResponse(string $url) {
        return $this->redisConn->get($url);
    }
}