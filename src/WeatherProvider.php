<?php

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * Провайдер для weatherapi.com
 */
class WeatherProvider
{
	/**
	 * URL Сервиса
	 */
	CONST API_URL = 'https://api.weatherapi.com/v1/current.json?';

	/**
	 * API Ключ
	 *
	 * @var string
	 */
	private $apiKey;

	/**
	 * Клиент запросов по PSR
	 *
	 * @var ClientInterface
	 */
	private $httpClient;

	/**
	 * Фабрика для запросов по PSR
	 *
	 * @var RequestFactoryInterface
	 */
	private $httpRequestFactory;

	/**
	 * Конструктор
	 *
	 * @param string $apiKey API ключ
	 * @param ClientInterface $httpClient Клиент запросов по PSR
	 * @param RequestFactoryInterface $httpRequestFactory Фабрика для запросов по PSR
	 */
	public function __construct(string $apiKey, ClientInterface $httpClient, RequestFactoryInterface $httpRequestFactory)
	{
		if (!is_string($apiKey) || empty($apiKey)) {
			throw new InvalidArgumentException('Нужно указать API ключ');
		}

		$this->apiKey = $apiKey;
		$this->httpClient = $httpClient;
		$this->httpRequestFactory = $httpRequestFactory;
	}

	/**
	 * Получение погоды в указанном городе
	 *
	 * @param string $city Город
	 *
	 * @return string
	 * @throws HttpException
	 * @throws \Psr\Http\Client\ClientExceptionInterface
	 */
	public function getWeather(string $city): string
	{
		$queryParams = [
			'key' => $this->apiKey,
			'q' => $city,
		];

		$url = self::API_URL . http_build_query($queryParams);

		$response = $this->httpClient->sendRequest($this->httpRequestFactory->createRequest("GET", $url));

		$result = $response->getBody()->getContents();

		if ($response->getStatusCode() !== 200) {
			throw new HttpException();
		}

		return $result;
	}
}