<?php
namespace Ecommerce\Transaction\Invoice;

class Invoice
{
	/**
	 * @var string
	 */
	private $content;

	/**
	 * @var string
	 */
	private $mimeType;

	/**
	 * @var string
	 */
	private $fileName;

	/**
	 * @return Invoice
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return string
	 */
	public function getContent(): string
	{
		return $this->content;
	}

	/**
	 * @param string $content
	 * @return Invoice
	 */
	public function setContent(string $content): Invoice
	{
		$this->content = $content;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMimeType(): string
	{
		return $this->mimeType;
	}

	/**
	 * @param string $mimeType
	 * @return Invoice
	 */
	public function setMimeType(string $mimeType): Invoice
	{
		$this->mimeType = $mimeType;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFileName(): string
	{
		return $this->fileName;
	}

	/**
	 * @param string $fileName
	 * @return Invoice
	 */
	public function setFileName(string $fileName): Invoice
	{
		$this->fileName = $fileName;
		return $this;
	}
}