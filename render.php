<?php

//error_reporting(1);
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

require_once(explode("wp-content", __FILE__)[0]."wp-load.php");
include_once(ABSPATH.'wp-includes/pluggable.php');

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $form_id      = $_GET['form_id'];
    $content_post = get_post($form_id);

    if (!$content_post) {
        echo "Form doesn't exist";
        return;
    }

    $content           = $content_post->post_content;
    $content_formatted = maybe_unserialize($content);
} else {
    echo "Methode not allowed";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <style>
        <?php echo $content_formatted['css']; ?>
    </style>
</head>
<body>
<?php echo $content_formatted['html']; ?>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>
    /*var notyf = new Notyf();

    for (let required of document.querySelectorAll('.ct-obligatoire')) {
        required.parentElement.classList.add('ct-obligatoire-container')
    }

    function checkRequired() {
        let required = document.querySelectorAll('.ct-obligatoire')

        required.forEach((element) => element.parentElement.classList.remove('has-validation', 'has-error'))

        let required_empty = Array.from(required).filter(element => element.value == '')

        if (required_empty.length > 0) {
            required_empty.forEach((element) => element.parentElement.classList.add('has-validation', 'has-error'))

            return false
        }

        return true;
    }*/

    function changeForm(current_selector, target_selector = null) {
        let current_step = $('#' + current_selector).closest("form");
        let target_step = $('#' + target_selector).closest("form");

        let isChecked = false;
        let answers = document.querySelectorAll('#'+current_selector+' .answer, #'+current_selector+' .input');

        answers.forEach((answer) => {
			console.log(answer, answer.type, answer.checked)

            if (answer.tagName === "INPUT") {
                if (answer.type === "radio" && answer.checked) isChecked = true;

                if (answer.type === "email") {
                    if (answer.value.length >= 7) isChecked = true;
                }

                if (answer.type === "text") {
					const inputType = answer.getAttribute('input_type');

                    console.log('inputType', inputType)
                    if (inputType === 'code_postal')
                    {
                        if (answer.value.length === 5) isChecked = true;
                        answer.classList.add("_valid");
					}
                    else if (inputType === 'telephone')
                    {
                        if (answer.value.length > 9) isChecked = true;
                    }
                    else if (inputType === 'email')
                    {
						const regexp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

						if (!answer.value.match(regexp))
                        {
							answer.classList.add('_error');
							answer.classList.remove("_valid");

						}
						else
                        {
							answer.classList.remove('_error');
							answer.classList.add("_valid");

							isChecked = true;
						}
                    }
                    else
                    {
                        if (answer.value.length >= 2) isChecked = true;
                    }
                }
            }
        });

        if (!answers) {
            isChecked = true;
        }

        if (!isChecked) {
            console.log('Step data not valid');
            return;
        }

        console.log('Step data valid');

        if(current_step[0]) {
            const is_type_submit = current_step[0].getAttribute('data-type-submit');
            const emails 		 = current_step[0].getAttribute('data-submit-emails');
            const redirectionUrl = current_step[0].getAttribute('data-submit-redirection');

            console.log('is_type_submit', is_type_submit)
            console.log('emails', emails)

            if(is_type_submit !== null) {
                let payload = [];
                let forms 	= document.querySelectorAll('form');

                forms.forEach((form) => {
                    let data 		= new FormData(form)
                    let formData 	= Array.from(data.entries())

                    console.log(formData)

                    for (const [name, value] of formData) {
                        payload.push({ name, value })
                    }
                });

                console.log('payload', payload);

                const origin_url = (window.location != window.parent.location)
                    ? document.referrer
                    : document.location.href;

                $.post("/wp-content/plugins/better-form/submit.php", { emails: emails, origin_url: origin_url, data: payload },
                    function(data, status){
                        console.log("Data: " + data + "\nStatus: " + status);

                        if(redirectionUrl !== null) {
                            window.location = redirectionUrl
                        }
                    });
            }
        }

        console.log('current_step', current_step)
        console.log('target_step', target_step)

        current_step.hide();

        if(target_step) {
            target_step.show();
        }
    }


    $('.radio-icon').click(function () {
        $(this).find("input[type=radio]").prop("checked", true);
        $(this).find("input[type=radio]").get(0).click();
    });

    //Radio Icon Event
    $('.step-container .radio-icon input.answer').click(function (event) {
        // Don't follow the link
        event.preventDefault();

        let target_id = event.target.closest('.div-block').getAttribute('target_id') ?? null
        let origin_id = event.target.closest('.step-container').getAttribute('id') ?? null

        if(target_id && origin_id) {
            changeForm(origin_id, target_id)
        }
    });

    //Normal Input Event
    $('.step-container button.button').click(function (event) {
        // Don't follow the link
        event.preventDefault();

        let target_id = event.target.getAttribute('target_id') ?? null
        let origin_id = event.target.closest('.step-container').getAttribute('id') ?? null

        if(origin_id) {
            changeForm(origin_id, target_id)
        }
    });

    $('form input').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
</script>
</html>
