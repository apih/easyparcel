<?php
// A wrapper for EasyParcel Marketplace API
// Based on EasyParcel Marketplace API Documentation v2.0.0

namespace apih\EasyParcel;

class EasyParcel
{
	const DEMO_URL = 'http://demo.connect.easyparcel.my/?ac=';
	const LIVE_URL = 'http://connect.easyparcel.my/?ac=';

	protected $api_key;
	protected $auth_key;
	protected $url;
	protected $use_ssl = true;

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

	protected function curlRequest($action, $query_data)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if ($this->use_ssl === false) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		}

		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query_data));
		curl_setopt($ch, CURLOPT_URL, $this->url . $action);

		$response = curl_exec($ch);

		curl_close($ch);

		return json_decode($response, true);
	}

	public function checkRate($bulk)
	{
		$query_data = [
			'api' => $this->api_key,
			'authentication' => $this->auth_key,
			'bulk' => $bulk
		];

		return $this->curlRequest('MPRateCheckingBulk', $query_data);
	}

	public function checkNormalRate($bulk)
	{
		$query_data = [
			'api' => $this->api_key,
			'authentication' => $this->auth_key,
			'bulk' => $bulk
		];

		return $this->curlRequest('MPNormalRateCheckingBulk', $query_data);
	}

	public function submitOrder($bulk)
	{
		$query_data = [
			'api' => $this->api_key,
			'authentication' => $this->auth_key,
			'bulk' => $bulk
		];

		return $this->curlRequest('MPSubmitOrderBulk', $query_data);
	}

	public function makePayment($bulk)
	{
		$query_data = [
			'api' => $this->api_key,
			'authentication' => $this->auth_key,
			'bulk' => $bulk
		];

		return $this->curlRequest('MPPayOrderBulk', $query_data);
	}

	public function getOrderStatus($bulk)
	{
		$query_data = [
			'api' => $this->api_key,
			'authentication' => $this->auth_key,
			'bulk' => $bulk
		];

		return $this->curlRequest('MPOrderStatusBulk', $query_data);
	}

	public function getParcelStatus($bulk)
	{
		$query_data = [
			'api' => $this->api_key,
			'authentication' => $this->auth_key,
			'bulk' => $bulk
		];

		return $this->curlRequest('MPParcelStatusBulk', $query_data);
	}

	public function trackParcel($bulk)
	{
		$query_data = [
			'api' => $this->api_key,
			'authentication' => $this->auth_key,
			'bulk' => $bulk
		];

		return $this->curlRequest('MPTrackingBulk', $query_data);
	}
}
?>