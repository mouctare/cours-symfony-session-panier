<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        // La prémière de chose on crée une action!
        $session = $request->getSession();

        $panier = $session->get('panier', []);

        if(!empty($panier[$id])) {
            // Si j'ai déjà un produit qui a cet idifiant là
            $panier[$id]++;
        } else {
            $panier[$id] = 1;

        }


        $session->set('panier', $panier);

        // Je prends c'est qu'il ya dans mon panier à l'époque je l'altère  en mettant c'est que j'ai de nouveau

        dd($session->get('panier'));





    }
}
