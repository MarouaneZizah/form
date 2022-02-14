<?php
/*
Plugin Name: Form Plugin
Plugin URI:
Description: Form Plugin
Author: MTT
Author URI: http://maarouanezizah.com
Version: 0.1
*/

// error_reporting(1);
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

function add_form_menu(){
    add_menu_page(
        __('Forms'),
        __('Forms'),
        'edit_themes',
		'form-list',
		'form_list'
    );

    add_submenu_page(
        'form-list', 	//Parent
        __('New Form'),  	//Page title
        __('New Form'),  	//Menu title
        'edit_themes',   	//Capability,
        'form-editor', 	//menu slug
        'form_editor', 	//menu slug
    );
}

function form_list()
{
	include plugin_dir_path(__FILE__) . 'list.php';
}

function form_editor()
{
	include plugin_dir_path(__FILE__) . 'form.php';
}


add_action('admin_menu', 'add_form_menu');






function html_form_code() {
	echo '
	<div class="div-block-12" id="FormInner">
		<div class="blur"></div>

		<div class="fr_form fr_form0">
			<div class="infos">
				<p class="infos_p">Demande gratuite en 30 secondes <br> Données personnelles sécurisées</p>
			</div>
		</div>

		<div class="fr_form fr_form1 progress_bar">
			<div class="div_bar">
				<span class="the_bar"></span>
			</div>
		</div>

		<form name="formStep0" class="formulaire" data-field="situation" style="display:block">
			<div class="fr_form fr_form2">
				<h3 class="heading-8">Votre situation :</h3>
			</div>
			<div class="fr_form fr_form3">
				<div class="div-block-14">
					<div class="div-block-15">
						<p class="paragraph-8">PROPRIÉTAIRE</p>
					</div>
					<div class="div-block-16"><img src="'.plugin_dir_url( __FILE__ ).'/images/owner.png" loading="lazy" alt="" class="image-6"></div>
					<div class="div-block-17">
						<input type="radio" class="button-6 w-button answer answer0" name="situation" value="Propriétaire"></input>
					</div>
				</div>
				<div class="div-block-14">
					<div class="div-block-15">
						<p class="paragraph-8">LOCATAIRE</p>
					</div>
					<div class="div-block-16"><img src="'.plugin_dir_url( __FILE__ ).'/images/tenant.png" loading="lazy" alt="" class="image-6"></div>
					<div class="div-block-17">
						<input class="button-6 w-button answer answer0" type="radio" name="situation" value="Locataire"></input>
					</div>
				</div>
			</div>
			<div class="fr_form fr_form4">
				<button type="button" class="button-7 w-button continue">Continuer</button>
			</div>
		</form>

		<form name="formStep1" class="formulaire" data-field="logement" style="display:none">
			<div class="fr_form fr_form2">
				<h3 class="heading-8">Votre logement :</h3>
			</div>
			<div class="fr_form fr_form3">
				<div class="div-block-14">
					<div class="div-block-15">
						<p class="paragraph-8">MAISON</p>
					</div>
					<div class="div-block-16"><img src="'.plugin_dir_url( __FILE__ ).'/images/house.png" loading="lazy" alt="" class="image-6"></div>
					<div class="div-block-17">
						<input type="radio" class="button-6 w-button answer answer1" name="logement" value="Maison"></input>
					</div>
				</div>
				<div class="div-block-14">
					<div class="div-block-15">
						<p class="paragraph-8">APPARTEMENT</p>
					</div>
					<div class="div-block-16"><img src="'.plugin_dir_url( __FILE__ ).'/images/building.png" loading="lazy" alt="" class="image-6"></div>
					<div class="div-block-17">
						<input class="button-6 w-button answer answer1" type="radio" name="logement" value="Appartement"></input>
					</div>
				</div>
			</div>
			<div class="fr_form fr_form4">
				<button type="button" class="button-7 w-button continue">Continuer</button>
			</div>
		</form>

		<form name="formStep2" class="formulaire" data-field="chauffage" style="display:none">
			<div class="fr_form fr_form2">
				<h3 class="heading-8">Votre mode de chauffage :</h3>
			</div>
			<div class="fr_form fr_form3 fr_form_quad">
				<div class="div-block-14">
					<div class="div-block-15">
						<p class="paragraph-8">ELECTRCITE</p>
					</div>
					<div class="div-block-16"><img src="'.plugin_dir_url( __FILE__ ).'/images/electricity.png" loading="lazy" alt="" class="image-6"></div>
					<input class="btn_form_quad answer answer2" type="radio" value="electricite" name="chauffage"></input>
				</div>
				<div class="div-block-14">
					<div class="div-block-15">
						<p class="paragraph-8">GAZ</p>
					</div>
					<div class="div-block-16"><img src="'.plugin_dir_url( __FILE__ ).'/images/gas.png" loading="lazy" alt="" class="image-6"></div>
					<input class="btn_form_quad answer answer2" type="radio" value="gaz" name="chauffage"></input>
				</div>
				<div class="div-block-14">
					<div class="div-block-15">
						<p class="paragraph-8">FIOUL</p>
					</div>
					<div class="div-block-16"><img src="'.plugin_dir_url( __FILE__ ).'/images/oil.png" loading="lazy" alt="" class="image-6"></div>
					<input class="btn_form_quad answer answer2" type="radio" value="fioul" name="chauffage"></input>
				</div>
				<div class="div-block-14">
					<div class="div-block-15">
						<p class="paragraph-8">AUTRE</p>
					</div>
					<div class="div-block-16"><img src="'.plugin_dir_url( __FILE__ ).'/images/wood.png" loading="lazy" alt="" class="image-6"></div>
					<input class="btn_form_quad answer answer2" type="radio" value="autre" name="chauffage"></input>
				</div>
			</div>
			<div class="fr_form fr_form4 quad">
				<button type="button" class="button-7 w-button continue">Continuer</button>
			</div>
		</form>

		<form name="formStep3" class="formulaire formulaire4" data-field="codePostal" style="height: 85%; display:none">
			<div class="fr_form fr_form4" style="height: 30% !important;">
				<h3 class="heading-8">Votre code postal ?</h3>
			</div>
			<div class="fr_form fr_form4" style="height: 40% !important; align-items: flex-start;">
				<div class="div-block-19" style="margin-top: 25px;">
					<label class="form-label" for="">Code Postale</label>
					<input inputmode="decimal" type="text" autocomplete="postal-code" placeholder="75001" class="input-8 answer answer3 answerCodePostal noContinue" onBlur="check_Validity(\'answerCodePostal\')">
				</div>
			</div>
			<div class="fr_form fr_form4">
				<button type="button" class="button-7 w-button continue">Continuer</button>
			</div>
		</form>

		<form name="formStep4" class="formulaire form5" data-field="loading" style="display:none">
			<div class="form5_img">
				<img src="'.plugin_dir_url( __FILE__ ).'/images/loading@3x.png" alt="loading" loading="lazy">
			</div>
			<div class="form5_text">
				<p>Demande gratuite en 30 secondes <br> Données personnelles sécurisées</p>
			</div>
		</form>

		<form name="formStep5" class="formulaire form6" data-field="email" style="height: 85%; display:none">
			<div class="fr_form fr_form4" style="height: 30% !important;">
				<h3 class="heading-8">A quel email souhaitez-vous recevoir votre devis ?</h3>
			</div>
			<div class="fr_form fr_form4" style="height: 40% !important; align-items: flex-start;">
				<div class="div-block-19" style="margin-top: 25px;">
					<label class="form-label" for="">Email</label>
					<input name="email" type="email" placeholder="test@gmail.com" class="input-8 answer answer5 answerEmail noContinue" onBlur="check_Validity(\'answerEmail\')">
				</div>
			</div>
			<div class="fr_form fr_form4">
				<button type="button" class="button-7 w-button continue">Continuer</button>
			</div>
		</form>

		<form name="formStep6" class="formulaire form7" data-field="coordonnées" style="display:none">
			<div class="fr_form fr_form2" style="height: 10% !important;">
				<h3 class="heading-8" style="text-align: center;">Vos coordonnées :</h3>
			</div>
			<div class="fr_form fr_form3">
				<div class="div-block-19">
					<label class="form-label" for="">Nom</label>
					<input name="full_name" type="text" placeholder="Nom" class="input-9 answer answer6 noContinue name full_name" onBlur="check_Validity(\'full_name\')">

					<label class="form-label" for="">Numéro de téléphone</label>
					<input name="phone" inputmode="decimal" type="text" placeholder="Numéro de téléphone" class="input-9 answer answer6 noContinue telephone phone" onBlur="check_Validity(\'phone\')">

					<div class="cgu">
						<input type="radio" value="cgu" name="cgu" class="cgu_btn">
						<p class="cgu_text" style="padding-left: 15px;">J’accepte les conditions générales d’utilisation et le traitement de mes données.</p>
					</div>
				</div>
			</div>

			<div class="fr_form fr_form4 lastForm">
				<button disabled="true" type="submit" class="button-7 w-button finish" id="btn_finish" style="height: 90%;">VALIDER</button>
			</div>

			<div class="donnees">
				<p class="donnees_text">Données personnelles sécurisées</p>
			</div>
		</form>

		<form name="formStep7" class="formulaire form8" style="display: none;">
			<div class="FinForm" display="none">
				<p>
					FELICITATION ! Le résultat montre que vous pourriez être éligible !
					<br><br> Un conseiller expert en panneaux solaires vous recontactera sous 24h pour vous expliquer le but du programme et valider vos informations
					<br><br> N’hésitez pas à consulter notre page sur les pompes à chaleur pour estimer les économies de chauffage que vous pourriez faire en
					<a style="color: white !important" href="#">cliquant ici.</a>
				</p>
			</div>
		</form>
	</div>
	';
}


