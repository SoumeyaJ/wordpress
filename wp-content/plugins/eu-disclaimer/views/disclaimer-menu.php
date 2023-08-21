
<?php

// vérifier que le formulaire n'est pas vide avant la validation pour éviter de transmettre des données vides
if (!empty($_POST['message_disclaimer']) && !empty($_POST['url_redirection'])) {
    $text = new DisclaimerOptions();
    $text->setMessageDisclaimer(htmlspecialchars($_POST['message_disclaimer']));
    $text->setRedirectionko(htmlspecialchars($_POST['url_redirection']));
    $message = DisclaimerGestionTable::insererDansTable($text);
}
?>

<h1>EU DISCLAIMER</h1>
<br />
<h2>Configuration</h2>
<p></p>
<form method="post" action="" novalidate="novalidate">
    <table class="form-table">
        <tr>
            <!-- afficher le message de confirmation por les modifications des valeurs saisies dans le formulaire. -->
            <p> <?php if (isset($message)) echo $message; ?></p>
            <th scope="row">
                <label for="message_disclaimer">Message du disclaimer</label>
            </th>
            <td>
                <input type="text" name="message_disclaimer" id="message_disclaimer" value="" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="url_redirection">Url de redirection</label>
            </th>
            <td>
                <input type="text" name="url_redirection" id="url_redirection" value="" class="regular-text" />
            </td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button button-primary" value="Enregistrer les modififcations" />
    </p>
</form>
<br />
<p>
    Exemple : La législation nous impose de vous informer sur la nocivité des produits à base de nicotine,
    vous devez avoir plus de 18 ans pour consulter ce site !
</p>
<br />
<h3>
    Centre AFPA / session DWWM
</h3>
<img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/img/afpa.png'; ?>" width="10%" />

<!-- message destiné au client pour lui expliquer comment tiliser le "shortcode" -->
<p>Comment afficher le plugin ?<br>
    Ajoutezz ce code php sous a balise body html <br>
    echo do_shortcode('[eu-disclaimer]') dans le fichier themes/oceanwp/templates/landing.php <br>
    <b>NB:</b> il ne faut pas oublier de décommenter la fonction <b>add_shortcode</b> dans <b>plugins/eu-discalimer</b>
</p>