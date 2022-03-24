<?php
namespace Ecommerce\Transaction\Invoice;

class Invoice
{
	private string $content;

	private string $mimeType;

	private string $fileName;

	public static function create(): self
	{
		return new self();
	}

	public function getContent(): string
	{
		return $this->content;
	}

	public function setContent(string $content): Invoice
	{
		$this->content = $content;
		return $this;
	}

	public function getMimeType(): string
	{
		return $this->mimeType;
	}

	public function setMimeType(string $mimeType): Invoice
	{
		$this->mimeType = $mimeType;
		return $this;
	}

	public function getFileName(): string
	{
		return $this->fileName;
	}

	public function setFileName(string $fileName): Invoice
	{
		$this->fileName = $fileName;
		return $this;
	}
}