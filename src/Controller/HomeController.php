<?php

namespace App\Controller;

use App\Form\FinirInscripType;
use App\Repository\UserRepository;
use function PHPUnit\Framework\isNull;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function Home(UserRepository $UserRep,Request $request,Security $security): Response
    {
        //tester d'abord s'il l'utilisateur veut acceder a sa page → etre connecter:
        if($security->isGranted("IS_AUTHENTICATED_FULLY")){
            //s'il n'est pas terminer son inscription:
            /** @var \App\Entity\User $user */
            $user=$this->getUser();
            // dd($security->getUser());
            // dd($this->getUser());
            //if il est connecter + il veut consulter sa propre page:
            //d'abord cherche sa data:
            // $etudiant = null;
            // $etudiant = $UserRep->find($request->getSession()->get("id_user"));
            //apres on utilise la fct find() to get data to home 
          //  dd($this->getUser());
                // dd($this->getUser());
                // dd($request->getSession()->has("id"));
            //il dois completer son inscription avant de continuer :
            //doit changemdp + saissir email + telephone :

        }
        else{
            //s'il n'est pas connecter , il est derige vers page d'acc:
            return $this->redirectToRoute("app_login");
        }

        // dd($security->isGranted("IS_AUTHENTICATED_FULLY"));
        // dd($this->getUser());
        $session=$request->getSession();
        if($session->has("nbVisite")){
            $nbr=$session->get("nbVisite");
        }
        else{
            $nbr=0;
        }
        $session->set("nbVisite",$nbr+1);



        return $this->render('profile/profile.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    //cette Controller pour finir son inscription :
    #[Route('/finirInscription', name: 'app_insc')]
    public function finirInscController(Request $request,UserRepository $UserRepository):Response{
        /** @var \App\Entity\User $user */
        $user=$this->getUser();

        //🔥Il faut interdir d'acceder a cette page par taper la route , d'ou :
        if(!$user->getEmail()){
            $form=$this->createForm(FinirInscripType::class,$user);
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid()){
                //⚠️je pense qu'il faut ajouter des test expl: si le nom exist deja or email , ...(plustard)
                $user=$form->getdata();
                $UserRepository->save($user,true);
                return $this->redirectToRoute("app_home");

            }else{
                //rediriger avec message error (plustard)
                return $this->render('security/finirInsc.html.twig',['form'=>$form->createView()]);
            }
        }
        else{
            return $this->redirectToRoute("app_home");
            // return $this->render('home/index.html.twig', [
            //     'controller_name' => 'HomeController',
            // ]);
        }
        
    }
}
