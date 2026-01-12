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

    public function actionFull(string $ark)
    {
        $this->fullARK($ark);
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

    public function actionResolve(string $valueOfArk): void
    {

        $this->valueOfARK($valueOfArk);
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
