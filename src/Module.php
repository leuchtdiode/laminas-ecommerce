<?php
namespace Ecommerce;

use Common\Util\StringUtil;
use Laminas\Http\Request;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\JsonModel;

class Module
{
	public function getConfig(): array
	{
		return include __DIR__ . '/../config/module.config.php';
	}

	/**
	 * @param MvcEvent $e
	 */
	public function onBootstrap(MvcEvent $e)
	{
		$eventManager = $e
			->getApplication()
			->getEventManager();

		$eventManager->attach(
			MvcEvent::EVENT_DISPATCH,
			function () use ($e)
			{
				$request = $e->getRequest();

				if (!$request instanceof Request || !StringUtil::startsWith($request->getRequestUri(), '/ecommerce'))
				{
					return;
				}

				$viewModel = $e->getViewModel();

				if ($viewModel instanceof JsonModel && $viewModel->success === false)
				{
					$e
						->getResponse()
						->setStatusCode(400);

					$e->stopPropagation(true);
				}

				return null;
			});
	}
}
