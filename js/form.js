/*formulaire jquery */
console.log('ok')

jQuery(document).ready(function($) {
	console.log('ready')

	var options = document.querySelectorAll('.div-block-14');

	options.forEach(option => {
		console.log('sup')

		option.addEventListener('click', function() {
			if (this.children[2].tagName == "INPUT") {
				this.children[2].click();
			} else {
				this.children[2].children[0].click();
			}
		})
	});

	$('.answer').click(function() {
		if (!$(this).hasClass('noContinue')) {
			$(this).closest('form').find('.continue').click()
		}
	})

    $("form").bind("keypress", function(e) {
        if (e.keyCode == 13) {
            console.log("test");
            $(this).find(".w-button.continue").click();
            return false;
        }
    });

    var $forms = $("#FormInner form");

    var $bar = $(".the_bar");
    $bar.css("width", (1 / $forms.length) * 100 + "%");
    var fields = {
        full_name: "",
        phone: "",
        own_state: "",
        chauffage: "",
        zip: "",
        type_habitation: "",
        email: "",
        country: "FRA",
        url_presale: document.domain,
        utm_source: getParameterBySource(),
        utm_medium: getParameterByName("utm_medium"),
        utm_campaign: getParameterByName("utm_campaign") + "_" + getParameterByName("utm_term"),
    };
    var $submit = $forms.find("button[type=submit]");
    var formValid = false;

    $forms.find("button[type=button]").click(function(e) {
        // $(".simFormhide").hide();
        e.preventDefault();
        var $target = $(e.target);
        if ($target.hasClass("continue")) {
            //Vérifier que le bouton cliqué est bien un bouton pour continuer le form
            changeForm($target);
        }
    });

    $forms.find("button[type=submit]").click(function(e) {
        const cgu = $(".cgu_btn")[0];
        if (cgu.checked) {
            document.getElementById("btn_finish").disabled = false;
        }

        e.preventDefault();
        var $target = $(e.target);
        var $inputs = $target.closest("form").find(".answer");

        var ko = false;

        var own_state = "";
        var situations = document.getElementsByName("situation");
        for (var i = 0; i < situations.length; i++) {
            if (situations[i].checked) {
                own_state = situations[i].value;
            }
        }
        fields["own_state"] = own_state;

        var type_habitation = "";
        var logements = document.getElementsByName("logement");
        for (var i = 0; i < logements.length; i++) {
            if (logements[i].checked) {
                type_habitation = logements[i].value;
            }
        }
        fields["type_habitation"] = type_habitation;

        var chauffage = "";
        var chauffages = document.getElementsByName("chauffage");
        for (var i = 0; i < chauffages.length; i++) {
            if (chauffages[i].checked) {
                chauffage = chauffages[i].value;
            }
        }
        fields["chauffage"] = chauffage;

        var zip = $(".answerCodePostal")[0].value;
        fields["zip"] = zip;
        var email = $(".answerEmail")[0].value;
        fields["email"] = email;

        var full_name = "";
        var phone = "";
        $inputs.each(function(index, element) {
            var name = $(element).attr("name");
            var value = $(element).val();
            if (name === "full_name") full_name = value;
            if (name === "phone")
                phone = value.toString().replace(/ /g, "").split(".").join("");
            if (!value) ko = true;
            name === "phone" ?
                (fields[name] = value
                    .toString()
                    .replace(/ /g, "")
                    .split(".")
                    .join("")) :
                (fields[name] = value);
        });

        if (ko) return alert("Veuillez remplir tous les champs");
        if (!phone.match(
                /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im
            ))
            return alert("Le téléphone est incorrect");
        if (!zip.match(/^\d{5}$/)) return alert("Le code postal est incorrect");
        if (!email.match(/\S+@\S+\.\S+/))
            return alert("L'adresse e-mail saisie est incorrecte");

        $(".progress_bar").hide();
        $(".fr_form0").hide();

        changeForm($target);

        console.log('fields', fields);

        $.ajax({
            type: "POST",
            url: "http://localhost/wp-content/plugins/better-form/submit.php",
            data: fields,
            success: function() {
                dataLayer.push({
                    event: "lead"
                });
                window.location.hash = "confirm";
            },
            error: (error) => {
                console.log(fields);
                // console.log(error);
            },
        });
    });

    $(".cgu_btn").click(function() {
        document.getElementById("btn_finish").disabled = false;
    });

    $(".cgu_text").click(function() {
        $(this).siblings().click();
    });

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        if (results === null) {
            results = regex.exec(document.referrer);
        }
        return results === null ?
            "" :
            decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    function getParameterBySource() {
        if (getParameterByName("gclid")) return "google";
        else if (getParameterByName("fbclid")) return "facbook";
        else if (getParameterByName("utm_source") == "taboola") return "taboola";
        return getParameterByName("utm_source");
    }

    function changeForm($target) {
        var isChecked = false;
        var $curForm = $target.closest("form");
        var curIndex = $forms.index($curForm);
        // if (typeof $curForm.attr("data-field") !== "undefined") {
        //     fields[$curForm.attr("data-field")] = $target.val();
        // }
        var answers = document.querySelectorAll(".answer" + curIndex);
        answers.forEach((answer) => {
            if ((answer.tagName = "INPUT")) {
                if (answer.type == "radio") {
                    if (answer.checked) isChecked = true;
                }
                if (answer.type == "text") {
                    if (answer.classList.contains("answerCodePostal")) {
                        if (answer.value.length == 5) isChecked = true;
                        answer.classList.add("_valid");
                    } else if (answer.classList.contains("answerEmail")) {
                        if (answer.value.length > 9) isChecked = true;
                    } else {
                        if (answer.value.length >= 2) isChecked = true;
                    }
                }
                if (answer.type == "email") {
                    if (answer.value.length >= 7) isChecked = true;
                }
            }
        });

        if (!answers) {
            isChecked = true;
        }

        if (isChecked) {
            $($forms[curIndex]).hide();
            if (curIndex == 3) {
                // Si l'on arrive au form de chargement, on attent 1.5 sec et on passe à la prochaine page
                $($forms[curIndex + 1]).show();
                var angle = 0;
                $(".infos").css({
                    height: "90%",
                });
                document.getElementsByClassName("infos_p")[0].innerHTML =
                    "Merci de bien vouloir patienter. Nous recherchons un professionnel dans votre secteur";
                $(".fr_form1").hide();
                setInterval(function() {
                    // Faire tourner l'image de chargement
                    $(".form5_img img").css({
                        transform: "rotate(" + angle + "deg)"
                    });
                    angle += 20;
                }, 80);
                setTimeout(function() {
                    // Afficher le chargement seulement pendant 1.5sec puis passer à la page d'après du form
                    $($forms[curIndex + 1]).hide();
                    $($forms[curIndex + 2]).show();
                    $(".fr_form1").show();
                    document.getElementsByClassName("infos_p")[0].innerHTML =
                        "Génial ! Nous avons trouvé un professionnel RGE dans votre région !";
                    $(".infos").css({
                        "background-image": "linear-gradient(to bottom, #004e0e, #219632)",
                        height: "70%",
                    });
                }, 1500);
            } else if (curIndex == 5) {
                document.getElementsByClassName("infos_p")[0].innerHTML =
                    "Dernière étape ! Remplissez vos coordonnées pour recevoir le résultat du test.";
                $(".infos").css({
                    "background": "linear-gradient(36deg, #415a6b, #2a6892)",
                });
                $(".fr_form0").css({
                    height: "20%",
                });
                $(".fr_form1").css({
                    height: "5%",
                });
                $(".fr_form1").css({
                    height: "5%",
                });
                $($forms[curIndex + 1]).show();
            } else {
                $($forms[curIndex + 1]).show();
            }
            $bar.css("width", ((curIndex + 2) / $forms.length) * 100 + "%");
        }
    }
});