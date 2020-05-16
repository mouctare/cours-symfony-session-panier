<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository) 
    {
        $panier = $session->get('panier', []);
        // Pour pouvoir afficher les produits à l'utilisateur

        $panierWithData = [];

        foreach($panier as $id => $quantity) {

            $panierWithData[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $this->render('cart/index.html.twig', [
        
        'items' => $panierWithData
        
        ]);
    } 
    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, SessionInterface $session) 
    { 
        // La prémière de chose on crée une action!
       // $session = $request->getSession();

        $panier = $session->get('panier', []);

        if(!empty($panier[$id])) {
            // Si j'ai déjà un produit qui a cet idifiant là
            $panier[$id]++;
        } else {
            $panier[$id] = 1;


        }

       $session->set('panier', $panier);

        // Je prends c'est qu'il ya dans mon panier à l'époque je l'altère  en mettant c'est que j'ai de nouveau

      // dd($session->get('panier'));

}
}
