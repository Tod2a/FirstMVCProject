<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_vue.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'modeles' . DIRECTORY_SEPARATOR . 'modele_connexion.php';

function get_pageInfos()
{
    return [
        'vue' => 'vue_connexion',
        'titre' => "Page de connexion",
        'description' => "Page de connexion",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/'
    ];
}

function index ()
{
    show_vue(get_pageInfos(), 'index');
}

function postedform ()
{
    $nomTable = "t_utilisateur_uti";
    [$errors, $values, $access, $finalMessage] = is_validateform(get_fieldConfig(), $_POST, $nomTable);
    $result['errors'] = $errors;
    $result['values'] = $values;
    $result['access'] = $access;
    $result['finalMessage'] = $finalMessage;
    if(count($errors) == 0)
    {
        $user = get_userByPseudo($_POST['connexion_pseudo'], get_fieldConfig()['connexion_pseudo']['tableField']);
        if (empty($user))
        {
            $result['finalMessage'] = "Veuillez d'abord vous inscrire";
        }
        else 
        {
            if (check_password($user[get_fieldConfig()['connexion_motDePasse']['tableField']], $_POST['connexion_motDePasse']))
            {
                $result['finalMessage'] = "";
                echo 'connexion OK';
            }
            else 
            {
                $result['finalMessage'] = 'Mot de passe erroné';
            }
        }
    }
    show_vue(get_pageInfos(), 'index', $result);
}

?>