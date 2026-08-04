document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | ÉLÉMENTS PRINCIPAUX
    |--------------------------------------------------------------------------
    */

    const form = document.getElementById('documentForm');

    if (!form) {
        return;
    }

    const steps = document.querySelectorAll('.wizard-step');
    const stepButtons = document.querySelectorAll('.step-indicator');

    const nextButtons = document.querySelectorAll('.btn-next');
    const previousButtons = document.querySelectorAll('.btn-previous');

    let currentStep = 1;


    /*
    |--------------------------------------------------------------------------
    | CHAMPS DU FORMULAIRE
    |--------------------------------------------------------------------------
    */

    const categorySelect = document.getElementById('category');

    const formationSelect = document.getElementById('formation_id');
    const domainSelect = document.getElementById('academic_domain_id');

    const filiereSelect = document.getElementById('filiere_id');

    const programSelect = document.getElementById('program_id');
    const specialiteSelect = document.getElementById('specialite_id');

    const levelSelect = document.getElementById('level_id');
    const subjectSelect = document.getElementById('subject_id');

    const documentTypeSelect =
        document.getElementById('document_type_id');
 
    /*
    |--------------------------------------------------------------------------
    | ZONES CONDITIONNELLES
    |--------------------------------------------------------------------------
    */

    const formationGroup =
        document.getElementById('formationGroup');

    const domainGroup =
        document.getElementById('domainGroup');

    const filiereGroup =
        document.getElementById('filiereGroup');

    const programGroup =
        document.getElementById('programGroup');

    const specialiteGroup =
        document.getElementById('specialiteGroup');

    const levelGroup =
        document.getElementById('levelGroup');

    const subjectGroup =
        document.getElementById('subjectGroup');


    /*
    |--------------------------------------------------------------------------
    | URLS AJAX
    |--------------------------------------------------------------------------
    |
    | Les URLs sont récupérées depuis les attributs data du formulaire.
    |
    */

    const urls = {

        formations:
            form.dataset.formationsUrl,

        filieres:
            form.dataset.filieresUrl,

        programs:
            form.dataset.programsUrl,

        specialites:
            form.dataset.specialitesUrl,

        levels:
            form.dataset.levelsUrl,

        subjects:
            form.dataset.subjectsUrl,

    };


    /*
    |--------------------------------------------------------------------------
    | AFFICHER UNE ÉTAPE
    |--------------------------------------------------------------------------
    */

    function showStep(stepNumber) {

        currentStep = stepNumber;

        steps.forEach((step) => {

            const number =
                Number(step.dataset.step);

            step.classList.toggle(
                'd-none',
                number !== stepNumber
            );

        });


        stepButtons.forEach((button) => {

            const number =
                Number(button.dataset.step);

            button.classList.remove(
                'active',
                'completed'
            );

            if (number === stepNumber) {

                button.classList.add(
                    'active'
                );

            }

            if (number < stepNumber) {

                button.classList.add(
                    'completed'
                );

            }

        });


        window.scrollTo({

            top: 0,

            behavior: 'smooth',

        });

    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION DE L'ÉTAPE
    |--------------------------------------------------------------------------
    */

    function validateStep(stepNumber) {

        const current =
            document.querySelector(
                `.wizard-step[data-step="${stepNumber}"]`
            );

        if (!current) {
            return true;
        }

        const requiredFields =
            current.querySelectorAll(
                '[required]'
            );

        let valid = true;


        requiredFields.forEach((field) => {

            field.classList.remove(
                'is-invalid'
            );


            /*
            |--------------------------------------------------------------------------
            | Ignorer les champs cachés
            |--------------------------------------------------------------------------
            */

            const group =
                field.closest(
                    '.conditional-group'
                );

            if (
                group &&
                group.classList.contains(
                    'd-none'
                )
            ) {
                return;
            }


            if (
                !field.value ||
                field.value.trim() === ''
            ) {

                field.classList.add(
                    'is-invalid'
                );

                valid = false;

            }

        });


        if (!valid) {

            const firstError =
                current.querySelector(
                    '.is-invalid'
                );

            if (firstError) {

                firstError.focus();

            }

        }


        return valid;

    }


    /*
    |--------------------------------------------------------------------------
    | BOUTON SUIVANT
    |--------------------------------------------------------------------------
    */

    nextButtons.forEach((button) => {

        button.addEventListener(
            'click',
            () => {

                if (
                    !validateStep(
                        currentStep
                    )
                ) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Étape 2 → Étape 3
                |--------------------------------------------------------------------------
                */

                if (
                    currentStep === 2
                ) {

                    generateSummary();

                }


                if (
                    currentStep < 3
                ) {

                    showStep(
                        currentStep + 1
                    );

                }

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | BOUTON PRÉCÉDENT
    |--------------------------------------------------------------------------
    */

    previousButtons.forEach((button) => {

        button.addEventListener(
            'click',
            () => {

                if (
                    currentStep > 1
                ) {

                    showStep(
                        currentStep - 1
                    );

                }

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | FONCTION POUR REMPLIR UN SELECT
    |--------------------------------------------------------------------------
    */

    function fillSelect(
        select,
        items,
        placeholder
    ) {

        if (!select) {
            return;
        }


        select.innerHTML = '';


        const defaultOption =
            document.createElement(
                'option'
            );

        defaultOption.value = '';

        defaultOption.textContent =
            placeholder;

        select.appendChild(
            defaultOption
        );


        items.forEach((item) => {

            const option =
                document.createElement(
                    'option'
                );

            option.value =
                item.id;

            option.textContent =
                item.name;

            select.appendChild(
                option
            );

        });


        select.disabled =
            false;

    }


    /*
    |--------------------------------------------------------------------------
    | RÉINITIALISER UN SELECT
    |--------------------------------------------------------------------------
    */

    function resetSelect(
        select,
        placeholder
    ) {

        if (!select) {
            return;
        }


        select.innerHTML = `

            <option value="">
                ${placeholder}
            </option>

        `;

        select.disabled = true;

    }


    /*
    |--------------------------------------------------------------------------
    | REQUÊTE AJAX
    |--------------------------------------------------------------------------
    */

    async function loadData(
        url,
        params = {}
    ) {

        if (!url) {
            return [];
        }


        const query =
            new URLSearchParams(
                params
            );


        try {

            const response =
                await fetch(

                    `${url}?${query.toString()}`,

                    {

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },

                    }

                );


            if (!response.ok) {

                throw new Error(
                    'Erreur de chargement.'
                );

            }


            const data =
                await response.json();


            /*
            |--------------------------------------------------------------------------
            | Accepte :
            |
            | []
            |
            | ou :
            |
            | {
            |     data: []
            | }
            |--------------------------------------------------------------------------
            */

            return Array.isArray(
                data
            )
                ? data
                : (
                    data.data ?? []
                );


        } catch (error) {

            console.error(
                error
            );

            return [];

        }

    }


    /*
    |--------------------------------------------------------------------------
    | AFFICHER / CACHER LES GROUPES
    |--------------------------------------------------------------------------
    */

    function hideAllGroups() {

        [
            formationGroup,
            domainGroup,
            filiereGroup,
            programGroup,
            specialiteGroup,
            levelGroup,
            subjectGroup,

        ].forEach((group) => {

            if (!group) {
                return;
            }

            group.classList.add(
                'd-none'
            );

        });
    }
    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT DE CATÉGORIE
    |--------------------------------------------------------------------------
    */

    if (categorySelect) {

        categorySelect.addEventListener(
            'change',
            async function () {

                const category =
                    this.value;


                hideAllGroups();


                resetSelect(
                    formationSelect,
                    'Sélectionner une formation'
                );

                resetSelect(
                    filiereSelect,
                    'Sélectionner une filière'
                );

                resetSelect(
                    programSelect,
                    'Sélectionner un programme'
                );

                resetSelect(
                    specialiteSelect,
                    'Sélectionner une spécialité'
                );

                resetSelect(
                    levelSelect,
                    'Sélectionner un niveau'
                );

                resetSelect(
                    subjectSelect,
                    'Sélectionner une matière ou un module'
                );


                /*
                |--------------------------------------------------------------------------
                | SECONDAIRE
                |--------------------------------------------------------------------------
                */

                if (
                    category ===
                    'secondary_general'
                    ||
                    category ===
                    'secondary_technical'
                ) {

                    formationGroup
                        ?.classList.remove(
                            'd-none'
                        );

                    levelGroup
                        ?.classList.remove(
                            'd-none'
                        );

                    subjectGroup
                        ?.classList.remove(
                            'd-none'
                        );


                    const section =
                        category ===
                        'secondary_general'
                            ? 'general'
                            : 'technique';


                    const formations =
                        await loadData(

                            urls.formations,

                            {

                                category:
                                    category,

                                section:
                                    section,

                            }

                        );


                    fillSelect(

                        formationSelect,

                        formations,

                        'Sélectionner une formation'

                    );

                }


                /*
                |--------------------------------------------------------------------------
                | SUPÉRIEUR
                |--------------------------------------------------------------------------
                */

                if (
                    category ===
                    'higher'
                ) {

                    domainGroup
                        ?.classList.remove(
                            'd-none'
                        );

                    filiereGroup
                        ?.classList.remove(
                            'd-none'
                        );

                    levelGroup
                        ?.classList.remove(
                            'd-none'
                        );

                    subjectGroup
                        ?.classList.remove(
                            'd-none'
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | PROFESSIONNEL
                |--------------------------------------------------------------------------
                */

                if (
                    category ===
                    'professional'
                ) {

                    formationGroup
                        ?.classList.remove(
                            'd-none'
                        );

                    programGroup
                        ?.classList.remove(
                            'd-none'
                        );

                    specialiteGroup
                        ?.classList.remove(
                            'd-none'
                        );

                    levelGroup
                        ?.classList.remove(
                            'd-none'
                        );

                    subjectGroup
                        ?.classList.remove(
                            'd-none'
                        );


                    const formations =
                        await loadData(

                            urls.formations,

                            {

                                category:
                                    category,

                            }

                        );


                    fillSelect(

                        formationSelect,

                        formations,

                        'Sélectionner une formation'

                    );

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | DOMAINE → FILIÈRES
    |--------------------------------------------------------------------------
    */

    if (domainSelect) {

        domainSelect.addEventListener(
            'change',
            async function () {

                resetSelect(
                    filiereSelect,
                    'Chargement...'
                );


                const filieres =
                    await loadData(

                        urls.filieres,

                        {

                            academic_domain_id:
                                this.value,

                        }

                    );


                fillSelect(

                    filiereSelect,

                    filieres,

                    'Sélectionner une filière'

                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FORMATION → PROGRAMMES
    |--------------------------------------------------------------------------
    */

    if (formationSelect) {

        formationSelect.addEventListener(
            'change',
            async function () {

                const category =
                    categorySelect?.value;


                /*
                |--------------------------------------------------------------------------
                | PROFESSIONNEL
                |--------------------------------------------------------------------------
                */

                if (
                    category ===
                    'professional'
                ) {

                    resetSelect(
                        programSelect,
                        'Chargement...'
                    );


                    const programs =
                        await loadData(

                            urls.programs,

                            {

                                formation_id:
                                    this.value,

                            }

                        );


                    fillSelect(

                        programSelect,

                        programs,

                        'Sélectionner un programme'

                    );

                }

                /*
                |--------------------------------------------------------------------------
                | SECONDAIRE
                |--------------------------------------------------------------------------
                */

                if (
                    category ===
                    'secondary_general'
                    ||
                    category ===
                    'secondary_technical'
                ) {

                    resetSelect(
                        levelSelect,
                        'Chargement...'
                    );


                    const levels =
                        await loadData(

                            urls.levels,

                            {

                                formation_id:
                                    this.value,

                            }

                        );


                    fillSelect(

                        levelSelect,

                        levels,

                        'Sélectionner une classe'

                    );

                }

            }
        );
    }
    /*
    |--------------------------------------------------------------------------
    | FILIÈRE → NIVEAUX
    |--------------------------------------------------------------------------
    */

    if (filiereSelect) {

        filiereSelect.addEventListener(
            'change',
            async function () {

                resetSelect(
                    levelSelect,
                    'Chargement...'
                );

                const levels =
                    await loadData(

                        urls.levels,

                        {

                            filiere_id:
                                this.value,

                        }

                    );

                fillSelect(

                    levelSelect,

                    levels,

                    'Sélectionner un niveau'

                );

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | PROGRAMME → SPÉCIALITÉS
    |--------------------------------------------------------------------------
    */
    if (programSelect) {

        programSelect.addEventListener(
            'change',
            async function () {

                resetSelect(
                    specialiteSelect,
                    'Chargement...'
                );

                const specialites =
                    await loadData(

                        urls.specialites,

                        {

                            program_id:
                                this.value,

                        }

                    );

                fillSelect(

                    specialiteSelect,

                    specialites,

                    'Sélectionner une spécialité'

                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SPÉCIALITÉ → NIVEAUX
    |--------------------------------------------------------------------------
    */

    if (specialiteSelect) {

        specialiteSelect.addEventListener(
            'change',
            async function () {

                resetSelect(
                    levelSelect,
                    'Chargement...'
                );


                const levels =
                    await loadData(

                        urls.levels,

                        {

                            specialite_id:
                                this.value,

                        }

                    );


                fillSelect(

                    levelSelect,

                    levels,

                    'Sélectionner un niveau'

                );

            }
        );

    }
    /*
    |--------------------------------------------------------------------------
    | NIVEAU → MATIÈRES / MODULES
    |--------------------------------------------------------------------------
    */

    if (levelSelect) {

        levelSelect.addEventListener(
            'change',
            async function () {

                resetSelect(
                    subjectSelect,
                    'Chargement...'
                );


                const subjects =
                    await loadData(

                        urls.subjects,

                        {

                            level_id:
                                this.value,

                        }

                    );

                fillSelect(

                    subjectSelect,

                    subjects,

                    'Sélectionner une matière ou un module'

                );

            }
        );

    }
    /*
    |--------------------------------------------------------------------------
    | RÉCAPITULATIF
    |--------------------------------------------------------------------------
    */

    function getSelectedText(
        select
    ) {

        if (
            !select ||
            !select.value
        ) {
            return 'Non renseigné';
        }


        return select
            .options[
                select.selectedIndex
            ]
            ?.text
            ?.trim()
            ?? 'Non renseigné';

    }


    function setSummary(
        id,
        value
    ) {

        const element =
            document.getElementById(
                id
            );


        if (element) {

            element.textContent =
                value;

        }

    }


    function generateSummary() {

        setSummary(

            'summary-category',

            getSelectedText(
                categorySelect
            )

        );


        setSummary(

            'summary-formation',

            getSelectedText(
                formationSelect
            )

        );


        setSummary(

            'summary-domain',

            getSelectedText(
                domainSelect
            )

        );


        setSummary(

            'summary-filiere',

            getSelectedText(
                filiereSelect
            )

        );


        setSummary(

            'summary-program',

            getSelectedText(
                programSelect
            )

        );


        setSummary(

            'summary-specialite',

            getSelectedText(
                specialiteSelect
            )

        );


        setSummary(

            'summary-level',

            getSelectedText(
                levelSelect
            )

        );


        setSummary(

            'summary-subject',

            getSelectedText(
                subjectSelect
            )

        );


        setSummary(

            'summary-document-type',

            getSelectedText(
                documentTypeSelect
            )

        );


        const title =
            document.getElementById(
                'title'
            );


        const description =
            document.getElementById(
                'description'
            );


        const accessType =
            document.getElementById(
                'access_type'
            );


        const price =
            document.getElementById(
                'price'
            );


        setSummary(

            'summary-title',

            title?.value
            || 'Non renseigné'

        );


        setSummary(

            'summary-description',

            description?.value
            || 'Aucune description'

        );


        setSummary(

            'summary-access',

            getSelectedText(
                accessType
            )

        );


        setSummary(

            'summary-price',

            price?.value
                ? `${price.value} FCFA`
                : 'Gratuit'

        );

    }


    /*
    |--------------------------------------------------------------------------
    | TYPE D'ACCÈS → PRIX
    |--------------------------------------------------------------------------
    */

    const accessType =
        document.getElementById(
            'access_type'
        );

    const priceGroup =
        document.getElementById(
            'priceGroup'
        );

    const price =
        document.getElementById(
            'price'
        );


    if (accessType) {

        accessType.addEventListener(
            'change',
            function () {

                const paid =
                    this.value ===
                    'paid';


                if (priceGroup) {

                    priceGroup.classList.toggle(
                        'd-none',
                        !paid
                    );

                }


                if (price) {

                    price.required =
                        paid;


                    if (!paid) {

                        price.value =
                            '';

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SUPPRESSION DES ERREURS
    |--------------------------------------------------------------------------
    */

    form.querySelectorAll(

        'input, select, textarea'

    ).forEach((field) => {

        field.addEventListener(
            'input',
            () => {

                field.classList.remove(
                    'is-invalid'
                );

            }
        );


        field.addEventListener(
            'change',
            () => {

                field.classList.remove(
                    'is-invalid'
                );

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | INITIALISATION
    |--------------------------------------------------------------------------
    */

    showStep(1);

});