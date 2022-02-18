<?php

require_once PATH_MODELS . 'Utilisateur.php';

/**
 * affiche le formulaire de connection et vérifie que les infos entrées sont correctes, puis appelle le handler
 */
function loginUser($title='se connecter'){
    $errors = [];

    if(!empty($_POST['submit'])){
        if(!empty($_POST['identifiant']) && !empty($_POST['mot_de_passe'])){

            $utilisateur = Utilisateur::retrieveByField('identifiant',$_POST['identifiant'], SimpleOrm::FETCH_ONE);
            if(empty($utilisateur))
                $errors[] = 'Cet identifiant n\'existe pas';
                

            if(!(password_verify($_POST['mot_de_passe'],$utilisateur->mot_de_passe)))
                $errors[] = 'Mauvais mot de passe';

            if(empty($errors))
                loginUserHandler($utilisateur);
                
        }
        else
            $errors[] = 'Veuillez remplir tous les champs';
    }


    include_once PATH_VIEWS . 'login-form.php';
}

/**
 * crée la session avec les informations de l'utilisateur passé en paramètre puis redirige vers la liste
 * @param object $utilisateur 
 */
function loginUserHandler(object $utilisateur){

    $_SESSION['id'] = $utilisateur->id;
    $_SESSION['identifiant'] = $utilisateur->identifiant;
    $_SESSION['pseudo'] = $utilisateur->pseudo;
    $_SESSION['avatar'] = $utilisateur->avatar;
    $_SESSION['role'] = $utilisateur->role;

    redirect('list-articles');
}

/**
 * supprime la session puis redirige sur la liste des articles
 */
function signoutUserHandler(){
    session_destroy();
    redirect('list-articles');
}

function createUser($title = 'créer un compte'){

    $errors = [];
    
    
    
    if(!empty($_POST['submit'])){
        if(!empty($_POST['pseudo']) && !empty($_POST['identifiant']) && !empty($_POST['mot_de_passe'])){
            createUserHandler();
        }
        else
        $errors[] = 'Veuillez remplir tous les champs obligatoires (ceux avec un * rouge)';
    }

    include PATH_VIEWS. 'user-create-form.php';

}

function createUserHandler(){
    $utilisateur = new utilisateur();
    $utilisateur->pseudo = $_POST['pseudo'];
    $utilisateur->mot_de_passe = password_hash($_POST['mot_de_passe'],PASSWORD_BCRYPT);
    $utilisateur->avatar = $_POST['avatar'];
    $utilisateur->identifiant = $_POST['identifiant'];

    $utilisateur->save();
    redirect('list-articles');
}