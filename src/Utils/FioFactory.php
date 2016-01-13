<?php

namespace h4kuna\Fio\Utils;

use h4kuna\Fio;

class FioFactory
{

	/** @var Fio\Account\AccountCollection */
	private $accountCollection;

	/** @var Context */
	private $queue;

	/** @var string */
	private $transactionClass;

	public function __construct(array $accounts, $transactionClass = NULL)
	{
		$this->accountCollection = $this->createAccountCollection($accounts);
		$this->queue = $this->createQueue();
		$this->transactionClass = $transactionClass;
	}

	public function createFioRead()
	{
		return new Fio\FioRead($this->getQueue(), $this->getAccountCollection(), $this->createReader());
	}

	public function createFioPay()
	{
		return new Fio\FioPay($this->getQueue(), $this->getAccountCollection(), $this->createPaymentFactory(), $this->createXmlFile());
	}

	/**
	 * COMMON ******************************************************************
	 * *************************************************************************
	 */
	protected function createQueue()
	{
		return new Fio\Request\Queue();
	}

	protected function createAccountCollection(array $accounts)
	{
		return Fio\Account\AccountCollectionFactory::create($accounts);
	}

	final protected function getAccountCollection()
	{
		return $this->accountCollection;
	}

	final protected function getQueue()
	{
		return $this->queue;
	}

	protected final function getTransactionClass()
	{
		return $this->transactionClass;
	}

	/**
	 * READ ********************************************************************
	 * *************************************************************************
	 */
	protected function createTransactionListFactory()
	{
		// @todo test next class
		return new Fio\Response\Read\JsonTransactionFactory($this->getTransactionClass());
	}

	protected function createReader()
	{
		return new Fio\Request\Read\Files\Json($this->createTransactionListFactory());
	}

	/**
	 * PAY *********************************************************************
	 * *************************************************************************
	 */
	protected function createXmlFile()
	{
		return new Fio\Request\Pay\XMLFile(sys_get_temp_dir());
	}

	protected function createPaymentFactory()
	{
		return new Fio\Request\Pay\PaymentFactory($this->getAccountCollection());
	}

}
