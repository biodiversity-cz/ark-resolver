<?php

declare(strict_types=1);

namespace App\Presentation\Home;


use App\Services\AppConfiguration;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Presenter;


final class HomePresenter extends Presenter
{

    public const string HealthCheck = 'servicestatus';
    public const string HerbariumShoulder = 'nrp1HERB';
    /** @inject */
    public AppConfiguration $appConfiguration;

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
        $prefixes = [
            'ark:' . $this->appConfiguration->getNaan() . '/' . self::HerbariumShoulder => 'https://herbarium.biodiversity.cz/ark'
        ];

        if ($ark === 'ark:' . $this->appConfiguration->getNaan() . '/' . self::HealthCheck) {
            $this->keepAlive();
            return;
        }

        foreach ($prefixes as $prefix => $url) {
            if (str_starts_with($ark, $prefix)) {
                $this->redirectUrl($url . '?ark=' . rawurlencode($ark));
            }
        }

        $this->redirectUrl('https://biodiversity.cz');

    }

    protected function keepAlive()
    {
        $response = new JsonResponse(['status' => 'OK']);
        $this->sendResponse($response);
    }

    protected function valueOfARK(string $arkValue)
    {
        $prefixes = [
            self::HerbariumShoulder => 'https://herbarium.biodiversity.cz/ark'
        ];

        if ($arkValue === self::HealthCheck) {
            $this->keepAlive();
            return;
        }

        foreach ($prefixes as $prefix => $url) {
            if (str_starts_with($arkValue, $prefix)) {
                $this->redirectUrl($url . '?value=' . rawurlencode($arkValue));
            }
        }

        $this->redirectUrl('https://biodiversity.cz');
    }
}
