<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index( CartService $cartService) 
    {
        $panierWithData = $cartService->getFullCart();
       

        $total = 0;

        foreach($panierWithData as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }
        
        return $this->render('cart/index.html.twig', [
        
        'items' => $panierWithData,
        'total' => $total
        
        ]);
    } 
    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService) 
    { 
        $cartService->add($id);
     
    }

    /**
    * @Route("/panier/remove/{id}" , name="cart_remove")
     */
    public function remove($id, CartService $cartService) {
        $cartService->remove($id);
      

        return $this->redirectToRoute("cart_index");

    }
}
