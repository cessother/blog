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
use BlogBundle\Entity\Blog;


Class BlogController extends Controller{
	/**
	 * Stocke les articles déjà disponibles
	 * @var array
	 */
	private $articles;
	
	public function indexAction(){
		$this->articles = $this->getArticles();
	
		return $this->render(
				"BlogBundle:hello:index.html.twig",
				array(
						"pageTitle" => "J'aime Symfony",
						"titreInterne" => "Symfony exposé par le contrôleur",
						"majVersion" => 1,
						"minVersion" => 0,
						"articles" => $this->articles
				)
				);
	}
	// voir les routes dans le fichier : symfony_prj/src/BlogBundle/Ressources/config/routing.yml
	
	// L1 blog_voir:// (cette ligne nomme la page � afficher)
    //L2 path: /blog/post/{id} //(cette ligne donne le chemin url + le nom de la variable pass�e en param�tre
    //L3 defaults: { _controller: BlogBundle:Blog:voir }//(un controller dont le nom contient "blog", situ� dans le dossier
    													//BlogBundle, ira chercher la m�thode "quicontient le mot "voir)
	private function getArticles(){
		return array(
				array(
						"titre" => "Mon premier post",
						"contenu" => "blablabla...",
						"image" => "image/first.jpg",
						"auteur" => "JLA",
						"date" => new \DateTime("2016-12-23")
				),
				array(
						"titre" => "Mon second post",
						"contenu" => "blablabla...",
						"image" => "image/second.jpg",
						"auteur" => "JLA",
						"date" => new \DateTime("2016-12-24")
				),
				array(
						"titre" => "Mon troisième post",
						"contenu" => "blablabla...",
						"image" => "image/third.jpg",
						"auteur" => "JLA",
						"date" => new \DateTime("2017-01-02")
				)
		);
	}
	
	

		
	
		public function voirAction($id,Request $httpRequest){
			$url="";
			$action=$httpRequest->query->get("action", "voir");
		
			/**
			 * utilisation des services dcodtrine
			 */
			$depot = $this->getDoctrine()
				->getManager()
				->getRepository("BlogBundle:Blog");
			
				/**
				 * Demande à Doctrine, à partir de l'Entité "Blog" d'alimenter le dépôt
				 *  "BlogRepository" avec les données associée à la clé primaire dont la valeur
				 *  est $id <=>
				 * SELECT id,date,titre,contenu,auteur,vues FROM blog WHERE id=$id;
				 * $article = MaBase->fetch();
				 *
				 * @var Object $article => Contient les informations de la ligne identifiée par $id
				 *  de la table blog
				 *  find = select + fetch
				 */
			$article = $depot->find($id);
			
			
			if($article === null){
				throw $this->createNotFoundException("L'article de blog ".$id." n'existe pas ! ");
			}
			/**
			 * on visualise donc on doit alimenter le compteur
			 */
			$vuesCourantes= $article->getVues() +1;
			//$vuesIncrementees = $vuesCourantes + 1;
			
			
			/**
			 * inregixtrment des infos dans la base
			 */
			$article->setVues($vuesCourantes);
			
			$this->getDoctrine()->getManager()->flush();
					return $this->render(
					"BlogBundle:hello:article.html.twig",
					array(
							"article"=>$article
								
					)
				);
		}
		
		public function ajouterAction(Request $request) {
			$idCree = 5;
			
			/**
			 * Récupère le service doctrine dans la variable $doctrine
			 * @var Ambiguous $doctrine
			 */
			$doctrine = $this->get("doctrine");
			//ou...$doctrine = $this->getDoctrine();
			//encore mieux : $manager = $this->getDoctrine()->getManager();
			/**
			 * Depuis le service Doctrine, on veut récupérer le gestionnaire d'entités
			 * (Entity Manager)
			 * @var unknown $manager
			 */
			$manager = $doctrine->getManager();
			
			$article = new Blog(); // INSTANCIATION DE L'entité blog
			//$article->setId($idCree);
			$article->setTitre(" Un post par entité");
			$article->setPublication(true);
			$article->setContenu("On utilise un objet entité pour, dans un premier temps, passer des infos");
			
			
			$autrePost = new Blog();
			$autrePost->setTitre("autre objet à persister")
					->setPublication(false)
					->setContenu("pourquoi je peux utiliser cette notation ?")
					->setAuteur("moi");
			
					
			//oN va demander à doctrine de faire persister l'objet $article dans la base de données
			$manager->persist($article);
			$manager->persist($autrePost);
			
			$manager->flush(); // pour écrire l'ensemble des objets à faire persisiter
			// dans le controler, on récupère un objet session
			//de cet objet session, on utilise le service getFlashBag()
			/**$flashMessage = $this->get("session")->getFlashBag();
			$flashMessage->add("info", " je suis un Message flash service de symfony")
			->add("info", "je suis capable d'afficher la valeur");**/
			
			return $this->render("BlogBundle:hello:ajouter.html.twig",
					array("date" => date("d-m-Y H:i:s"), "article" =>$article));
		}
		private function menu(){
			return array(
					array(
							"libelle" =>"Accueil",
							"route"=>"menu_accueil",
							"titre"=>"Retour à l'accueil"
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

