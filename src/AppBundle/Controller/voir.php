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
use Symfony\Component\HttpFoundation\Request;


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
	
	public function voirbAction(Request $request, $id){
		$request=$request->query->get('id');
		return new Request($this->toChemin($id,$request));
	}
		
		public function toChemin($id, $request){
			
			return $this->render("BlogBundle:hello:voir.html.twig", array(
		
		"id"=> $request->query->get('id'))); // get a $_GET paramete
		}