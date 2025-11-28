<?php

declare(strict_types=1);

namespace App\Presentation\Home;


use App\Services\AppConfiguration;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Presenter;


final class HomePresenter extends Presenter
{

    /** @inject  */ public AppConfiguration $appConfiguration;
    public const string HealthCheck = 'servicestatus';

    public function renderDefault()
    {
        $this->template->naan = $this->appConfiguration->getNaan();

    }

    public function actionResolve(?string $id, ?string $ark): void
    {
        if (!empty($ark)) { //http://localhost:8081/resolve-ark?ark=ark:xxxx/servicestatus
            $this->fullARK($ark);
        }

        if (!empty($id)) { //http://localhost:8081/resolve/servicestatus
            $this->valueOfARK($id);
        }
        $this->getParameter('NAAN');
        $this->redirect(':default');
    }

    protected function fullARK(string $ark)
    {
        switch ($ark) {
            case 'ark:' . $this->appConfiguration->getNaan() . '/' . self::HealthCheck:
                $this->keepAlive();
                break;
            default:
                $this->redirectUrl('https://biodiversity.cz');
        }

    }

    protected function keepAlive()
    {
        $response = new JsonResponse(['status' => 'OK']);
        $this->sendResponse($response);
    }

    protected function valueOfARK(string $arkValue)
    {
        switch ($arkValue) {
            case self::HealthCheck:
                $this->keepAlive();
                break;
            default:
                $this->redirectUrl('https://biodiversity.cz');
        }
    }
}
