<?php

namespace App\Controller;

use DateTime;
use App\Classe\Cart;
use App\Entity\Purchase;
use App\Form\PurchaseType;
use App\Entity\PurchaseDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchaseController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/commande", name="purchase")
     */
    public function index(Cart $cart, Request $request)
    {
        if (!$this->getUser()->getAdresses()->getValues())
        {
            return $this->redirectToRoute('account_address_add');
        }

        $form = $this->createForm(PurchaseType::class, null, [
            'user' => $this->getUser()
        ]);
       
        return $this->render('purchase/index.html.twig', [
            'form' => $form->createView(),
            'cart' =>$cart->getFull()
        ]);
    }

    /**
     * @Route("/commande/recapitulatif", name="purchase_recap")
     */
    public function add(Cart $cart, Request $request)
    {

        $form = $this->createForm(PurchaseType::class, null, [
            'user' => $this->getUser()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $date = new DateTime();
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('address')->getData();
            $delivery_content = $delivery->getFirstName().' '.$delivery->getLastName();
            $delivery_content .= '<br/>'.$delivery->getPhone();

            if ($delivery->getCompany())
            {
                $delivery_content .= '<br/>'.$delivery->getCompany();
            }
            $delivery_content .= '<br/>'.$delivery->getAddress();
            $delivery_content .= '<br/>'.$delivery->getPostal().''.$delivery->getCity();
            $delivery_content .= '<br/>'.$delivery->getCountry();
  
            //Enregistrer ma commande Purchase()
            $purchase = new Purchase();
            $purchase->setUser($this->getUser());
            $purchase->setCreatedAt($date);
            $purchase->setCarrierName($carriers->getName());
            $purchase->setCarrierPrice($carriers->getPrice());
            $purchase->setDelivery($delivery_content);
            $purchase->setIsPaid(0);
            $purchase->setPrice($cart->getTotal()+ $carriers->getPrice());

            $this->entityManager->persist($purchase);

            //Enregistrer mes produit PurchaseDetails()
            foreach ($cart->getFull() as $product)
            {
                
                $purchaseDetails = new PurchaseDetails();
                $purchaseDetails->setPurchase($purchase);
                $purchaseDetails->setProduct($product['product']->getName());
                $purchaseDetails->setQuantity($product['quantity']);
                $purchaseDetails->setPrice($product['product']->getPrice());
                $purchaseDetails->setTotal($product['product']->getPrice() * $product['quantity']);
                $this->entityManager->persist($purchaseDetails);
            }


            $this->entityManager->flush();
        }

        return $this->render('purchase/add.html.twig', [
            'cart' =>$cart->getFull()
        ]);

    }
}
