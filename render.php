<?php
session_start();

require_once(explode("wp-content", __FILE__)[0]."wp-load.php");
include_once(ABSPATH.'wp-includes/pluggable.php');

error_reporting(1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $form_id      = $_GET['id'];
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
    <title>Script</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <style>
        <?php echo $content_formatted['styles']; ?>
    </style>
</head>
<body>
<?php
echo $content_formatted['html']; ?>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>
    var notyf = new Notyf();

    for (let required of document.querySelectorAll('.ct-obligatoire')) {
        required.parentElement.classList.add('ct-obligatoire-container')
    }

    let radio_icon_options = document.querySelectorAll('.radio-icon');

    radio_icon_options.forEach(option => {
        option.addEventListener('click', function() {
            if (this.children[2].tagName == "INPUT") {
                this.children[2].click();
            } else {
                this.children[2].children[0].click();
            }
        })
    });

    function checkRequired() {
        let required = document.querySelectorAll('.ct-obligatoire')

        required.forEach((element) => element.parentElement.classList.remove('has-validation', 'has-error'))

        let required_empty = Array.from(required).filter(element => element.value == '')

        if (required_empty.length > 0) {
            required_empty.forEach((element) => element.parentElement.classList.add('has-validation', 'has-error'))

            return false
        }

        return true;
    }

    function changeForm(current_selector, target_selector) {
        let current_step = $('#' + current_selector).closest("form");
        let target_step = $('#' + target_selector).closest("form");

        let isChecked = false;
        let answers = document.querySelectorAll('#' + current_selector + " .answer");

        console.log(current_selector, target_selector)
        console.log('changeForDm', current_step, target_step);

        answers.forEach((answer) => {
            if ((answer.tagName = "INPUT")) {
                if (answer.type == "radio") {
                    if (answer.checked) isChecked = true;
                }
                if (answer.type == "text") {
                    if (answer.classList.contains("code-postal")) {
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

        console.log('answers isChecked', isChecked);

        if (!answers) {
            isChecked = true;
        }

        if (isChecked) {
            current_step.hide();
            target_step.show();
            // $bar.css("width", ((curIndex + 2) / $forms.length) * 100 + "%");
        } else {
            console.log('Form not valid');
        }

        /*        if (event.target.closest('.goto-node')) {
                    let target_id = event.target.getAttribute('target_id')
                    let target = document.getElementById(target_id);
                    let target_siblings = target.parentNode.childNodes

                    target.classList.remove('hide')

                    for (target_sibling in target_siblings) {
                        let sibling = target_siblings[target_sibling];
                        let tag_name = sibling.tagName;

                        if (!tag_name) {
                            continue;
                        }

                        if (sibling.id != target_id && tag_name !== 'SCRIPT' && tag_name !== 'LINK' && tag_name !== 'STYLE') {
                            sibling.classList.add('hide')
                        }
                    }

                    return;
                }*/
    }

</script>
</html>
