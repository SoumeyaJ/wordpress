<?php

// affichage du module dans le panel administration des extensions de wordpress  (informations obligatoires à saisir)
// le lien de licence permet de diffuser le plugin dans le Marketplace.
/**
 * Plugin Name: eu-disclaimer
 * Plugin URI: http://url_de_l_extension
 * Description: Plugin sur la législation des produits à base de nicotine.
 * Version: 1.5
 * Author: Ryad AFPA
 * Author URI: http://www.afpa.fr
 * Licence: (Lien de la license)
 * 
 *  
 */

//Utilisation de la table DisclaimerGestionTable.php
require_once('Model/Repository/DisclaimerGestionTable.php');

// création de la fonction ajouter au menu pour afficher un raccourci vers le plugin
function ajouterAuMenu()
{
    $page = 'eu-disclaimer'; // nom de la page.
    $menu = 'eu-disclaimer'; // nom affiché dans le menu admin.
    $capability = 'edit_pages'; // droit offert à l'utilisateur.
    $slug = 'eu-disclaimer'; //lien url.
    $function = 'disclaimerFonction'; // nom de la fonction qui génère le menu.
    $icon = ''; // chemin de l'image icône pour personnaliser le menu.
    $position = 80; // position dans le menu admin.
    // Vérifier s'il s'agit bien de l'admin on affiche toutes les infos
    if (is_admin()) {
        add_menu_page($page, $menu, $capability, $slug, $function, $icon, $position);
    }
}


//hook pour réaliser l'action 'admin_menu'
// ajouter des données ou de modifier le fonctionnement de WordPress
add_action("admin_menu", "ajouterAuMenu", 10);

//fonction à appeler lorsque l'on clic sur le Menu.
function disclaimerFonction()
{
    // charger la page "disclaimer-menu.php" dans le fichier "views"
    require_once('views/disclaimer-menu.php');
}

if (class_exists("DisclaimerGestionTable")) {
    $gerer_table = new DisclaimerGestionTable();
}
if (isset($gerer_table)) {
    //création de la table dans la BDD lors de l'activation
    register_activation_hook(__FILE__, array($gerer_table, 'creerTable'));
    //suppression de la table dans la BDD lors de la désactivation
    register_deactivation_hook(__FILE__, array($gerer_table, 'supprimerTable'));
}


//Ajout du JS à l'activation du plugin:
add_action('init', 'inserer_js_dans_footer');

function inserer_js_dans_footer()
{
    if (!is_admin()) :
        wp_register_script('jQuery','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js', null, null, true);
        wp_enqueue_script('jQuery');
        wp_register_script('jQuery_modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js',  null, null, true);
        wp_enqueue_script('jQuery_modal');
        wp_register_script('jQuery_eu',plugins_url('assets/js/eu-disclaimer.js', __FILE__),array('jquery'), '1.1', true);
        wp_enqueue_script('jQuery_eu');
    endif;
}

//Ajout du CSS à l'activation du plugin :
add_action('wp_head', 'ajouter_css', 1);

function ajouter_css()
{
    if (!is_admin()) :
        wp_register_style('eu-disclaimer-css',plugins_url('assets/css/eu-disclaimer-css.css', __FILE__),null,null,false);
        wp_enqueue_style('eu-disclaimer-css');
        wp_register_style('modal','https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.css',null,null,false);
        wp_enqueue_style('modal');
    endif;
}

// Ajout du modal et du shortcode -La fonction"«  add_shortcode() »" permet de lier 
// le "« shortcode »" à la méthode à appeler.

// add_shortcode('eu-disclaimer', 'afficheModal');
// function afficheModal() {
//     return DisclaimerGestionTable::AfficherDonneModal();
// }



//grace au add_action('nom du hook', 'nom de la fonction'), on peut activer le modal
//sans utilisation du shortcode et de manière automatique
add_action('wp_body_open', 'afficheModalDansBody');

function afficheModalDansBody() {
   echo DisclaimerGestionTable::AfficherDonneModal();
}