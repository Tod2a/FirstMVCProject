<?php

session_start();

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_vue.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_connection.php';

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
    if (!isset($_SESSION['id']))
    {
        show_vue(get_pageInfos(), 'index');
    }
    else
    {
        if($_SESSION['actived'] == 0)
        {
            header('Location: ' . BASE_URL . '/' . 'connexion' . '/' . 'activation');
        }
        else
        {
            header('Location: ' . BASE_URL . '/' . 'connexion' . '/' . 'profil');
        }
    }
}

function try_connection ()
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
                start_connection ($user);
                if ($user['uti_compte_active'] == 1)
                {
                    $_SESSION['pseudo'] = $user['uti_pseudo'];
                    $_SESSION['email'] = $user['uti_email'];
                    header('Location: ' . BASE_URL . '/' . 'connexion' . '/' . 'profil');
                }
                else
                {
                    set_activationCode($_SESSION['id']);
                    header('Location: ' . BASE_URL . '/' . 'connexion' . '/' . 'activation');
                    exit();
                }
            }
            else 
            {
                $result['finalMessage'] = 'Mot de passe erroné';
                show_vue(get_pageInfos(), 'index', $result);
            }
        }
    }
}



?>