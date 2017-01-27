<?php

namespace MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuController extends Controller{
	
	public function menuAction(){
		
		return $this->render('MenuBundle:vues:menu.html.twig',
				array(
						"menu"=>$this->menu()
				)
			
			);
	}
	
	private function menu(){
		return array(
				array(
					"libelle" =>"Accueil",
					"route"=>"menu_accueil",
					"titre"=>"Retour à l'accueil"
				),
				
				array(
					"libelle" =>"Articles",
					"route"=>"",
					"titre"=>"Blog",
					"enfants"=>array(
						array(
							"libelle" =>"Tous les articles",
							"route"=>"menu_tous",
							"titre"=>"Voir tous les articles"
						),
						array(
							"libelle" =>"Les 5 derniers articles",
							"route"=>"menu_cinq",
							"titre"=>"Voir les 5derniers articles"
						),
						array(
							"libelle" =>"voir l'article",
							"route"=>"blog_voir",
							"titre"=>"Voir l'articles",
							"identifiant"=>26
						)
					)
				),	
				array(
					"libelle" =>"Contact",
					"route"=>"menu_contact",
					"titre"=>"Contactez l'auteru de ce blog"
				)
													
			);
								
								
			
				
				
	}

	public function accueilAction(){
		return $this->render('MenuBundle:vues:accueil.html.twig');
	}
	
	public function tousAction(){
		return $this->render('MenuBundle:vues:tous.html.twig');
	}
	
	public function cinqAction(){
		return $this->render('MenuBundle:vues:cinq.html.twig');
	}
	
	public function contactAction(){
		$menu = array(
				"Accueil",
				"Tous les articles",
				"Les 5 derniers articles",
				"Contact"
		);
		return $this->render('MenuBundle:vues:contact.html.twig',
				array(
						"menu"=>$menu
				)
				);
	}
	
	

	
	
	
}
