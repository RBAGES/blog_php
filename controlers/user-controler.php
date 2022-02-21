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
                

            if(!empty($utilisateur) && !(password_verify($_POST['mot_de_passe'],$utilisateur->mot_de_passe)))
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

    if(!empty($_POST['rememberMe']))
        setcookie('id',$utilisateur->id, time()+60*60*24*30);
    
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
    setcookie('id','',0);
    session_destroy();
    redirect('list-articles');
}

/**
 * appelle le formulaire de création de compte et fait les test quand celui-ci est submit
 */
function createUser($title = 'créer un compte')
{

    $errors = [];
    if (!empty($_POST['submit'])) {
        //si tous les champs obligatoires ont été remplis
        if (!empty($_POST['pseudo']) && !empty($_POST['identifiant']) && !empty($_POST['mot_de_passe']) && !empty($_POST['validation_mot_de_passe'])) {
            //si les deux mots de passe sont les mêmes
            if ($_POST['validation_mot_de_passe'] === $_POST['mot_de_passe'])
                //si l'identifiant est une adresse mail valide
                if (filter_var($_POST['identifiant'], FILTER_VALIDATE_EMAIL))
                    // si l'identifiant n'existe pas
                    if (empty(Utilisateur::retrieveByField('identifiant', $_POST['identifiant'], SimpleOrm::FETCH_ONE)))
                        createUserHandler();
                    else
                        $errors[] = 'cet identifiant existe déjà';
                else
                    $errors[] = 'veuillez entrer une adresse mail valide';
            else
                $errors[] = 'les mots de passe ne correspondent pas';
        } else
            $errors[] = 'Veuillez remplir tous les champs obligatoires (ceux avec un * rouge)';
    }

    include PATH_VIEWS . 'user-create-form.php';
}

/**
 * crée un nouvel utilisateur et l'enregistre dans la base à partir des données du formulaire
 */
function createUserHandler(){
    $utilisateur = new utilisateur();
    $utilisateur->pseudo = $_POST['pseudo'];
    $utilisateur->mot_de_passe = password_hash($_POST['mot_de_passe'],PASSWORD_BCRYPT);
    $utilisateur->avatar = $_POST['avatar'];
    $utilisateur->identifiant = $_POST['identifiant'];

    $utilisateur->save();
    mail($_POST['identifiant'],'Inscription réussie','Bienvenue sur notre site!');
    redirect('login');
}


function getUtilisateur(int $id): object{
    try {
        $utilisateur = Utilisateur::retrieveByPK($id);
        return $utilisateur;
    } catch (\Throwable $th) {
        displayError(102);
    }
}

