<?php
namespace Ecommerce\Transaction\Invoice\Bulk;

class GetResult
{
	private ?string $content = null;

	public function hasContent(): bool
	{
		return !empty($this->content);
	}

	public function getContent(): ?string
	{
		return $this->content;
	}

	public function setContent(?string $content): void
	{
		$this->content = $content;
	}
}