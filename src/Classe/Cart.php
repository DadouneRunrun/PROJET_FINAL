<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function add($id)
    {
        $cart = $this->session->get( 'cart', []);

        if (!empty($cart[$id]))
        {
            $cart[$id]++;
        }
        else
        {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }
    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id)
    {
        $cart = $this->session->get( 'cart', []);

        unset($cart[$id]);

        return $this->session->set('cart', $cart);
    }

    public function decrease($id)
    {
        $cart = $this->session->get( 'cart', []);
        
        // vérifier si la quantité de notre produit n'est pas = 1
        if ($cart[$id] > 1 )
        {
            //retirer un produit
            $cart[$id]--;
        }
        else
        {
            //supprimer mon produit
            unset($cart[$id]);
        }
        
        return $this->session->set('cart', $cart);  
    }

    public function getFull()
    {
        $cartComplete = [];

        if ($this->get())
        {
            foreach($this->get() as $id => $quantity)
            {
                $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);
                if (!$product_object)
                {
                    $this->delete($id);
                    continue;
                }
                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
                
            }
            return $cartComplete;
        }
    }

    public function getTotal()
    {
        $total = 0;

        //Je vais chercher mon panier
        $panier = $this->getFull();

        //Je boucle sur mon panier et ce qu il contient.
        foreach($panier as $product)
        {
            $total += $product['product']->getPrice() * $product['quantity'];
        }

        return $total;
    }

}