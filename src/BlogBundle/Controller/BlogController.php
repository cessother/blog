<?php
/**
 * namespaceEspace de nom correspond généralt au dossier contenant le controleur
 */
namespace BlogBundle\Controller;
/**
 * appel de la classe parente pour définition du controleur
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;//Classe permettant une réponse http simplement
use Symfony\Component\HttpFoundation\Request; // accéder aux infos de la requete http(ce qui se situe après le ?)


Class BlogController extends Controller{
	
	public function indexAction(){
		return $this->render(
			"BlogBundle:hello:index.html.twig",
				array(
						"pageTitle" => "J'aime symfony",
						"innerTitle" => "Symfony esposé par le contrôleur"
				)
			);
	}
	// voir les routes dans le fichier : symfony_prj/src/BlogBundle/Ressources/config/routing.yml
	
	// L1 blog_voir:// (cette ligne nomme la page à afficher)
    //L2 path: /blog/post/{id} //(cette ligne donne le chemin url + le nom de la variable passée en paramètre
    //L3 defaults: { _controller: BlogBundle:Blog:voir }//(un controller dont le nom contient "blog", situé dans le dossier
    													//BlogBundle, ira chercher la méthode "quicontient le mot "voir)
	
	public function voirAction($id){
		return new Response ($this->toHtml($id));
	}
	private function toHtml($id){
		return '
				<!doctype html>
				<html>
				
				<h1> la variable : '.$id .' </h1>
				</html>';
	}
	
	public function voirbAction($id,Request $request){
		$action = $request->query->get("action","voir");// get a $_GET paramete
			if($action == "ajouter"){
				$url = $this->generateUrl("blog_ajouter"); // va créer tout le chemin vers la page
				return $this->redirect($url);//exécute l'action de redirection
			}
		
		}
		
	
		public function voircAction($id){
			echo"test";
			return $this->render(
					"BlogBundle:hello:voir.html.twig",
					array("id" => $id));
		}
		
		public function ajouter() {
			$idCree = 5;
			// dans le controler, on récupère un objet session
			//de cet objet session, on utilise le service getFlashBag()
			$flashMessage = $this->get("session")->getFlashBag();
			$flashMessage->add("info", " je suis un Message flash service de symfony")
			->add("info", "je suis capable d'afficher la valeur".$idCree);
			
			return $this->render("
					
					BlogBundle:hello:ajouter.html.twig",
					array("date" => date ("d-m-Y H:i:s")));
		}
			 
				
	}

