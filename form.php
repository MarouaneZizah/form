<?php
echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__).'css/fontawesome/css/all.min.css">';
echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__).'css/bulma.css">';
echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__).'css/grapes.min.css">';
echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__).'css/script-editor.css">';

echo '<script src="'.plugin_dir_url(__FILE__).'js/axios.min.js"></script>';
echo '<script src="'.plugin_dir_url(__FILE__).'js/grapes.min.js"></script>';
?>

<div class="editor-row">
    <div class="editor-canvas">
        <div id="gjs">
            <?php
            echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__).'css/bulma.css">';
            echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__).'css/script.css">';
            ?>

            <div class="container box"></div>
        </div>
    </div>
</div>

<script>
    const campagne = null;

    let editor = null;
    let list_cadres = []
    let colonnes_ct = [];

    const typeCadre = 'cadre';
    const typeForm = 'Formulaire';
    const typeCadre1Col = 'cadre-one-col';
    const typeCadre2Col = 'cadre-two-col';
    const typeCadre3Col = 'cadre-three-col';
    const typeCadre4Col = 'cadre-four-col';
    const typeCadre3_9Col = 'cadre-three-nine-col';
    const typeCadre9_3Col = 'cadre-nine-three-col';
    const typeParagraphe = 'paragraphe';
    const typeChampCt = 'champ-ct'
    const typeTexte = 'texte'
    const typeLink = 'link'
    const typeImage = 'image'
    const typeH1 = 'h1'
    const typeH2 = 'h2'
    const typeH3 = 'h3'
    const typeH4 = 'h4'

    const typeInput = 'input';
    const typeTextarea = 'textarea';
    const typeSelect = 'select';
    const typeCheckbox = 'checkbox';
    const typeCheckboxLabel = 'checkbox-label';
    const typeRadio = 'radio';
    const typeButton = 'button';
    const typeButtonGotoNode = 'button-goto';
    const typeLabel = 'label';
    const typeOption = 'option';

    const catCadres = {id: 'cadres', label: 'Cadres', open: true}
    const catForm = {id: 'forms', label: 'Formulaires', open: false}
    const catChampsCt = {id: 'champs_ct', label: 'Champs CT', open: false}
    const catTitres = {id: 'titres', label: 'Titres', open: false}
    const catActions = {id: 'buttons', label: 'Actions', open: false}

    function initGrape() {

        const idTrait = {name: 'id',};

        const forTrait = {name: 'for',};

        const nodeIdTrait = {
            name: 'node_id',
            label: 'Node ID',
            type: 'text'
        };

        const nodeVisibleTrait = {
            type: 'checkbox',
            label: 'Visible',
            name: 'visible',
            checked: true,
        };

        const colonneTrait = {
            label: 'Colonne CT',
            name: 'name',
            type: 'select',
            options: colonnes_ct,
        };

        const nodesTrait = {
            label: 'ID Cadre',
            name: 'target_id',
            type: 'select',
            options: list_cadres,
        };

        const valueTrait = {
            name: 'default_value',
            label: 'Valeur par défaut',
        };

        const labelTrait = {
            name: 'text',
            label: 'Texte',
        };

        const requiredTrait = {
            type: 'checkbox',
            name: 'obligatoire',
        };

        const checkedTrait = {
            type: 'checkbox',
            name: 'checked',
        };

        const myNewComponentTypes = editor => {
            const domc = editor.DomComponents

            domc.addType(typeChampCt, {
                isComponent: el => el.tagName == 'SPAN' && el.classList.contains('ct-span'),
                model: {
                    defaults: {
                        tagName: 'span',
                        attributes: {'class': 'ct-span ml-1 mr-1'},
                        droppable: false,
                        copyable: false,
                        toolbar: [{attributes: {class: 'fas fa-trash-alt'}, command: 'tlb-delete'}],
                    },
                },
            });

            domc.addType(typeH1, {
                isComponent: el => el.tagName == 'h1',
                model: {
                    defaults: {
                        tagName: 'h1',
                        attributes: {'class': 'title is-1'},
                        selectable: true,
                        toolbar: [{attributes: {class: 'fas fa-trash-alt'}, command: 'tlb-delete'}],
                        components: [{
                            type: 'text',
                            components: 'Titre H1',
                            selectable: true,
                        }]
                    },
                },
            });

            domc.addType(typeH2, {
                isComponent: el => el.tagName == 'h2',
                model: {
                    defaults: {
                        tagName: 'h2',
                        attributes: {'class': 'title is-2'},
                        selectable: true,
                        toolbar: [{attributes: {class: 'fas fa-trash-alt'}, command: 'tlb-delete'}],
                        components: [{
                            type: 'text',
                            components: 'Titre H2',
                            selectable: false,
                        }]
                    },
                },
            });

            domc.addType(typeH3, {
                isComponent: el => el.tagName == 'h3',
                model: {
                    defaults: {
                        tagName: 'h3',
                        attributes: {'class': 'title is-3'},
                        selectable: true,
                        toolbar: [{attributes: {class: 'fas fa-trash-alt'}, command: 'tlb-delete'}],
                        components: [{
                            type: 'text',
                            components: 'Titre H3',
                            selectable: false,
                        }]
                    },
                },
            });

            domc.addType(typeH4, {
                isComponent: el => el.tagName == 'h4',
                model: {
                    defaults: {
                        tagName: 'h4',
                        attributes: {'class': 'title is-4'},
                        selectable: true,
                        toolbar: [{attributes: {class: 'fas fa-trash-alt'}, command: 'tlb-delete'}],
                        components: [{
                            type: 'text',
                            components: 'Titre H4',
                            selectable: false,
                        }]
                    },
                },
            });

            domc.addType(typeTexte, {
                isComponent: el => el.tagName == 'span' && el.classList.contains('span-text'),
                model: {
                    defaults: {
                        tagName: 'span',
                        name: 'texte',
                        toolbar: [{attributes: {class: 'fas fa-trash-alt'}, command: 'tlb-delete'}],
                        selectable: true,
                        // attributes: {'class': 'pl-1 pr-1'},
                        classes: ['pl-1', 'pr-1'],
                        stylable: false,
                        components: [{
                            type: 'text',
                            tagName: 'span',
                            // attributes: {'class': 'span-text'},
                            classes: ['span-text'],
                            stylable: true,
                            selectable: true,
                            components: 'Modifier le texte',
                        }]
                    },
                },
            });

            domc.addType(typeLink, {
                isComponent: el => el.tagName == 'a',

                model: {
                    defaults: {
                        tagName: 'span',
                        attributes: {'class': 'pl-1 pr-1'},
                        toolbar: [{attributes: {class: 'fas fa-trash-alt'}, command: 'tlb-delete'}],
                        selectable: true,
                        components: [{
                            type: 'link',
                            tagName: 'a',
                            components: 'Texte du lien',
                            attributes: {'target': '_blank'},
                            traits: ['title', 'href'],
                            toolbar: [],
                            selectable: false,
                        }]
                    },
                },
            });

            domc.addType(typeCadre, {
                model: {
                    defaults: {
                        droppable: false,
                        draggable: '.container, .cadre_script > *',
                        copyable: false,
                        toolbar: [{attributes: {class: 'fas fa-trash-alt'}, command: 'tlb-delete'}],
                        //traits: [nodeIdTrait, nodeVisibleTrait],
                    },
                    init() {
                        this.on('change:attributes:visible', this.handleVisibleChange);
                    },

                    handleVisibleChange() {
                        let visible = this.getAttributes().visible
                        let classes = this.getAttributes().class.split(/\s+/)

                        if (visible) {
                            if (classes.includes('hidden')) {
                                return
                            } else {
                                classes = classes.filter(item => item != 'hidden')
                            }
                        } else {
                            if (!classes.includes('hidden')) {
                                classes.push('hidden')
                            } else {
                                return
                            }
                        }
                        this.setAttributes({'class': classes})
                    },
                },
            });

            domc.addType(typeCadre1Col, {
                extend: typeCadre,
                isComponent: el => el.tagName == 'DIV' && el.classList.contains('one-column'),

                model: {
                    defaults: {
                        tagName: 'div',
                        attributes: {'class': 'columns one-column mt-2 cadre_script', 'visible': true},
                        components: [
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-12'},
                                // droppable: false,
                                draggable: false,
                                copyable: false,
                                selectable: false,
                            }
                        ]
                    },
                },
            });

            domc.addType(typeCadre2Col, {
                extend: typeCadre,
                isComponent: el => el.tagName == 'DIV' && el.classList.contains('two-column'),

                model: {
                    defaults: {
                        tagName: 'div',
                        attributes: {'class': 'columns two-column mt-2 cadre_script', 'visible': true},
                        components: [
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-half mb-0'},
                                draggable: false,
                                copyable: false,
                                selectable: false,
                            },
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-half mb-0'},
                                draggable: false,
                                copyable: false,
                                selectable: false,
                            }
                        ]
                    },
                },
            });

            domc.addType(typeCadre3Col, {
                extend: typeCadre,
                isComponent: el => el.tagName == 'DIV' && el.classList.contains('three-column'),

                model: {
                    defaults: {
                        tagName: 'div',
                        attributes: {'class': 'columns three-column mt-2 cadre_script', 'visible': true},
                        components: [
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-4 mb-0'},
                                draggable: false,
                                copyable: false,
                                selectable: false,
                            },
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-4 mb-0'},
                                draggable: false,
                                copyable: false,
                                selectable: false,
                            },
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-4 mb-0'},
                                draggable: false,
                                copyable: false,
                                selectable: false,
                            }
                        ]
                    },
                },
            });

            domc.addType(typeCadre4Col, {
                extend: typeCadre,
                isComponent: el => el.tagName == 'DIV' && el.classList.contains('four-column'),

                model: {
                    defaults: {
                        tagName: 'div',
                        attributes: {'class': 'columns four-column mt-2 cadre_script', 'visible': true},
                        components: [
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-3 mb-0'},
                                draggable: false,
                                copyable: false,
                                selectable: false,
                            },
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-3 mb-0'},
                                draggable: false,
                                copyable: false,
                                selectable: false,
                            },
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-3 mb-0'},
                                draggable: false,
                                copyable: false,
                                selectable: false,
                            },
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-3 mb-0'},
                                draggable: false,
                                copyable: true,
                                selectable: true,
                            }
                        ]
                    },
                },
            });

            domc.addType(typeCadre3_9Col, {
                extend: typeCadre,
                isComponent: el => el.tagName == 'DIV' && el.classList.contains('three-nine-column'),

                model: {
                    defaults: {
                        tagName: 'div',
                        attributes: {'class': 'columns three-nine-column mt-2 cadre_script', 'visible': true},
                        components: [
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-3 mb-0'},
                                draggable: false,
                                copyable: true,
                                selectable: true,
                            },
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-9 mb-0'},
                                draggable: false,
                                copyable: true,
                                selectable: true,
                            },
                        ]
                    },
                },
            });

            domc.addType(typeCadre9_3Col, {
                extend: typeCadre,
                isComponent: el => el.tagName == 'DIV' && el.classList.contains('three-nine-column'),

                model: {
                    defaults: {
                        tagName: 'div',
                        attributes: {'class': 'columns three-nine-column mt-2 cadre_script', 'visible': true},
                        components: [
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-9 mb-0'},
                                draggable: false,
                                copyable: true,
                                selectable: true,
                            },
                            {
                                tagName: 'div',
                                attributes: {'class': 'column is-3 mb-0'},
                                draggable: false,
                                copyable: true,
                                selectable: true,
                            },
                        ]
                    },
                },
            });

            domc.addType(typeForm, {
                extend: typeCadre,
                isComponent: el => el.tagName == 'DIV' && el.classList.contains('form-layout'),
                model: {
                    defaults: {
                        tagName: 'div',
                        attributes: {
                            'class': 'form-layout mt-2 cadre_script',
                            'style': 'max-width: none',
                            'visible': true
                        },
                        droppable: false,
                        copyable: false,
                        components: [{
                            tagName: 'div',
                            attributes: {'class': 'form-outer'},
                            droppable: false,
                            draggable: false,
                            copyable: false,
                            selectable: false,
                            components: [{
                                tagName: 'div',
                                attributes: {'class': 'form-body'},
                                draggable: false,
                                selectable: false,
                                components: [{
                                    tagName: 'form',
                                    draggable: false,
                                    selectable: false,
                                    attributes: {'id': 'form-ct-script', method: 'post'},
                                    components: [{
                                        tagName: 'div',
                                        draggable: false,
                                        selectable: false,
                                        attributes: {'class': 'form-section form-components p-2 mb-2'},
                                    }]
                                }]
                            }]
                        }]
                    },
                },

                view: {
                    events: {
                        submit: e => e.preventDefault(),
                    }
                },
            });

            // INPUT
            domc.addType(typeInput, {
                isComponent: el => el.tagName == 'INPUT',
                model: {
                    defaults: {
                        tagName: 'input',
                        draggable: false,
                        droppable: false,
                        copyable: false,
                        highlightable: false,
                        attributes: {type: 'text', class: "input form-ct-input"},
                        toolbar: [{attributes: {class: 'fas fa-trash-alt'}, command: 'tlb-delete'}],
                        traits: [
                            colonneTrait,
                            requiredTrait
                        ],
                    },
                    init() {
                        this.on('change:attributes:obligatoire', this.handleObligatoireChange);
                        this.on('change:attributes:name', this.handleNameChange);
                    },
                    handleObligatoireChange() {
                        (this.getAttributes().obligatoire) ? this.addClass('ct-obligatoire') : this.removeClass('ct-obligatoire');
                    },
                    handleNameChange() {
                        if (this.getAttributes().name) {
                            this.setAttributes({
                                name: this.getAttributes().name,
                                value: `@{{{${this.getAttributes().name}}}}`
                            })
                        }
                    }
                },
                extendFnView: ['updateAttributes'],
                view: {
                    updateAttributes() {
                        this.el.setAttribute('autocomplete', 'off');
                    },
                }
            });

            // TEXTAREA
            domc.addType(typeTextarea, {
                extend: typeInput,
                isComponent: el => el.tagName == 'TEXTAREA',

                model: {
                    defaults: {
                        tagName: 'textarea',
                        draggable: false,
                        droppable: false,
                        copyable: false,
                        attributes: {class: "textarea form-ct-input"},
                        traits: [
                            colonneTrait,
                            requiredTrait
                        ]
                    },
                    init() {
                        this.on('change:attributes:obligatoire', this.handleObligatoireChange);
                        this.on('change:attributes:name', this.handleNameChange);
                    },
                    handleObligatoireChange() {
                        (this.getAttributes().obligatoire) ? this.addClass('ct-obligatoire') : this.removeClass('ct-obligatoire');
                    },
                    handleNameChange() {
                        if (this.getAttributes().name) {
                            this.empty().append(`@{{{${this.getAttributes().name}}}}`)
                        }
                    }
                },
            });

            // OPTION
            domc.addType(typeOption, {
                isComponent: el => el.tagName == 'OPTION',
                model: {
                    defaults: {
                        tagName: 'option',
                        layerable: false,
                        droppable: false,
                        draggable: false,
                        highlightable: false,
                    },
                },
            });

            const createOption = (value, name) => ({type: typeOption, components: name, attributes: {value}});

            // SELECT
            domc.addType(typeSelect, {
                extend: typeInput,
                isComponent: el => el.tagName == 'SELECT',

                model: {
                    defaults: {
                        tagName: 'select',
                        attributes: {class: 'form-ct-input'},
                        components: [
                            createOption('opt1', 'Option 1'),
                            createOption('opt2', 'Option 2'),
                        ],
                        traits: [
                            colonneTrait,
                            {
                                name: 'options',
                                type: 'select-options'
                            },
                            requiredTrait
                        ],
                    },
                    init() {
                        this.on('change:attributes:obligatoire', this.handleObligatoireChange);
                    },
                    handleObligatoireChange() {
                        let obligatoire = this.getAttributes().obligatoire
                        this.setClass(`input form-ct-input ${obligatoire ? 'ct-obligatoire' : ''}`);
                    },
                },

                view: {
                    events: {
                        mousedown: e => e.preventDefault(),
                    },
                },
            });

            // CHECKBOX
            domc.addType(typeCheckbox, {
                extend: typeInput,
                isComponent: el => el.tagName == 'INPUT' && el.type == 'checkbox',

                model: {
                    defaults: {
                        attributes: {type: 'checkbox', class: 'form-ct-input'},
                        traits: [
                            idTrait,
                            colonneTrait,
                            valueTrait,
                            requiredTrait,
                            checkedTrait
                        ],
                    },
                },

                view: {
                    events: {
                        click: e => e.preventDefault(),
                    },

                    init() {
                        this.listenTo(this.model, 'change:attributes:checked', this.handleChecked);
                    },

                    handleChecked() {
                        this.el.checked = !!this.model.get('attributes').checked;
                    },
                },
            });

            // CHECKBOX LABEL
            domc.addType(typeCheckboxLabel, {
                extend: typeInput,
                isComponent: el => el.tagName == 'INPUT' && el.type == 'checkbox',
                model: {
                    // init() {
                    //   this.on('change:attributes:text', this.handleTextChange);
                    // },
                    // handleTextChange(model) {
                    //   this.components().models[2].getEl().textContent = this.getAttributes().text
                    // },
                    defaults: {
                        tagName: 'label',
                        copyable: false,
                        attributes: {class: 'checkbox'},
                        components: [{
                            tagName: 'input',
                            attributes: {type: 'checkbox', class: 'form-ct-input'},
                        }, {
                            tagName: 'span',
                        }
                        ],
                        traits: [colonneTrait, labelTrait, requiredTrait,],
                    },
                },

                view: {
                    events: {
                        click: e => e.preventDefault(),
                    },

                    init() {
                        this.listenTo(this.model, 'change:attributes:checked', this.handleChecked);
                    },

                    handleChecked() {
                        this.el.checked = !!this.model.get('attributes').checked;
                    },
                },
            });

            // RADIO
            domc.addType(typeRadio, {
                extend: typeCheckbox,
                isComponent: el => el.tagName == 'INPUT' && el.type == 'radio',

                model: {
                    defaults: {
                        attributes: {type: 'radio', class: 'form-ct-input'},
                    },
                },
            });

            domc.addType(typeButton, {
                extend: typeInput,
                isComponent: el => el.tagName == 'BUTTON',

                model: {
                    defaults: {
                        tagName: 'button',
                        droppable: false,
                        draggable: ':not(form)',
                        attributes: {type: 'button', class: "button h-button is-primary"},
                        text: 'Valider',
                        traits: [
                            {
                                name: 'text',
                                changeProp: true,
                            },
                            {
                                name: 'outlined',
                                type: 'checkbox'
                            },
                            {
                                name: 'clair',
                                type: 'checkbox'
                            },
                            {
                                type: 'select',
                                name: 'couleur',
                                options: [
                                    {value: 'primary'},
                                    {value: 'success'},
                                    {value: 'info'},
                                    {value: 'danger'},
                                    {value: 'warning'},
                                    {value: 'light'},
                                    {value: 'dark'},
                                ]
                            }
                        ]
                    },

                    init() {
                        const comps = this.components();
                        const tChild = comps.length === 1 && comps.models[0];
                        const chCnt = (tChild && tChild.is('textnode') && tChild.get('content')) || '';
                        const text = chCnt || this.get('text');
                        this.set({text});
                        this.on('change:text', this.__onTextChange);
                        this.on('change:attributes:couleur', this.__onColorChange);
                        this.on('change:attributes:outlined', this.__onOutlinedChange);
                        this.on('change:attributes:clair', this.__onClairChange);
                        (text !== chCnt) && this.__onTextChange();
                    },

                    __onTextChange() {
                        this.components(this.get('text'));
                    },
                    __onColorChange() {
                        let color = this.getAttributes().couleur
                        let outlined = (this.getAttributes().outlined ? 'is-outlined' : '')
                        let clair = (this.getAttributes().clair ? 'is-light' : '')
                        this.setClass(`button h-button is-${color} ${clair} ${outlined}`);
                    },
                    __onOutlinedChange() {
                        let color = this.getAttributes().couleur
                        let clair = (this.getAttributes().clair ? 'is-light' : '')
                        if (this.getAttributes().outlined) {
                            this.setClass(`button h-button is-${color} ${clair} is-outlined`);
                        } else {
                            this.setClass(`button h-button is-${color} ${clair}`);
                        }
                    },
                    __onClairChange() {
                        let color = this.getAttributes().couleur
                        let outlined = (this.getAttributes().outlined ? 'is-outlined' : '')
                        if (this.getAttributes().clair) {
                            this.setClass(`button h-button is-${color} ${outlined} is-light`);
                        } else {
                            this.setClass(`button h-button is-${color} ${outlined}`);
                        }
                    },
                },

                view: {
                    events: {
                        click: e => e.preventDefault(),
                    },
                },
            });

            const script = function () {
                document.addEventListener('click', function (event) {
                    if (event.target.closest('.goto-node')) {
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
                    }
                });
            };

            domc.addType(typeButtonGotoNode, {
                extend: typeInput,
                isComponent: el => el.tagName == 'BUTTON' && el.classList.contains('goto-node'),

                model: {
                    defaults: {
                        script,
                        tagName: 'button',
                        droppable: false,
                        attributes: {type: 'button', class: "button h-button goto-node m-1"},
                        text: 'Goto',
                        traits: [
                            nodesTrait,
                            {
                                name: 'outlined',
                                type: 'checkbox'
                            },
                            {
                                name: 'clair',
                                type: 'checkbox'
                            },
                            {
                                type: 'select',
                                name: 'couleur',
                                options: [
                                    {value: 'primary'},
                                    {value: 'success'},
                                    {value: 'info'},
                                    {value: 'danger'},
                                    {value: 'warning'},
                                    {value: 'light'},
                                    {value: 'dark'},
                                ]
                            },
                            {
                                name: 'text',
                                changeProp: true,
                            }]
                    },

                    init() {
                        const comps = this.components();
                        const tChild = comps.length === 1 && comps.models[0];
                        const chCnt = (tChild && tChild.is('textnode') && tChild.get('content')) || '';
                        const text = chCnt || this.get('text');
                        this.set({text});
                        this.on('change:text', this.__onTextChange);
                        this.on('change:attributes:couleur', this.__onColorChange);
                        this.on('change:attributes:outlined', this.__onOutlinedChange);
                        this.on('change:attributes:clair', this.__onClairChange);
                        (text !== chCnt) && this.__onTextChange();
                    },

                    __onTextChange() {
                        this.components(this.get('text'));
                    },
                    __onColorChange() {
                        let color = this.getAttributes().couleur
                        let outlined = (this.getAttributes().outlined ? 'is-outlined' : '')
                        let clair = (this.getAttributes().clair ? 'is-light' : '')
                        this.setClass(`button h-button goto-node m-1 is-${color} ${clair} ${outlined}`);
                    },
                    __onOutlinedChange() {
                        let color = this.getAttributes().couleur
                        let clair = (this.getAttributes().clair ? 'is-light' : '')
                        if (this.getAttributes().outlined) {
                            this.setClass(`button h-button goto-node m-1 is-${color} ${clair} is-outlined`);
                        } else {
                            this.setClass(`button h-button goto-node m-1 is-${color} ${clair}`);
                        }
                    },
                    __onClairChange() {
                        let color = this.getAttributes().couleur
                        let outlined = (this.getAttributes().outlined ? 'is-outlined' : '')
                        if (this.getAttributes().clair) {
                            this.setClass(`button h-button goto-node m-1 is-${color} ${outlined} is-light`);
                        } else {
                            this.setClass(`button h-button goto-node m-1 is-${color} ${outlined}`);
                        }
                    },
                },

                view: {
                    events: {
                        click: e => e.preventDefault(),
                    },
                },
            });

            // LABEL
            domc.addType(typeLabel, {
                extend: 'text',
                isComponent: el => el.tagName == 'LABEL',

                model: {
                    defaults: {
                        tagName: 'label',
                        components: {type: 'text', selectable: true, editable: true, components: 'Label', toolbar: []},
                        droppable: false,
                        draggable: false,
                        copyable: false,
                    },
                    // init() {
                    //   this.on('change:attributes:text', this.handleTextChange);
                    // },

                    // handleTextChange() {
                    //   this.getEl().innerHTML = this.getAttributes().text
                    // },
                },
            });
        };

        editor = grapesjs.init({
            assetManager: {
                assets: [],
                uploadText: 'Glisser les fichiers ici ou cliquez pour uploader',
                addBtnText: 'Ajouter image',
                modalTitle: 'Select Image',
            },
            styleManager: {
                sectors: [
                    {
                        name: 'General',
                        open: false,
                        hideNotStylable: true,
                        buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom'],
                    },
                    {
                        name: 'Dimension',
                        open: false,
                        hideNotStylable: true,
                        buildProps: ['width', 'height', 'min-width', 'min-height', 'max-width', 'max-height'],
                    },
                    {
                        name: 'Spacing',
                        open: false,
                        hideNotStylable: true,
                        buildProps: ['margin', 'padding'],
                    },
                    {
                        name: 'Decoration',
                        open: false,
                        hideNotStylable: true,
                        buildProps: ['background-color', 'background', 'border-radius-c', 'border-radius', 'border', 'box-shadow'],
                    },
                    {
                        name: 'Typography',
                        open: false,
                        hideNotStylable: true,
                        buildProps: ['font-family', 'font-size', 'color', 'font-weight', 'font-style', 'text-align', 'text-decoration'],
                        properties: [
                            {name: 'Font', property: 'font-family'},
                            {name: 'Font color', property: 'color'},
                            {name: 'Weight', property: 'font-weight'},
                            {
                                id: 'fontsize',
                                name: 'Taille Texte',
                                property: 'font-size',
                                type: 'select',
                                defaults: '12px',
                                options: [
                                    {value: '12px', name: 'Petit'},
                                    {value: '18px', name: 'Moyen'},
                                    {value: '22px', name: 'Grand'},
                                    {value: '30px', name: 'Très Grand'},
                                ],
                            },
                            {
                                property: 'text-align',
                                type: 'radio',
                                defaults: 'left',
                                list: [
                                    {value: 'left', name: 'Left', className: 'fa fa-align-left'},
                                    {value: 'center', name: 'Center', className: 'fa fa-align-center'},
                                    {value: 'right', name: 'Right', className: 'fa fa-align-right'},
                                    {value: 'justify', name: 'Justify', className: 'fa fa-align-justify'}
                                ],
                            }, {
                                property: 'text-decoration',
                                type: 'radio',
                                defaults: 'none',
                                list: [
                                    {value: 'none', name: 'None', className: 'fa fa-times'},
                                    {value: 'underline', name: 'underline', className: 'fa fa-underline'},
                                    {value: 'line-through', name: 'Line-through', className: 'fa fa-strikethrough'}
                                ],
                            }, {
                                property: 'font-style',
                                type: 'radio',
                                defaults: 'normal',
                                list: [
                                    {value: 'normal', name: 'Normal', className: 'fa fa-font'},
                                    {value: 'italic', name: 'Italic', className: 'fa fa-italic'}
                                ],
                            }, {
                                property: 'vertical-align',
                                type: 'select',
                                defaults: 'baseline',
                                list: [
                                    {value: 'baseline'},
                                    {value: 'top'},
                                    {value: 'middle'},
                                    {value: 'bottom'}
                                ],
                            }, {
                                property: 'text-shadow',
                                properties: [
                                    {name: 'X position', property: 'text-shadow-h'},
                                    {name: 'Y position', property: 'text-shadow-v'},
                                    {name: 'Blur', property: 'text-shadow-blur'},
                                    {name: 'Color', property: 'text-shadow-color'}
                                ],
                            }],
                    },
                ],
                hideNotStylable: true,
            },
            layerManager: {
                showWrapper: false,
            },
            allowScripts: 1,
            container: '#gjs',
            fromElement: true,
            height: '100%',
            width: 'auto',
            storageManager: false,
            plugins: [myNewComponentTypes],
            storageManager: {
                type: 'remote',
                autosave: false,
                urlStore: null,
                // urlLoad: "{{ route('script_get', ['script' => $script]) }}",
                /* 	headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    } */
            },
        });

        //Add Save Button in Top Panel
        editor.Panels.addButton('options', {
            id: 'save-script',
            className: 'btn-toggle-borders',
            label: '<i class="fas fa-save"></i>',
            command: 'save-script',
            togglable: false,
            attributes: {title: 'Enregistrer'}
        });

        //Add Exit Button in Top Panel
        editor.Panels.addButton('options', {
            id: 'exit-script',
            className: 'btn-toggle-borders',
            label: '<i class="fas fa-sign-out-alt"></i>',
            command: 'exit-script',
            togglable: false,
            attributes: {title: 'exit'}
        });

        editor.on('component:selected', (model) => {
            if (model.attributes.attributes['class'] && model.attributes.attributes['class'].includes('goto-node')) {
                let components = editor.getWrapper().find('.cadre_script, .container')

                list_cadres = []

                for (let component of components) {
                    list_cadres.push({id: component.ccid, name: component.ccid})
                }

                model.getTrait('target_id').set('options', list_cadres);
            }
        })

        //Set Blocks Layer as the default Block
        editor.on('load', () => {
            const blockBtn = editor.Panels.getButton('views', 'open-blocks');
            blockBtn.set('active', 1);

            //Special Styling for the .hide class only when opening script from editor
            let style = document.createElement('style');
            style.textContent = `.hide {display: block !important; opacity: .3;}`;
            document.querySelector('.gjs-frame').contentDocument.head.appendChild(style);
        })

        editor.TraitManager.addType('select-options', {
            events: {
                keyup: 'onChange',
            },

            onValueChange() {
                const {model, target} = this;
                const optionsStr = model.get('value').trim();
                const options = optionsStr.split('\n');
                const optComps = [];

                for (let i = 0; i < options.length; i++) {
                    const optionStr = options[i];
                    const option = optionStr.split('::');
                    optComps.push({
                        type: typeOption,
                        components: option[1] || option[0],
                        attributes: {value: option[0]},
                    });
                }

                target.components().reset(optComps);
                target.view.render();
            },

            getInputEl() {
                if (!this.$input) {
                    const optionsArr = [];
                    const options = this.target.components();

                    for (let i = 0; i < options.length; i++) {
                        const option = options.models[i];
                        const optAttr = option.get('attributes');
                        const optValue = optAttr.value || '';
                        const optTxtNode = option.components().models[0];
                        const optLabel = optTxtNode && optTxtNode.get('content') || '';
                        optionsArr.push(`${optValue}::${optLabel}`);
                    }

                    this.$input = document.createElement('textarea');
                    this.$input.value = optionsArr.join("\n");
                }
                return this.$input;
            },
        });

        // Define commands
        editor.Commands.add('save-script', {
            run(editor, sender) {
                editor.store(res => {
                    alert('Script Enregistré')
                    broadcast.postMessage('script_saved');
                });
            },
        });

        editor.Commands.add('exit-script', {
            run(editor, sender) {
                window.location.href = `{{ route('scripts') }}`;
            }
        });

        initBlocks()
    }

    function initBlocks() {
        editor.Blocks.add(typeCadre1Col, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">1 Colonne</span>',
            media: `<div class="columns py-4 px-2">
                            <div class="column is-12 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                        </div>`,
            category: catCadres,
            content: {
                type: typeCadre1Col,
            }
        });

        editor.Blocks.add(typeCadre2Col, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">2 Colonnes</span>',
            media: `<div class="columns py-4 px-2">
                            <div class="column is-6 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                            <div class="column is-6 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                        </div>`,
            category: catCadres,
            content: {
                type: typeCadre2Col,
            }
        });

        editor.Blocks.add(typeCadre3Col, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">3 Colonnes</span>',
            media: `<div class="columns py-4 px-2">
                            <div class="column is-4 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                            <div class="column is-4 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                            <div class="column is-4 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                        </div>`,
            category: catCadres,
            content: {
                type: typeCadre3Col,
            }
        });

        editor.Blocks.add(typeCadre4Col, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">4 Colonnes</span>',
            media: `<div class="columns py-4 px-2">
                            <div class="column is-3 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                            <div class="column is-3 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                            <div class="column is-3 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                            <div class="column is-3 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                        </div>`,
            category: catCadres,
            content: {
                type: typeCadre4Col,
            }
        });

        editor.Blocks.add(typeCadre3_9Col, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">3/9 Colonnes</span>',
            media: `<div class="columns py-4 px-2">
                            <div class="column is-3 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                            <div class="column is-9 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                        </div>`,
            category: catCadres,
            content: {
                type: typeCadre3_9Col,
            }
        });

        editor.Blocks.add(typeCadre9_3Col, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">9/3 Colonnes</span>',
            media: `<div class="columns py-4 px-2">
                            <div class="column is-9 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                            <div class="column is-3 p-1">
                                <div style="border: 2px solid #dbdbdb;border-radius: 5px; height: 30px;"></div>
                            </div>
                        </div>`,
            category: catCadres,
            content: {
                type: typeCadre9_3Col,
            }
        });

        editor.Blocks.add(typeForm, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">Form</span>',
            media: '<span class="has-text-grey-lighter"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 5.5c0-.3-.5-.5-1.3-.5H3.4c-.8 0-1.3.2-1.3.5v3c0 .3.5.5 1.3.5h17.4c.8 0 1.3-.2 1.3-.5v-3zM21 8H3V6h18v2zM22 10.5c0-.3-.5-.5-1.3-.5H3.4c-.8 0-1.3.2-1.3.5v3c0 .3.5.5 1.3.5h17.4c.8 0 1.3-.2 1.3-.5v-3zM21 13H3v-2h18v2z"/><rect width="10" height="3" x="2" y="15" rx=".5"/></svg></span>',
            category: catForm,
            content: {
                type: typeForm
            }
        });

        editor.Blocks.add(typeImage, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">Image</span>',
            media: `<span class="has-text-grey-lighter"><i class="far fa-image fa-3x"></i></span>`,
            category: catForm,
            select: true,
            traits: [{default: {}}],
            content: {type: 'image', toolbar: [{attributes: {class: 'fas fa-trash-alt'}, command: 'tlb-delete'}],},
            activate: true,
        });

        editor.Blocks.add(typeInput, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">Champ de saisie</span>',
            media: `<span class="has-text-grey-lighter">
                <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path>
                <polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon>
                </svg></span>`,
            category: catForm,
            select: true,
            traits: [{default: {}}],
            content: {
                tagName: 'div',
                selectable: true,
                toolbar: [{attributes: {class: 'fas fa-trash-alt'}, command: 'tlb-delete'}],
                attributes: {class: "field is-horizontal"},
                droppable: false,
                draggable: '.form-components',
                components: [{
                    tagName: 'div',
                    attributes: {class: "field-label is-normal"},
                    droppable: false,
                    draggable: false,
                    selectable: false,
                    components: [
                        {type: typeLabel, attributes: {class: "label"}, droppable: false, toolbar: [],},
                    ]
                }, {
                    tagName: 'div',
                    attributes: {class: "field-body"},
                    droppable: false,
                    draggable: false,
                    selectable: false,
                    components: [{
                        droppable: false,
                        draggable: false,
                        selectable: false,
                        tagName: 'div',
                        attributes: {class: "field"},
                        components: [{
                            droppable: false,
                            draggable: false,
                            selectable: false,
                            tagName: 'div',
                            attributes: {class: "control"},
                            components: [{type: typeInput, toolbar: [],}]
                        }]
                    }]
                }]
            }
        });

        editor.Blocks.add(typeCheckboxLabel, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">Checkbox</span>',
            media: `<span class="has-text-grey-lighter"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10 17l-5-5 1.41-1.42L10 14.17l7.59-7.59L19 8m0-5H5c-1.11 0-2 .89-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5a2 2 0 0 0-2-2z"></path></svg></span>`,
            select: true,
            category: catForm,
            traits: [{default: {}}],
            content: {
                tagName: 'div',
                attributes: {class: "field is-horizontal"},
                droppable: false,
                draggable: '.form-components',
                components: [{
                    droppable: false,
                    tagName: 'div',
                    attributes: {class: "field-label is-normal"},
                    components: [
                        {type: typeLabel, components: 'Label', attributes: {class: "label"},},
                    ]
                }, {
                    tagName: 'div',
                    droppable: false,
                    attributes: {class: "field-body"},
                    components: [{
                        tagName: 'div',
                        attributes: {class: "field"},
                        droppable: false,
                        components: [{
                            droppable: false,
                            tagName: 'div',
                            attributes: {class: "control"},
                            components: [{type: typeCheckboxLabel}]
                        }]
                    }]
                }]
            }
        });

        editor.Blocks.add(typeSelect, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">Select</span>',
            media: `<span class="has-text-grey-lighter">
                <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z" fill-rule="nonzero"></path>
                <polygon class="gjs-block-svg-path" transform="translate(18.500000, 12.000000) scale(1, -1) translate(-18.500000, -12.000000) " points="18.5 11 20 13 17 13"></polygon>
                <rect class="gjs-block-svg-path" x="4" y="11.5" width="11" height="1"></rect>
                </svg></span>`,
            select: true,
            category: catForm,
            traits: [{default: {}}],
            content: {
                tagName: 'div',
                attributes: {class: "field is-horizontal"},
                droppable: false,
                selectable: false,
                draggable: '.form-components',
                components: [{
                    tagName: 'div',
                    attributes: {class: "field-label is-normal"},
                    droppable: false,
                    draggable: false,
                    selectable: false,
                    components: [{
                        type: typeLabel, attributes: {class: "label"}, droppable: false,
                    }]
                }, {
                    tagName: 'div',
                    attributes: {class: "field-body"},
                    droppable: false,
                    draggable: false,
                    selectable: false,
                    components: [{
                        droppable: false,
                        draggable: false,
                        selectable: false,
                        tagName: 'div',
                        attributes: {class: "field"},
                        components: [{
                            droppable: false,
                            draggable: false,
                            selectable: false,
                            tagName: 'div',
                            attributes: {class: "control"},
                            components: [{
                                droppable: false,
                                draggable: false,
                                selectable: false,
                                tagName: 'div',
                                attributes: {class: "select is-fullwidth"},
                                components: [{type: typeSelect}]
                            }]
                        }]
                    }]
                }]
            }
        });

        editor.Blocks.add(typeTextarea, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">Textarea</span>',
            media: `<span class="has-text-grey-lighter">
                <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path class="gjs-block-svg-path" d="M22,7.5 C22,6.6 21.5,6 20.75,6 L3.25,6 C2.5,6 2,6.6 2,7.5 L2,16.5 C2,17.4 2.5,18 3.25,18 L20.75,18 C21.5,18 22,17.4 22,16.5 L22,7.5 Z M21,17 L3,17 L3,7 L21,7 L21,17 Z"></path>
                <polygon class="gjs-block-svg-path" points="4 8 5 8 5 12 4 12"></polygon>
                <polygon class="gjs-block-svg-path" points="19 7 20 7 20 17 19 17"></polygon>
                <polygon class="gjs-block-svg-path" points="20 8 21 8 21 9 20 9"></polygon>
                <polygon class="gjs-block-svg-path" points="20 15 21 15 21 16 20 16"></polygon>
                </svg></span>`,
            category: catForm,
            // select: true,
            traits: [{default: {}}],
            content: {
                tagName: 'div',
                attributes: {class: "field is-horizontal"},
                droppable: false,
                selectable: false,
                draggable: '.form-components',
                components: [{
                    tagName: 'div',
                    attributes: {class: "field-label is-normal"},
                    selectable: false,
                    droppable: false,
                    draggable: false,
                    components: [{
                        type: typeLabel,
                        attributes: {class: "label"},
                        droppable: false,
                    }]
                }, {
                    tagName: 'div',
                    attributes: {class: "field-body"},
                    droppable: false,
                    draggable: false,
                    selectable: false,
                    components: [{
                        droppable: false,
                        draggable: false,
                        selectable: false,
                        tagName: 'div',
                        attributes: {class: "field"},
                        components: [{
                            droppable: false,
                            draggable: false,
                            selectable: false,
                            tagName: 'div',
                            attributes: {class: "control"},
                            components: [{type: typeTextarea}]
                        }]
                    }]
                }]
            }
        });

        editor.Blocks.add(typeTexte, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">Texte</span>',
            media: '<span class="has-text-grey-lighter"><i class="fal fa-text fa-3x mb-3"></i></span>',
            category: catForm,
            content: {
                type: typeTexte,
            }
        });

        for (let ct of colonnes_ct) {
            editor.Blocks.add(`champs-ct-${ct.name}`, {
                label: `<span class="has-text-grey-lighter is-weight-900 rem-90">${ct.name}</span>`,
                media: '<span class="has-text-grey-lighter"><i class="fal fa-info-circle fa-3x mb-3"></i></span>',
                category: catChampsCt,
                content: {
                    type: typeChampCt,
                    components: `@{{{${ct.name}}}}`
                }
            });
        }

        editor.Blocks.add(typeButtonGotoNode, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">Goto</span>',
            media: `<span class="has-text-grey-lighter">
                <i class="fal fa-exchange fa-3x mb-3"></i>
                </span>`,
            category: catActions,
            select: true,
            traits: [{default: {}}],
            content: {
                tagName: 'div',
                attributes: {class: "field"},
                droppable: false,
                selectable: false,
                components: [
                    {type: typeButtonGotoNode},
                ]
            }
        });

        editor.Blocks.add(typeLink, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">Lien</span>',
            media: '<span class="has-text-grey-lighter"><i class="fal fa-link fa-3x mb-3"></i></span>',
            category: catActions,
            content: {
                type: typeLink,
            }
        });

        editor.Blocks.add(typeH1, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">H1</span>',
            media: '<span class="has-text-grey-lighter"><i class="fal fa-h1 fa-3x mb-3"></i></span>',
            category: catTitres,
            content: {
                type: typeH1,
            }
        });

        editor.Blocks.add(typeH2, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">H2</span>',
            media: '<span class="has-text-grey-lighter"><i class="fal fa-h2 fa-3x mb-3"></i></span>',
            category: catTitres,
            content: {
                type: typeH2,
            }
        });

        editor.Blocks.add(typeH3, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">H3</span>',
            media: '<span class="has-text-grey-lighter"><i class="fal fa-h3 fa-3x mb-3"></i></span>',
            category: catTitres,
            content: {
                type: typeH3,
            }
        });

        editor.Blocks.add(typeH4, {
            label: '<span class="has-text-grey-lighter is-weight-900 rem-90">H4</span>',
            media: '<span class="has-text-grey-lighter"><i class="fal fa-h4 fa-3x mb-3"></i></span>',
            category: catTitres,
            content: {
                type: typeH4,
            }
        });
    }

    initGrape();
</script>