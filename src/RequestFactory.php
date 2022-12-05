<?php

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Фабрика для запросов по PSR
 */
class RequestFactory implements RequestFactoryInterface
{
	/**
	 * Создание запроса
	 *
	 * @param string $method Метод запроса
	 * @param \Psr\Http\Message\UriInterface|string $uri Ресурс запроса
	 *
	 * @return RequestInterface
	 */
	public function createRequest(string $method, $uri): RequestInterface
	{
		return new Request($method, $uri);
	}
}
