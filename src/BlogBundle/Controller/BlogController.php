<?php
/**
 * namespaceEspace de nom correspond g�n�ralt au dossier contenant le controleur
 */
namespace BlogBundle\Controller;
/**
 * appel de la classe parente pour d�finition du controleur
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;//Classe permettant une r�ponse http simplement
use Symfony\Component\HttpFoundation\Request; // acc�der aux infos de la requete http(ce qui se situe apr�s le ?)


Class BlogController extends Controller{
	
	public function indexAction(){
		
		
		return $this->render(
			"BlogBundle:hello:index.html.twig",
				array(
						"pageTitle" => "J'aime symfony",
						"innerTitle" => "Symfony espos� par le contr�leur"
				)
			);
	}
	// voir les routes dans le fichier : symfony_prj/src/BlogBundle/Ressources/config/routing.yml
	
	// L1 blog_voir:// (cette ligne nomme la page � afficher)
    //L2 path: /blog/post/{id} //(cette ligne donne le chemin url + le nom de la variable pass�e en param�tre
    //L3 defaults: { _controller: BlogBundle:Blog:voir }//(un controller dont le nom contient "blog", situ� dans le dossier
    													//BlogBundle, ira chercher la m�thode "quicontient le mot "voir)

	

		
	
		public function voirAction($id,Request $httpRequest){
			$url="";
			$action=$httpRequest->query->get("action", "voir");
			
			if($action =="ajouter"){
				$url = $this->generateUrl("blog_hello");//g�n�re l'url compl�te'
				return $this->redirect($url);//effectue laredirection
			}
			return $this->render(
					"BlogBundle:hello:voir.html.twig",
					array(
							"id" => $id,
							"auteur"=> "moi",
							"action"=>$action,
							"url"=>$url == "" ?"url non d�finie":$url			//doit �treentr� � la main dans l'urlformat?action=...
										
							
					)
				);
		}
		
		public function ajouter() {
			$idCree = 5;
			// dans le controler, on r�cup�re un objet session
			//de cet objet session, on utilise le service getFlashBag()
			$flashMessage = $this->get("session")->getFlashBag();
			$flashMessage->add("info", " je suis un Message flash service de symfony")
			->add("info", "je suis capable d'afficher la valeur".$idCree);
			
			return $this->render("
					
					BlogBundle:hello:ajouter.html.twig",
					array("date" => date ("d-m-Y H:i:s"), "menu" =>$this->menu()));
		}
		private function menu(){
			return array(
					array(
							"libelle" =>"Accueil",
							"route"=>"menu_accueil",
							"titre"=>"Retour � l'accueil"
					),
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
							"libelle" =>"Contact",
							"route"=>"menu_contact",
							"titre"=>"Contactez l'auteru de ce blog"
					)
		
			);
		}
				
	}

