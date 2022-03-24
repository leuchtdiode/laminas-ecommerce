<?php
namespace Ecommerce\Transaction\Invoice;

use Exception;
use Log\Log;
use Spipu\Html2Pdf\Html2Pdf;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;

class DefaultGenerator implements Generator
{
	private array $config;

	private PhpRenderer $renderer;

	private FileSystemPathProvider $fileSystemPathProvider;

	public function __construct(array $config, PhpRenderer $renderer, FileSystemPathProvider $fileSystemPathProvider)
	{
		$this->config                 = $config;
		$this->renderer               = $renderer;
		$this->fileSystemPathProvider = $fileSystemPathProvider;
	}

	public function generate(GenerateData $data): GenerateResult
	{
		$result = new GenerateResult();
		$result->setSuccess(true);

		try
		{
			$transaction = $data->getTransaction();

			$html2Pdf = new Html2Pdf('P', 'A4', 'de');

			$viewModel = new ViewModel(
				[
					'transaction'    => $transaction,
					'customer'       => $transaction->getCustomer(),
					'billingAddress' => $transaction->getBillingAddress(),
				]
			);
			$viewModel->setTerminal(true);
			$viewModel->setTemplate('invoice/template');

			$html = $this->renderer->render($viewModel);

			$html2Pdf->writeHTML($html);

			if (($logo = $this->config['ecommerce']['transaction']['invoice']['logo'] ?? null))
			{
				$html2Pdf->pdf->Image($logo['path'], $logo['x'], $logo['y'], $logo['width'], $logo['height']);
			}

			$pdfContent = $html2Pdf->output(null, 'S');

			file_put_contents(
				$this->fileSystemPathProvider->get($transaction),
				$pdfContent
			);

			$result->setSuccess(true);
			$result->setPdf($pdfContent);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}
}
