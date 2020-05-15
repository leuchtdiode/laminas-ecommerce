<?php
namespace Ecommerce\Transaction\Invoice\Bulk;

class GetResult
{
	/**
	 * @var string|null
	 */
	private $content;

	/**
	 * @return bool
	 */
	public function hasContent()
	{
		return !empty($this->content);
	}

	/**
	 * @return string|null
	 */
	public function getContent(): ?string
	{
		return $this->content;
	}

	/**
	 * @param string|null $content
	 */
	public function setContent(?string $content): void
	{
		$this->content = $content;
	}
}