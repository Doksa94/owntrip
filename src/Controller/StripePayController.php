<?php

namespace App\Controller;

use App\Service\CartService;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class StripePayController extends AbstractController
{
    #[Route('/stripe/pay', name: 'app_stripe_pay')]
    public function index(CartService $cs): Response
    {

        $fullCart=$cs->getCartWithData();

        $line_items=[];

            foreach ($fullCart as $item)
                {
                    $line_items[]=[
                        'price_data'=>[
                            'unit_amount'=>$item['activity']->getPrice()*10, 'currency'=>'EUR', 'product_data'=>['name'=>$item['activity']->getName()]
                        ],
                        'quantity'=>$item['quantity']
                    ];
                }

                Stripe::setApiKey
                ('sk_test_51Nwh6HFUq4ru59FZfO3PngblSK0V2efRsT0E4zgtxrYOn5bZDfTMRo239qwhDA2hpsbqD3Ixn2OJ9reAgP7ww3ZG00gy2mDYjf');
                $session=Session::create([
                    'success_url'=>'https://www.sadok.lock.cezdigit.com/commande/success',
                    'cancel_url'=>'https://www.sadok.lock.cezdigit.com/wishList',

                    // 'success_url'=>'http://127.0.0.1:8000/commande/success',
                    // 'cancel_url'=>'http://127.0.0.1:8000/wishList',

                    'payment_method_types'=>['card'],
                    'line_items'=>$line_items,
                    'mode'=>'payment'
                ]);

                return $this->redirect($session->url, 303);
    }
    
    #[Route('/commande/{success}', name: 'commande')]
    public function commande (CartService $cartService, $success=null): Response
    {
        if ($success){
            $this->addFlash('success', 'Merci pour votre confiance');
            $cartService->destroy();
            return $this->redirectToRoute('app_front');
        }else{
            $this->addFlash('danger','Un problème est survenu, merci de réitérer votre paiement');
            return $this->redirectToRoute('app_front');
        }
    }
}
