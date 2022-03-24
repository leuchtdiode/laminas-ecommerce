<?php
namespace Ecommerce\Mail;

use Common\Translator;
use Exception;
use Log\Log;
use Mail\Mail\Attachment;
use Mail\Mail\Mail;
use Mail\Mail\PlaceholderValues;
use Mail\Mail\Recipient;
use Mail\Queue\Queue;

abstract class Sender
{
	private array $config;

	private Queue $mailQueue;

	public function __construct(array $config, Queue $mailQueue)
	{
		$this->config    = $config;
		$this->mailQueue = $mailQueue;
	}

	abstract protected function getRecipient(): Recipient;

	abstract protected function getContentTemplate(): string;

	abstract protected function getSubject(): string;

	abstract protected function getPlaceholderValues(): PlaceholderValues;

	protected function getEcommerceMailConfig(): mixed
	{
		return $this->config['ecommerce']['mail'];
	}

	/**
	 * @return Attachment[]
	 */
	protected function getAttachments(): array
	{
		return [];
	}

	public function addToQueue(): bool
	{
		$mailConfig = $this->config['mail'];
		$config     = $this->getEcommerceMailConfig();

		try
		{
			$mail = new Mail();
			$mail->setLayoutTemplate($config['layout']);
			$mail->setContentTemplate(
				$this->getContentTemplate()
			);
			$mail->setPlaceholderValues(
				$this->getPlaceholderValues()
			);
			$mail->setFrom(
				Recipient::create(
					$mailConfig['from']['email'],
					$mailConfig['from']['name']
				)
			);
			$mail->setTo(
				[
					$this->getRecipient()
				]
			);
			$mail->setSubject(
				Translator::translate($this->getSubject())
			);
			$mail->setAttachments(
				$this->getAttachments()
			);

			$this->mailQueue->add($mail);

			return true;
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return false;
	}
}