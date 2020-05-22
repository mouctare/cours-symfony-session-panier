<?php

namespace App\Service\Cart;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;


class CartService {  

    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository) 
    { 
        $this->session = $session; 
        $this->productRepository = $productRepository; 

    }
    public function add(int $id) 
    {

        $panier =  $this->session->get('panier', []);

        // Si j'ai deéjà un produit avec cet identifiant dans mon panier alors !

        if(!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;

        }


        $this->session->set('panier', $panier);
    }

    public function remove(int $id) {
        $panier = $this->session->get('panier',[]);

        if(!empty($panier[$id])) {
            // Si jamais ce produit existe je vais le viré
            unset($panier[$id]);
        }

        $this->session->set('panier' , $panier);
    }

    
    function getFullCart() : array {
        $panier =  $this->session->get('panier', []);
        $panierWithData = [];

        foreach($panier as $id => $quantity) {
              $panierWithData[] = [
                  'product' => $this->productRepository->find($id),
                  'quantity' => $quantity
              ];

        }
        return $panierWithData;
    }
    public function getTotal() : float
     {
        $total = 0;

        foreach($this->getFullCart() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
            
        }
        return $total;
    }
}