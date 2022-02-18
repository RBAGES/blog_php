<?php

/**
 * On va chercher SimpleOrm
 */
require_once PATH_MODELS . 'SimpleOrm.php';

/**
 * Une classe qui s'appelle comme ma table
 * contact => Contact
 * 
 * On indique qu'on utilise SimpleOrm
 * grâce à "extends" SimpleOrm
 */
class utilisateur extends SimpleOrm {

    /**
     * Je liste les colonnes (comme des variables, donc avec un "$")
     * En les séparant par des virgules
     * En finissant par un ";"
     * Et en commençant par le mot "public"
     */
    public $id, $pseudo, $identifiant, $mot_de_passe ,$role ,$avatar;
}
