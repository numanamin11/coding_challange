<?php
namespace App\EventListener;

use Sylius\Component\Core\Model\TaxonInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController as TaxonController;
use App\Service\CustomBannerService;

class TaxonBannerListener
{
    private $requestStack;
    private $customBannerService;

    public function __construct(RequestStack $requestStack,CustomBannerService $customBannerService)
    {
        $this->requestStack = $requestStack;
        $this->customBannerService = $customBannerService;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();
       

        // When a controller class is used, it comes as an array
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof TaxonController) {

            $currentRequest = $this->requestStack->getCurrentRequest();
            
            $route = $currentRequest ? $currentRequest->attributes->get('_route') : null;

            $slug = $currentRequest ? $currentRequest->attributes->get('slug') : null;
            
            $_locale = $currentRequest ? $currentRequest->attributes->get('_locale') : null;

            if ($route != 'sylius_shop_product_index' || $slug == null) {
                return;
            }
            
            $banners = $this->customBannerService->findBannersByTaxonSlug($slug, $_locale);
            $currentRequest->attributes->set('banners', $banners);
        }
    }
}
