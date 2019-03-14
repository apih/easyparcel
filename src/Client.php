<?php
// A client for EasyParcel Marketplace API
// Based on EasyParcel Individual API Document 1.1.0.0 (MALAYSIA)

namespace apih\EasyParcel;

class Client
{
	const DEMO_URL = 'https://demo.connect.easyparcel.my/?ac=';
	const LIVE_URL = 'https://connect.easyparcel.my/?ac=';

	protected $api_key;
	protected $auth_key;
	protected $url;
	protected $use_ssl = true;
	protected $last_error;

	public function __construct($api_key, $auth_key)
	{
		$this->api_key = $api_key;
		$this->auth_key = $auth_key;
		$this->url = self::LIVE_URL;
	}

	public function useDemo($flag = true)
	{
		$this->url = $flag ? self::DEMO_URL : self::LIVE_URL;
	}

	public function useSsl($flag = true)
	{
		$this->use_ssl = $flag;
	}

	public function getLastError()
	{
		return $this->last_error;
	}

	protected function logError($function, $request, $response)
	{
		$this->last_error = [
			'function' => $function,
			'request' => $request,
			'response' => $response
		];

		$error_message = 'EasyParcel Error:' . PHP_EOL;
		$error_message .= 'function: ' . $function . PHP_EOL;
		$error_message .= 'request: ' . PHP_EOL;
		$error_message .= '-> url: ' . $request['url'] . PHP_EOL;
		$error_message .= '-> data: ' . json_encode($request['data']) . PHP_EOL;
		$error_message .= 'response: ' . PHP_EOL;
		$error_message .= '-> http_code: ' . $response['http_code'] . PHP_EOL;
		$error_message .= '-> body: ' . $response['body'] . PHP_EOL;

		error_log($error_message);
	}

	protected function curlInit()
	{
		$this->last_error = null;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

		if ($this->use_ssl === false) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		}

		return $ch;
	}

	protected function curlPostRequest($function, $action, $data)
	{
		$url = $this->url . $action;

		$data = array_merge([
			'api' => $this->api_key,
			'authentication' => $this->auth_key
		], $data);

		$ch = $this->curlInit();

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_URL, $url);

		$body = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		$decoded_body = json_decode($body, true);

		if ($http_code !== 200 || json_last_error() !== JSON_ERROR_NONE) {
			$this->logError(
				$function,
				compact('url', 'data'),
				compact('http_code', 'body')
			);

			return null;
		}

		return $decoded_body;
	}

	public function checkRate($bulk)
	{
		return $this->curlPostRequest(__FUNCTION__, 'EPRateCheckingBulk', ['bulk' => $bulk]);
	}

	public function checkNormalRate($bulk)
	{
		return $this->curlPostRequest(__FUNCTION__, 'EPNormalRateCheckingBulk', ['bulk' => $bulk]);
	}

	public function submitOrder($bulk)
	{
		return $this->curlPostRequest(__FUNCTION__, 'EPSubmitOrderBulk', ['bulk' => $bulk]);
	}

	public function makePayment($bulk)
	{
		return $this->curlPostRequest(__FUNCTION__, 'EPPayOrderBulk', ['bulk' => $bulk]);
	}

	public function getOrderStatus($bulk)
	{
		return $this->curlPostRequest(__FUNCTION__, 'EPOrderStatusBulk', ['bulk' => $bulk]);
	}

	public function getParcelStatus($bulk)
	{
		return $this->curlPostRequest(__FUNCTION__, 'EPParcelStatusBulk', ['bulk' => $bulk]);
	}

	public function trackParcel($bulk)
	{
		return $this->curlPostRequest(__FUNCTION__, 'EPTrackingBulk', ['bulk' => $bulk]);
	}
}
?>