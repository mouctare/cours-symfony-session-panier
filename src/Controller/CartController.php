<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index()
    {
        return $this->render('cart/index.html.twig', []);
    }


    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
     public function add($id, Request $request) {
         $session = $request->getSession();

        $panier =  $session->get('panier', []);

        // Si j'ai deéjà un produit avec cet identifiant dans mon panier alors !

        if(!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;

        }


        $session->set('panier', $panier);

        dd($session->get('panier'));


     

     }
}
