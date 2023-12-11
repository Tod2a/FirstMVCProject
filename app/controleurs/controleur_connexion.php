<?php

session_start();

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_vue.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_connection.php';

require_once dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'modeles' . DIRECTORY_SEPARATOR . 'modele_user.php';

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
    if (is_connected())
    {
        header('Location: ' . BASE_URL . '/' . 'connexion' . '/' . 'profil');    
    }
    else
    {
        show_vue(get_pageInfos(), 'index');
    }
}

function try_connection ()
{
    if (!is_validCSRF()  || !is_validRequestFrequency())
    {
        header('Location: ' . BASE_URL . '/' . 'error' ); 
    }
    else
    {
        $nomTable = "t_utilisateur_uti";
        [$errors, $values, $access, $finalMessage] = is_validateform(get_fieldConnexionConfig(), $_POST, $nomTable);
        $result['errors'] = $errors;
        $result['values'] = $values;
        $result['access'] = $access;
        $result['finalMessage'] = $finalMessage;
        if(count($errors) == 0)
        {
            $user = get_userByPseudo($_POST['connexion_pseudo'], get_fieldConnexionConfig()['connexion_pseudo']['tableField']);
            if (empty($user))
            {
                $result['finalMessage'] = "Veuillez d'abord vous inscrire";
            }
            else 
            {
                if (check_password($user[get_fieldConnexionConfig()['connexion_motDePasse']['tableField']], $_POST['connexion_motDePasse']))
                {
                    $result['finalMessage'] = "";
                    start_connection ($user);
                    if ($user['uti_compte_active'] == 1)
                    {
                        $_SESSION['activated'] = true;
                        header('Location: ' . BASE_URL . '/' . 'connexion' . '/' . 'profil');
                    }
                    else
                    {
                        $_SESSION['activated'] = false;
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
}



?>