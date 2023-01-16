<?php declare(strict_types=1);

namespace h4kuna\Fio;

use h4kuna\Fio\Exceptions\InvalidState;

if (Utils\Strings::is32bitOS()) {
	throw new InvalidState('This library does not support 32bit OS.');
}

class Fio
{
	/** @var string url Fio REST API */
	public const REST_URL = 'https://www.fio.cz/ib_api/rest/';

	/**
	 * @todo INKASO does not work
	 * @var string
	 */
	const FIO_API_VERSION = '1.5.1';

	protected Request\IQueue $queue;

	protected Account\FioAccount $account;


	public function __construct(Request\IQueue $queue, Account\FioAccount $account)
	{
		$this->queue = $queue;
		$this->account = $account;
	}


	public function getAccount(): Account\FioAccount
	{
		return $this->account;
	}

}
