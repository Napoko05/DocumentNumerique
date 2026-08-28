document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const form = document.getElementById('documentForm');
    if (!form) {
        console.warn('[Document Wizard] Formulaire introuvable.');
        return;
    }

    const categorySelect = document.getElementById('teaching_category_id');
    const academicDomainSelect = document.getElementById('academic_domain_id');
    const formationSelect = document.getElementById('formation_id');
    const filiereSelect = document.getElementById('filiere_id');
    const programSelect = document.getElementById('program_id');
    const specialiteSelect = document.getElementById('specialite_id');
    const levelSelect = document.getElementById('level_id');
    const subjectSelect = document.getElementById('subject_id');

    const academicDomainContainer = document.getElementById('academicDomainContainer');
    const formationContainer = document.getElementById('formationContainer');
    const filiereContainer = document.getElementById('filiereContainer');
    const programContainer = document.getElementById('programContainer');
    const specialiteContainer = document.getElementById('specialiteContainer');
    const levelContainer = document.getElementById('levelContainer');
    const subjectContainer = document.getElementById('subjectContainer');

    const progressFill = document.getElementById('wizardProgressFill');
    const summary = document.getElementById('document-summary');
    const accessType = document.getElementById('access_type');
    const priceContainer = document.getElementById('price-container');
    const priceInput = document.getElementById('price');
    const confirmInformation = document.getElementById('confirm_information');
    const publishButton = document.getElementById('publishDocumentBtn');

    const urls = {
        formations: form.dataset.formationsUrl,
        academicDomains: form.dataset.academicDomainsUrl,
        filieres: form.dataset.filieresUrl,
        secondaryLevels: form.dataset.secondaryLevelsUrl,
        higherLevels: form.dataset.higherLevelsUrl,
        professionalLevels: form.dataset.professionalLevelsUrl,
        specialitesByFormation: form.dataset.specialitesByFormationUrl,
        programs: form.dataset.programsUrl,
        specialites: form.dataset.specialitesUrl,
        specialiteLevels: form.dataset.specialiteLevelsUrl,
        subjects: form.dataset.subjectsUrl
    };

    let currentStep = 1;
    let requestSequence = 0;

    function show(element) {
        if (element) element.style.display = '';
    }

    function hide(element) {
        if (element) element.style.display = 'none';
    }

    function resetSelect(select, placeholder) {
        if (!select) return;
        select.innerHTML = '';
        const option = document.createElement('option');
        option.value = '';
        option.textContent = placeholder;
        select.appendChild(option);
        select.disabled = true;
    }

    function setLoading(select, message) {
        if (!select) return;
        select.innerHTML = '';
        const option = document.createElement('option');
        option.value = '';
        option.textContent = message;
        select.appendChild(option);
        select.disabled = true;
    }

    function populateSelect(select, items, placeholder) {
        if (!select) return;

        resetSelect(select, placeholder);

        if (!Array.isArray(items) || items.length === 0) return;

        items.forEach(function (item) {
            if (!item || item.id === undefined || item.name === undefined) return;

            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.name;

            if (item.slug) {
                option.dataset.slug = item.slug;
            }

            select.appendChild(option);
        });

        select.disabled = false;
    }

    function hideAllClassificationContainers() {
        hide(academicDomainContainer);
        hide(formationContainer);
        hide(filiereContainer);
        hide(programContainer);
        hide(specialiteContainer);
        hide(levelContainer);
        hide(subjectContainer);
    }

    function getCategorySlug() {
        if (!categorySelect) return null;

        const option = categorySelect.options[categorySelect.selectedIndex];

        return option?.dataset?.slug || null;
    }

    function isSecondary() {
        return [
            'secondaire',
            'secondaire-general',
            'secondaire-technique'
        ].includes(getCategorySlug());
    }

    function isHigher() {
        return [
            'superieur',
            'supérieur'
        ].includes(getCategorySlug());
    }

    function isProfessional() {
        return [
            'professionnel',
            'professional'
        ].includes(getCategorySlug());
    }

    function getFormationSlug() {
        if (!formationSelect) return null;

        const option = formationSelect.options[formationSelect.selectedIndex];

        return option?.dataset?.slug || null;
    }



    function isProfessionalENEP() {
        return getFormationSlug() === 'enep';
    }

    function isProfessionalENSP() {
        return getFormationSlug() === 'ensp';
    }

    function isProfessionalIDS() {
        return getFormationSlug() === 'ids';
    }

    function isProfessionalUIT() {
        return getFormationSlug() === 'uit';
    }

    function isProfessionalENS() {
        return getFormationSlug() === 'ens';
    }

    function isProfessionalSpecializedFormation() {
        return [
            'ensp',
            'ids',
            'uit'
        ].includes(getFormationSlug());
    }

    function isProfessionalProgramFormation() {
        return isProfessionalENS();
    }

    async function loadData(url, params = {}, sequence) {
        if (!url) {
            console.error('[Document Wizard] URL AJAX manquante.');
            return [];
        }

        const query = new URLSearchParams();

        Object.entries(params).forEach(([key, value]) => {
            if (value !== null && value !== undefined && value !== '') {
                query.append(key, value);
            }
        });

        const finalUrl = `${url}?${query.toString()}`;

        try {
            const response = await fetch(finalUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const data = await response.json();

            if (sequence !== requestSequence) return null;

            if (Array.isArray(data)) return data;

            if (data && Array.isArray(data.data)) return data.data;

            return [];
        } catch (error) {
            if (sequence === requestSequence) {
                console.error('[Document Wizard] AJAX:', error);
            }
            return [];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CATÉGORIE → PARCOURS
    |--------------------------------------------------------------------------
    */

    if (categorySelect) {
        categorySelect.addEventListener('change', async function () {

            const category = getCategorySlug();

            requestSequence++;

            const sequence = requestSequence;

            hideAllClassificationContainers();

            resetSelect(
                academicDomainSelect,
                '-- Sélectionner un domaine académique --'
            );

            resetSelect(
                formationSelect,
                '-- Sélectionner une formation --'
            );

            resetSelect(
                filiereSelect,
                '-- Sélectionner une filière --'
            );

            resetSelect(
                programSelect,
                '-- Sélectionner un programme --'
            );

            resetSelect(
                specialiteSelect,
                '-- Sélectionner une spécialité --'
            );

            resetSelect(
                levelSelect,
                '-- Sélectionner un niveau / une classe --'
            );

            resetSelect(
                subjectSelect,
                '-- Sélectionner une matière / un module --'
            );

            if (!category) return;

            /*
            |--------------------------------------------------------------------------
            | SECONDAIRE
            |--------------------------------------------------------------------------
            */

            if (isSecondary()) {

                show(formationContainer);

                setLoading(
                    formationSelect,
                    '-- Chargement des formations... --'
                );

                const formations = await loadData(
                    urls.formations,
                    { category: category },
                    sequence
                );

                if (
                    formations === null ||
                    sequence !== requestSequence
                ) return;

                populateSelect(
                    formationSelect,
                    formations,
                    '-- Sélectionner une formation --'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | SUPÉRIEUR
            |--------------------------------------------------------------------------
            */

            if (isHigher()) {

                show(academicDomainContainer);

                setLoading(
                    academicDomainSelect,
                    '-- Chargement des domaines académiques... --'
                );

                const domains = await loadData(
                    urls.academicDomains,
                    { category: category },
                    sequence
                );

                if (
                    domains === null ||
                    sequence !== requestSequence
                ) return;

                populateSelect(
                    academicDomainSelect,
                    domains,
                    '-- Sélectionner un domaine académique --'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | PROFESSIONNEL
            |--------------------------------------------------------------------------
            */

            if (isProfessional()) {

                show(formationContainer);

                setLoading(
                    formationSelect,
                    '-- Chargement des formations... --'
                );

                const formations = await loadData(
                    urls.formations,
                    { category: category },
                    sequence
                );

                if (
                    formations === null ||
                    sequence !== requestSequence
                ) return;

                populateSelect(
                    formationSelect,
                    formations,
                    '-- Sélectionner une formation --'
                );
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | SUPÉRIEUR
    | Domaine → Filière
    |--------------------------------------------------------------------------
    */

    if (academicDomainSelect) {
        academicDomainSelect.addEventListener('change', async function () {

            if (!isHigher()) return;

            const domainId = this.value;

            requestSequence++;

            const sequence = requestSequence;

            resetSelect(
                filiereSelect,
                '-- Sélectionner une filière --'
            );

            resetSelect(
                levelSelect,
                '-- Sélectionner un niveau / une classe --'
            );

            resetSelect(
                subjectSelect,
                '-- Sélectionner une matière / un module --'
            );

            hide(filiereContainer);
            hide(levelContainer);
            hide(subjectContainer);

            if (!domainId) return;

            show(filiereContainer);

            setLoading(
                filiereSelect,
                '-- Chargement des filières... --'
            );

            const filieres = await loadData(
                urls.filieres,
                {
                    academic_domain_id: domainId
                },
                sequence
            );

            if (
                filieres === null ||
                sequence !== requestSequence ||
                this.value !== domainId
            ) return;

            populateSelect(
                filiereSelect,
                filieres,
                '-- Sélectionner une filière --'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | SUPÉRIEUR
    | Filière → Niveau
    |--------------------------------------------------------------------------
    */

    if (filiereSelect) {
        filiereSelect.addEventListener('change', async function () {

            if (!isHigher()) return;

            const filiereId = this.value;

            requestSequence++;

            const sequence = requestSequence;

            resetSelect(
                levelSelect,
                '-- Sélectionner un niveau / une classe --'
            );

            resetSelect(
                subjectSelect,
                '-- Sélectionner une matière / un module --'
            );

            hide(levelContainer);
            hide(subjectContainer);

            if (!filiereId) return;

            show(levelContainer);

            setLoading(
                levelSelect,
                '-- Chargement des niveaux... --'
            );

            const levels = await loadData(
                urls.higherLevels,
                {
                    filiere_id: filiereId
                },
                sequence
            );

            if (
                levels === null ||
                sequence !== requestSequence ||
                this.value !== filiereId
            ) return;

            populateSelect(
                levelSelect,
                levels,
                '-- Sélectionner un niveau / une classe --'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | FORMATION
    |--------------------------------------------------------------------------
    |
    | SECONDAIRE
    | Formation → Niveau
    |
    | ENEP
    | Formation → Niveau
    |
    | ENSP
    | Formation → Spécialité → Niveau
    |
    | IDS
    | Formation → Spécialité → Niveau
    |
    | UIT
    | Formation → Spécialité → Niveau
    |
    | ENS
    | Formation → Programme → Spécialité → Niveau
    |
    |--------------------------------------------------------------------------
    */

    if (formationSelect) {
        formationSelect.addEventListener('change', async function () {

            console.log('==============================');
            console.log('[TEST FORMATION CHANGE]');
            console.log('ID:', this.value);
            console.log(
                'TEXT:',
                this.options[this.selectedIndex]?.textContent
            );
            console.log(
                'SLUG:',
                this.options[this.selectedIndex]?.dataset?.slug
            );
            console.log(
                'Category:',
                getCategorySlug()
            );
            console.log(
                'ENEP:',
                this.options[this.selectedIndex]?.dataset?.slug === 'enep'
            );
            console.log(
                'ENS:',
                this.options[this.selectedIndex]?.dataset?.slug === 'ens'
            );
            console.log('==============================');

            const formationId = this.value;

            // ... le reste de ton code ne change pas

            requestSequence++;

            const sequence = requestSequence;

            resetSelect(
                programSelect,
                '-- Sélectionner un programme --'
            );

            resetSelect(
                specialiteSelect,
                '-- Sélectionner une spécialité --'
            );

            resetSelect(
                levelSelect,
                '-- Sélectionner un niveau / une classe --'
            );

            resetSelect(
                subjectSelect,
                '-- Sélectionner une matière / un module --'
            );

            hide(programContainer);
            hide(specialiteContainer);
            hide(levelContainer);
            hide(subjectContainer);

            if (!formationId) return;

            /*
            |--------------------------------------------------------------------------
            | SECONDAIRE
            |--------------------------------------------------------------------------
            */

            if (isSecondary()) {

                show(levelContainer);

                setLoading(
                    levelSelect,
                    '-- Chargement des niveaux... --'
                );

                const levels = await loadData(
                    urls.secondaryLevels,
                    {
                        formation_id: formationId
                    },
                    sequence
                );

                if (
                    levels === null ||
                    sequence !== requestSequence ||
                    this.value !== formationId
                ) return;

                populateSelect(
                    levelSelect,
                    levels,
                    '-- Sélectionner un niveau / une classe --'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | PROFESSIONNEL
            |--------------------------------------------------------------------------
            */

            if (!isProfessional()) return;

            /*
            |--------------------------------------------------------------------------
            | ENS
            | Formation → Programme
            |--------------------------------------------------------------------------
            */

            if (isProfessionalENS()) {

                show(programContainer);

                setLoading(
                    programSelect,
                    '-- Chargement des programmes... --'
                );

                const programs = await loadData(
                    urls.programs,
                    {
                        formation_id: formationId
                    },
                    sequence
                );

                if (
                    programs === null ||
                    sequence !== requestSequence ||
                    this.value !== formationId
                ) return;

                populateSelect(
                    programSelect,
                    programs,
                    '-- Sélectionner un programme --'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | ENSP / IDS / UIT
            | Formation → Spécialité
            |--------------------------------------------------------------------------
            */

            if (isProfessionalSpecializedFormation()) {

                show(specialiteContainer);

                setLoading(
                    specialiteSelect,
                    '-- Chargement des spécialités... --'
                );

                const specialites = await loadData(
                    urls.specialitesByFormation,
                    {
                        formation_id: formationId
                    },
                    sequence
                );
                

                if (
                    specialites === null ||
                    sequence !== requestSequence ||
                    this.value !== formationId
                ) return;

                populateSelect(
                    specialiteSelect,
                    specialites,
                    '-- Sélectionner une spécialité --'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | ENEP
            | Formation → Niveau
            |--------------------------------------------------------------------------
            */
            if (isProfessionalENEP()) {

                show(levelContainer);

                setLoading(
                    levelSelect,
                    '-- Chargement des niveaux... --'
                );

                const levels = await loadData(
                    urls.professionalLevels,
                    {
                        formation_id: formationId
                    },
                    sequence
                );

                if (
                    levels === null ||
                    sequence !== requestSequence ||
                    this.value !== formationId
                ) return;

                populateSelect(
                    levelSelect,
                    levels,
                    '-- Sélectionner un niveau / une classe --'
                );

                return;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ENS
    | Programme → Spécialité
    |--------------------------------------------------------------------------
    */

    if (programSelect) {
        programSelect.addEventListener('change', async function () {
            

            if (
                !isProfessional() ||
                !isProfessionalENS()
            ) return;

            const programId = this.value;

            requestSequence++;

            const sequence = requestSequence;

            resetSelect(
                specialiteSelect,
                '-- Sélectionner une spécialité --'
            );

            resetSelect(
                levelSelect,
                '-- Sélectionner un niveau / une classe --'
            );

            resetSelect(
                subjectSelect,
                '-- Sélectionner une matière / un module --'
            );

            hide(specialiteContainer);
            hide(levelContainer);
            hide(subjectContainer);

            if (!programId) return;

            show(specialiteContainer);

            setLoading(
                specialiteSelect,
                '-- Chargement des spécialités... --'
            );

            const specialites = await loadData(
                urls.specialites,
                {
                    program_id: programId
                },
                sequence
            );

            if (
                specialites === null ||
                sequence !== requestSequence ||
                this.value !== programId
            ) return;

            populateSelect(
                specialiteSelect,
                specialites,
                '-- Sélectionner une spécialité --'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | SPÉCIALITÉ → NIVEAU
    |--------------------------------------------------------------------------
    |
    | ENS
    | Programme → Spécialité → Niveau
    |
    | ENSP
    | Formation → Spécialité → Niveau
    |
    | IDS
    | Formation → Spécialité → Niveau
    |
    | UIT
    | Formation → Spécialité → Niveau
    |
    |--------------------------------------------------------------------------
    */

    if (specialiteSelect) {
        specialiteSelect.addEventListener('change', async function () {

            if (!isProfessional()) return;

            const specialiteId = this.value;
            const formationId = formationSelect?.value || '';
            const programId = programSelect?.value || '';

            requestSequence++;

            const sequence = requestSequence;

            resetSelect(
                levelSelect,
                '-- Sélectionner un niveau / une classe --'
            );

            resetSelect(
                subjectSelect,
                '-- Sélectionner une matière / un module --'
            );

            hide(levelContainer);
            hide(subjectContainer);

            if (!specialiteId) return;

            show(levelContainer);

            setLoading(
                levelSelect,
                '-- Chargement des niveaux... --'
            );

            const params = {
                specialite_id: specialiteId,
                formation_id: formationId
            };

            if (isProfessionalENS()) {
                params.program_id = programId;
            }

            const levels = await loadData(
                urls.specialiteLevels,
                params,
                sequence
            );

            if (
                levels === null ||
                sequence !== requestSequence ||
                this.value !== specialiteId ||
                formationSelect?.value !== formationId ||
                (
                    isProfessionalENS() &&
                    programSelect?.value !== programId
                )
            ) return;

            populateSelect(
                levelSelect,
                levels,
                '-- Sélectionner un niveau / une classe --'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | NIVEAU → MODULE
    |--------------------------------------------------------------------------
    */

    if (levelSelect) {
        levelSelect.addEventListener('change', async function () {

            const levelId = this.value;

            requestSequence++;

            const sequence = requestSequence;

            resetSelect(
                subjectSelect,
                '-- Sélectionner une matière / un module --'
            );

            hide(subjectContainer);

            if (!levelId) return;

            show(subjectContainer);

            setLoading(
                subjectSelect,
                '-- Chargement des matières / modules... --'
            );

            const subjects = await loadData(
                urls.subjects,
                {
                    level_id: levelId
                },
                sequence
            );

            if (
                subjects === null ||
                sequence !== requestSequence ||
                this.value !== levelId
            ) return;

            populateSelect(
                subjectSelect,
                subjects,
                '-- Sélectionner une matière / un module --'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | PRIX
    |--------------------------------------------------------------------------
    */

    function updatePriceVisibility() {

        if (!accessType) return;

        const premium = accessType.value === 'premium';

        if (premium) {

            show(priceContainer);

            if (priceInput) {
                priceInput.required = true;
            }

        } else {

            hide(priceContainer);

            if (priceInput) {
                priceInput.required = false;
                priceInput.value = '';
                priceInput.classList.remove('is-invalid');
            }
        }
    }

    if (accessType) {

        accessType.addEventListener(
            'change',
            updatePriceVisibility
        );

        updatePriceVisibility();
    }

    /*
    |--------------------------------------------------------------------------
    | WIZARD
    |--------------------------------------------------------------------------
    */

    function updateWizard() {

        document
            .querySelectorAll('.form-step')
            .forEach(function (step) {

                const number = parseInt(
                    step.id.replace('step-', ''),
                    10
                );

                step.classList.toggle(
                    'active',
                    number === currentStep
                );
            });

        document
            .querySelectorAll('.wizard-step')
            .forEach(function (step) {

                const number = parseInt(
                    step.dataset.step,
                    10
                );

                step.classList.remove(
                    'active',
                    'completed'
                );

                if (number === currentStep) {
                    step.classList.add('active');
                }

                if (number < currentStep) {
                    step.classList.add('completed');
                }
            });

        if (progressFill) {

            progressFill.style.width =
                `${((currentStep - 1) / 2) * 100}%`;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    function requireField(field) {

        if (!field) return true;

        const valid =
            !field.disabled &&
            Boolean(field.value);

        field.classList.toggle(
            'is-invalid',
            !valid
        );

        return valid;
    }

    function validateStep1() {

        let valid = true;

        valid =
            requireField(categorySelect) &&
            valid;

        /*
        |--------------------------------------------------------------------------
        | SUPÉRIEUR
        |--------------------------------------------------------------------------
        */

        if (isHigher()) {

            valid =
                requireField(academicDomainSelect) &&
                valid;

            valid =
                requireField(filiereSelect) &&
                valid;

            valid =
                requireField(levelSelect) &&
                valid;

            valid =
                requireField(subjectSelect) &&
                valid;
        }

        /*
        |--------------------------------------------------------------------------
        | SECONDAIRE
        |--------------------------------------------------------------------------
        */

        if (isSecondary()) {

            valid =
                requireField(formationSelect) &&
                valid;

            valid =
                requireField(levelSelect) &&
                valid;

            valid =
                requireField(subjectSelect) &&
                valid;
        }

        /*
        |--------------------------------------------------------------------------
        | PROFESSIONNEL
        |--------------------------------------------------------------------------
        */

        if (isProfessional()) {

            valid =
                requireField(formationSelect) &&
                valid;

            /*
            |--------------------------------------------------------------------------
            | ENS
            |--------------------------------------------------------------------------
            */

            if (isProfessionalENS()) {

                valid =
                    requireField(programSelect) &&
                    valid;

                valid =
                    requireField(specialiteSelect) &&
                    valid;
            }

            /*
            |--------------------------------------------------------------------------
            | ENSP / IDS / UIT
            |--------------------------------------------------------------------------
            */

            if (isProfessionalENSP() ||
                isProfessionalIDS() ||
                isProfessionalUIT()) {

                valid =
                    requireField(specialiteSelect) &&
                    valid;
            }

            /*
            |--------------------------------------------------------------------------
            | ENEP
            |--------------------------------------------------------------------------
            */

            valid =
                requireField(levelSelect) &&
                valid;

            valid =
                requireField(subjectSelect) &&
                valid;
        }

        return valid;
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION DOCUMENT
    |--------------------------------------------------------------------------
    */

    function validateStep2() {

        let valid = true;

        const fields = [
            document.getElementById('title'),
            document.getElementById('document_type_id'),
            document.getElementById('file_path')
        ];

        fields.forEach(function (field) {

            if (!field) return;

            const fieldValid = Boolean(field.value);

            field.classList.toggle(
                'is-invalid',
                !fieldValid
            );

            if (!fieldValid) {
                valid = false;
            }
        });

        if (
            accessType &&
            accessType.value === 'premium'
        ) {

            const priceValid =
                priceInput &&
                priceInput.value &&
                Number(priceInput.value) > 0;

            priceInput?.classList.toggle(
                'is-invalid',
                !priceValid
            );

            if (!priceValid) {
                valid = false;
            }
        }

        return valid;
    }

    /*
    |--------------------------------------------------------------------------
    | RÉCAPITULATIF
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function getSelectedText(select) {

        if (!select || !select.value) {
            return 'Non renseigné';
        }

        const option =
            select.options[select.selectedIndex];

        return option
            ? option.textContent.trim()
            : 'Non renseigné';
    }

    function buildSummary() {

        if (!summary) return;

        const title = document.getElementById('title');
        const description = document.getElementById('description');
        const documentType = document.getElementById('document_type_id');

        let html = `
<div class="summary-section">
<h6>
<i class="bi bi-diagram-3 me-2"></i>
Classification
</h6>

<div class="summary-grid">

<div class="summary-item">
<span class="summary-label">Catégorie</span>
<strong>
${escapeHtml(getSelectedText(categorySelect))}
</strong>
</div>
`;

        /*
        |--------------------------------------------------------------------------
        | SECONDAIRE
        |--------------------------------------------------------------------------
        */

        if (isSecondary()) {

            html += `
<div class="summary-item">
<span class="summary-label">Formation</span>
<strong>
${escapeHtml(getSelectedText(formationSelect))}
</strong>
</div>

<div class="summary-item">
<span class="summary-label">Niveau / Classe</span>
<strong>
${escapeHtml(getSelectedText(levelSelect))}
</strong>
</div>
`;
        }

        /*
        |--------------------------------------------------------------------------
        | SUPÉRIEUR
        |--------------------------------------------------------------------------
        */

        if (isHigher()) {

            html += `
<div class="summary-item">
<span class="summary-label">Domaine académique</span>
<strong>
${escapeHtml(getSelectedText(academicDomainSelect))}
</strong>
</div>

<div class="summary-item">
<span class="summary-label">Filière</span>
<strong>
${escapeHtml(getSelectedText(filiereSelect))}
</strong>
</div>

<div class="summary-item">
<span class="summary-label">Niveau</span>
<strong>
${escapeHtml(getSelectedText(levelSelect))}
</strong>
</div>
`;
        }

        /*
        |--------------------------------------------------------------------------
        | PROFESSIONNEL
        |--------------------------------------------------------------------------
        */

        if (isProfessional()) {

            html += `
<div class="summary-item">
<span class="summary-label">Formation</span>
<strong>
${escapeHtml(getSelectedText(formationSelect))}
</strong>
</div>
`;

            if (isProfessionalENS()) {

                html += `
<div class="summary-item">
<span class="summary-label">Programme</span>
<strong>
${escapeHtml(getSelectedText(programSelect))}
</strong>
</div>
`;
            }

            if (
                isProfessionalENS() ||
                isProfessionalENSP() ||
                isProfessionalIDS() ||
                isProfessionalUIT()
            ) {

                html += `
<div class="summary-item">
<span class="summary-label">Spécialité</span>
<strong>
${escapeHtml(getSelectedText(specialiteSelect))}
</strong>
</div>
`;
            }

            html += `
<div class="summary-item">
<span class="summary-label">Niveau</span>
<strong>
${escapeHtml(getSelectedText(levelSelect))}
</strong>
</div>
`;
        }

        html += `
<div class="summary-item">
<span class="summary-label">Matière / Module</span>
<strong>
${escapeHtml(getSelectedText(subjectSelect))}
</strong>
</div>

</div>
</div>
`;

        /*
        |--------------------------------------------------------------------------
        | DOCUMENT
        |--------------------------------------------------------------------------
        */

        html += `
<div class="summary-section">
<h6>
<i class="bi bi-file-earmark-text me-2"></i>
Document
</h6>

<div class="summary-grid">

<div class="summary-item summary-item-full">
<span class="summary-label">Titre</span>
<strong>
${escapeHtml(title?.value || 'Non renseigné')}
</strong>
</div>

<div class="summary-item">
<span class="summary-label">Type</span>
<strong>
${escapeHtml(getSelectedText(documentType))}
</strong>
</div>

<div class="summary-item">
<span class="summary-label">Accès</span>
<strong>
${escapeHtml(getSelectedText(accessType))}
</strong>
</div>
`;

        if (
            accessType &&
            accessType.value === 'premium'
        ) {

            html += `
<div class="summary-item">
<span class="summary-label">Prix</span>
<strong>
${escapeHtml(priceInput?.value || '0')} FCFA
</strong>
</div>
`;
        }

        html += `
</div>
</div>
`;

        if (
            description &&
            description.value.trim()
        ) {

            html += `
<div class="summary-section">
<h6>
<i class="bi bi-card-text me-2"></i>
Description
</h6>

<p class="summary-description">
${escapeHtml(description.value.trim())}
</p>
</div>
`;
        }

        summary.innerHTML = html;
    }

    /*
    |--------------------------------------------------------------------------
    | NAVIGATION
    |--------------------------------------------------------------------------
    */

    window.nextStep = function (step) {

        if (step === 2) {

            if (!validateStep1()) {

                alert(
                    'Veuillez compléter la classification du document.'
                );

                return;
            }
        }

        if (step === 3) {

            if (!validateStep2()) {

                alert(
                    'Veuillez compléter les informations du document.'
                );

                return;
            }

            buildSummary();
        }

        currentStep = step;
        updateWizard();
    };

    window.previousStep = function (step) {

        currentStep = step;
        updateWizard();
    };

    /*
    |--------------------------------------------------------------------------
    | SOUMISSION
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', function (event) {

        if (currentStep !== 3) {

            event.preventDefault();
            return;
        }

        if (
            confirmInformation &&
            !confirmInformation.checked
        ) {

            event.preventDefault();

            alert(
                'Veuillez confirmer que les informations saisies sont exactes.'
            );

            confirmInformation.focus();

            return;
        }

        if (publishButton) {

            publishButton.disabled = true;

            publishButton.innerHTML = `
<span
class="spinner-border spinner-border-sm me-2"
role="status"
aria-hidden="true">
</span>
Publication en cours...
`;
        }
    });

    /*
    |--------------------------------------------------------------------------
    | SUPPRESSION DES ERREURS
    |--------------------------------------------------------------------------
    */

    form
        .querySelectorAll('input, select, textarea')
        .forEach(function (field) {

            field.addEventListener(
                'change',
                function () {
                    this.classList.remove('is-invalid');
                }
            );

            field.addEventListener(
                'input',
                function () {
                    this.classList.remove('is-invalid');
                }
            );
        });

    /*
    |--------------------------------------------------------------------------
    | INITIALISATION
    |--------------------------------------------------------------------------
    */

    hideAllClassificationContainers();
    updatePriceVisibility();
    updateWizard();

    console.log(
        '[Document Wizard] Initialisation terminée.'
    );

});