function shapeSpace_print_scripts() {
	?>
	<script>
		function checkEmail(email) {
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}

		function check_Validity(className) {
			const input_answers = document.getElementsByClassName(className);
			const input_answer = input_answers[0]

			console.log('check_Validity', className, input_answers, input_answer)

			if (input_answer.classList.contains('_valid')) input_answer.classList.remove('_valid')
			if (input_answer.classList.contains('_error')) input_answer.classList.remove('_error')

			if (className == 'answerCodePostal') {
				if (input_answer.value.length == 5) {
					input_answer.classList.add('_valid')
				} else {
					input_answer.classList.add('_error')
				}
			} else if (className == 'phone') {
				if (input_answer.value.length == 10 || input_answer.value.length == 12 || input_answer.value.length == 13) {
					input_answer.classList.add('_valid')
				} else {
					input_answer.classList.add('_error')
				}
			} else if (className == 'full_name') {
				if (input_answer.value.length > 1) {
					input_answer.classList.add('_valid')
				} else {
					input_answer.classList.add('_error')
				}
			} else if (className == 'answerEmail') {
				if (checkEmail(input_answer.value)) {
					input_answer.classList.add('_valid')
				} else {
					input_answer.classList.add('_error')
				}
			}
		}
	</script>
	<?php
}


function my_enqueued_assets() {
	wp_enqueue_script( 'jquery');
	wp_enqueue_script('my-js-file', plugin_dir_url(__FILE__) . '/js/form.js', '', time());
	wp_enqueue_style('my-css-file', plugin_dir_url(__FILE__) . '/css/form.css', '', time());
}


add_action('wp_print_scripts', 'shapeSpace_print_scripts');
add_action('wp_enqueue_scripts', 'my_enqueued_assets');


function cf_shortcode() {
    ob_start();
    html_form_code();

    return ob_get_clean();
}

add_shortcode( 'mz_contact_form', 'cf_shortcode' );
