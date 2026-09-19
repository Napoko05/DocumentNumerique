document.addEventListener("DOMContentLoaded",function(){const d=document.getElementById("documentForm");if(!d){console.warn("[Document Wizard] Formulaire introuvable.");return}const D=document.getElementById("teaching_category_id"),$=document.getElementById("academic_domain_id"),l=document.getElementById("formation_id"),q=document.getElementById("filiere_id"),m=document.getElementById("program_id"),E=document.getElementById("specialite_id"),o=document.getElementById("level_id"),g=document.getElementById("subject_id"),k=document.getElementById("academicDomainContainer"),H=document.getElementById("formationContainer"),M=document.getElementById("filiereContainer"),V=document.getElementById("programContainer"),U=document.getElementById("specialiteContainer"),_=document.getElementById("levelContainer"),x=document.getElementById("subjectContainer"),G=document.getElementById("wizardProgressFill"),J=document.getElementById("document-summary"),w=document.getElementById("access_type"),K=document.getElementById("price-container"),u=document.getElementById("price"),W=document.getElementById("confirm_information"),R=document.getElementById("publishDocumentBtn"),S={formations:d.dataset.formationsUrl,academicDomains:d.dataset.academicDomainsUrl,filieres:d.dataset.filieresUrl,secondaryLevels:d.dataset.secondaryLevelsUrl,higherLevels:d.dataset.higherLevelsUrl,professionalLevels:d.dataset.professionalLevelsUrl,specialitesByFormation:d.dataset.specialitesByFormationUrl,programs:d.dataset.programsUrl,specialites:d.dataset.specialitesUrl,specialiteLevels:d.dataset.specialiteLevelsUrl,subjects:d.dataset.subjectsUrl};let A=1,s=0;function p(e){e&&(e.style.display="")}function a(e){e&&(e.style.display="none")}function r(e,n){if(!e)return;e.innerHTML="";const t=document.createElement("option");t.value="",t.textContent=n,e.appendChild(t),e.disabled=!0}function I(e,n){if(!e)return;e.innerHTML="";const t=document.createElement("option");t.value="",t.textContent=n,e.appendChild(t),e.disabled=!0}function b(e,n,t){e&&(r(e,t),!(!Array.isArray(n)||n.length===0)&&(n.forEach(function(i){if(!i||i.id===void 0||i.name===void 0)return;const L=document.createElement("option");L.value=i.id,L.textContent=i.name,i.slug&&(L.dataset.slug=i.slug),e.appendChild(L)}),e.disabled=!1))}function Q(){a(k),a(H),a(M),a(V),a(U),a(_),a(x)}function N(){var n;if(!D)return null;const e=D.options[D.selectedIndex];return((n=e==null?void 0:e.dataset)==null?void 0:n.slug)||null}function z(){return["secondaire","secondaire-general","secondaire-technique"].includes(N())}function j(){return["superieur","supérieur"].includes(N())}function P(){return["professionnel","professional"].includes(N())}function F(){var n;if(!l)return null;const e=l.options[l.selectedIndex];return((n=e==null?void 0:e.dataset)==null?void 0:n.slug)||null}function ie(){return F()==="enep"}function Y(){return F()==="ensp"}function Z(){return F()==="ids"}function ee(){return F()==="uit"}function T(){return F()==="ens"}function se(){return["ensp","ids","uit"].includes(F())}async function C(e,n={},t){if(!e)return console.error("[Document Wizard] URL AJAX manquante."),[];const i=new URLSearchParams;Object.entries(n).forEach(([y,h])=>{h!=null&&h!==""&&i.append(y,h)});const L=`${e}?${i.toString()}`;try{const y=await fetch(L,{method:"GET",headers:{Accept:"application/json","X-Requested-With":"XMLHttpRequest"},credentials:"same-origin"});if(!y.ok)throw new Error(`HTTP ${y.status}`);const h=await y.json();return t!==s?null:Array.isArray(h)?h:h&&Array.isArray(h.data)?h.data:[]}catch(y){return t===s&&console.error("[Document Wizard] AJAX:",y),[]}}D&&D.addEventListener("change",async function(){const e=N();s++;const n=s;if(Q(),r($,"-- Sélectionner un domaine académique --"),r(l,"-- Sélectionner une formation --"),r(q,"-- Sélectionner une filière --"),r(m,"-- Sélectionner un programme --"),r(E,"-- Sélectionner une spécialité --"),r(o,"-- Sélectionner un niveau / une classe --"),r(g,"-- Sélectionner une matière / un module --"),!!e){if(z()){p(H),I(l,"-- Chargement des formations... --");const t=await C(S.formations,{category:e},n);if(t===null||n!==s)return;b(l,t,"-- Sélectionner une formation --");return}if(j()){p(k),I($,"-- Chargement des domaines académiques... --");const t=await C(S.academicDomains,{category:e},n);if(t===null||n!==s)return;b($,t,"-- Sélectionner un domaine académique --");return}if(P()){p(H),I(l,"-- Chargement des formations... --");const t=await C(S.formations,{category:e},n);if(t===null||n!==s)return;b(l,t,"-- Sélectionner une formation --")}}}),$&&$.addEventListener("change",async function(){if(!j())return;const e=this.value;s++;const n=s;if(r(q,"-- Sélectionner une filière --"),r(o,"-- Sélectionner un niveau / une classe --"),r(g,"-- Sélectionner une matière / un module --"),a(M),a(_),a(x),!e)return;p(M),I(q,"-- Chargement des filières... --");const t=await C(S.filieres,{academic_domain_id:e},n);t===null||n!==s||this.value!==e||b(q,t,"-- Sélectionner une filière --")}),q&&q.addEventListener("change",async function(){if(!j())return;const e=this.value;s++;const n=s;if(r(o,"-- Sélectionner un niveau / une classe --"),r(g,"-- Sélectionner une matière / un module --"),a(_),a(x),!e)return;p(_),I(o,"-- Chargement des niveaux... --");const t=await C(S.higherLevels,{filiere_id:e},n);t===null||n!==s||this.value!==e||b(o,t,"-- Sélectionner un niveau / une classe --")}),l&&l.addEventListener("change",async function(){var t,i,L,y,h,ne,te;console.log("=============================="),console.log("[TEST FORMATION CHANGE]"),console.log("ID:",this.value),console.log("TEXT:",(t=this.options[this.selectedIndex])==null?void 0:t.textContent),console.log("SLUG:",(L=(i=this.options[this.selectedIndex])==null?void 0:i.dataset)==null?void 0:L.slug),console.log("Category:",N()),console.log("ENEP:",((h=(y=this.options[this.selectedIndex])==null?void 0:y.dataset)==null?void 0:h.slug)==="enep"),console.log("ENS:",((te=(ne=this.options[this.selectedIndex])==null?void 0:ne.dataset)==null?void 0:te.slug)==="ens"),console.log("==============================");const e=this.value;s++;const n=s;if(r(m,"-- Sélectionner un programme --"),r(E,"-- Sélectionner une spécialité --"),r(o,"-- Sélectionner un niveau / une classe --"),r(g,"-- Sélectionner une matière / un module --"),a(V),a(U),a(_),a(x),!!e){if(z()){p(_),I(o,"-- Chargement des niveaux... --");const B=await C(S.secondaryLevels,{formation_id:e},n);if(B===null||n!==s||this.value!==e)return;b(o,B,"-- Sélectionner un niveau / une classe --");return}if(P()){if(T()){p(V),I(m,"-- Chargement des programmes... --");const B=await C(S.programs,{formation_id:e},n);if(B===null||n!==s||this.value!==e)return;b(m,B,"-- Sélectionner un programme --");return}if(se()){p(U),I(E,"-- Chargement des spécialités... --");const B=await C(S.specialitesByFormation,{formation_id:e},n);if(B===null||n!==s||this.value!==e)return;b(E,B,"-- Sélectionner une spécialité --");return}if(ie()){p(_),I(o,"-- Chargement des niveaux... --");const B=await C(S.professionalLevels,{formation_id:e},n);if(B===null||n!==s||this.value!==e)return;b(o,B,"-- Sélectionner un niveau / une classe --");return}}}}),m&&m.addEventListener("change",async function(){if(!P()||!T())return;const e=this.value;s++;const n=s;if(r(E,"-- Sélectionner une spécialité --"),r(o,"-- Sélectionner un niveau / une classe --"),r(g,"-- Sélectionner une matière / un module --"),a(U),a(_),a(x),!e)return;p(U),I(E,"-- Chargement des spécialités... --");const t=await C(S.specialites,{program_id:e},n);t===null||n!==s||this.value!==e||b(E,t,"-- Sélectionner une spécialité --")}),E&&E.addEventListener("change",async function(){if(!P())return;const e=this.value,n=(l==null?void 0:l.value)||"",t=(m==null?void 0:m.value)||"";s++;const i=s;if(r(o,"-- Sélectionner un niveau / une classe --"),r(g,"-- Sélectionner une matière / un module --"),a(_),a(x),!e)return;p(_),I(o,"-- Chargement des niveaux... --");const L={specialite_id:e,formation_id:n};T()&&(L.program_id=t);const y=await C(S.specialiteLevels,L,i);y===null||i!==s||this.value!==e||(l==null?void 0:l.value)!==n||T()&&(m==null?void 0:m.value)!==t||b(o,y,"-- Sélectionner un niveau / une classe --")}),o&&o.addEventListener("change",async function(){const e=this.value;s++;const n=s;if(r(g,"-- Sélectionner une matière / un module --"),a(x),!e)return;p(x),I(g,"-- Chargement des matières / modules... --");const t=await C(S.subjects,{level_id:e},n);t===null||n!==s||this.value!==e||b(g,t,"-- Sélectionner une matière / un module --")});function X(){if(!w)return;w.value==="premium"?(p(K),u&&(u.required=!0)):(a(K),u&&(u.required=!1,u.value="",u.classList.remove("is-invalid")))}w&&(w.addEventListener("change",X),X());function O(){document.querySelectorAll(".form-step").forEach(function(e){const n=parseInt(e.id.replace("step-",""),10);e.classList.toggle("active",n===A)}),document.querySelectorAll(".wizard-step").forEach(function(e){const n=parseInt(e.dataset.step,10);e.classList.remove("active","completed"),n===A&&e.classList.add("active"),n<A&&e.classList.add("completed")}),G&&(G.style.width=`${(A-1)/2*100}%`)}function f(e){if(!e)return!0;const n=!e.disabled&&!!e.value;return e.classList.toggle("is-invalid",!n),n}function ae(){let e=!0;return e=f(D)&&e,j()&&(e=f($)&&e,e=f(q)&&e,e=f(o)&&e,e=f(g)&&e),z()&&(e=f(l)&&e,e=f(o)&&e,e=f(g)&&e),P()&&(e=f(l)&&e,T()&&(e=f(m)&&e,e=f(E)&&e),(Y()||Z()||ee())&&(e=f(E)&&e),e=f(o)&&e,e=f(g)&&e),e}function re(){let e=!0;if([document.getElementById("title"),document.getElementById("document_type_id"),document.getElementById("file_path")].forEach(function(t){if(!t)return;const i=!!t.value;t.classList.toggle("is-invalid",!i),i||(e=!1)}),w&&w.value==="premium"){const t=u&&u.value&&Number(u.value)>0;u==null||u.classList.toggle("is-invalid",!t),t||(e=!1)}return e}function c(e){return String(e??"").replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#039;")}function v(e){if(!e||!e.value)return"Non renseigné";const n=e.options[e.selectedIndex];return n?n.textContent.trim():"Non renseigné"}function oe(){if(!J)return;const e=document.getElementById("title"),n=document.getElementById("description"),t=document.getElementById("document_type_id");let i=`
<div class="summary-section">
<h6>
<i class="bi bi-diagram-3 me-2"></i>
Classification
</h6>

<div class="summary-grid">

<div class="summary-item">
<span class="summary-label">Catégorie</span>
<strong>
${c(v(D))}
</strong>
</div>
`;z()&&(i+=`
<div class="summary-item">
<span class="summary-label">Formation</span>
<strong>
${c(v(l))}
</strong>
</div>

<div class="summary-item">
<span class="summary-label">Niveau / Classe</span>
<strong>
${c(v(o))}
</strong>
</div>
`),j()&&(i+=`
<div class="summary-item">
<span class="summary-label">Domaine académique</span>
<strong>
${c(v($))}
</strong>
</div>

<div class="summary-item">
<span class="summary-label">Filière</span>
<strong>
${c(v(q))}
</strong>
</div>

<div class="summary-item">
<span class="summary-label">Niveau</span>
<strong>
${c(v(o))}
</strong>
</div>
`),P()&&(i+=`
<div class="summary-item">
<span class="summary-label">Formation</span>
<strong>
${c(v(l))}
</strong>
</div>
`,T()&&(i+=`
<div class="summary-item">
<span class="summary-label">Programme</span>
<strong>
${c(v(m))}
</strong>
</div>
`),(T()||Y()||Z()||ee())&&(i+=`
<div class="summary-item">
<span class="summary-label">Spécialité</span>
<strong>
${c(v(E))}
</strong>
</div>
`),i+=`
<div class="summary-item">
<span class="summary-label">Niveau</span>
<strong>
${c(v(o))}
</strong>
</div>
`),i+=`
<div class="summary-item">
<span class="summary-label">Matière / Module</span>
<strong>
${c(v(g))}
</strong>
</div>

</div>
</div>
`,i+=`
<div class="summary-section">
<h6>
<i class="bi bi-file-earmark-text me-2"></i>
Document
</h6>

<div class="summary-grid">

<div class="summary-item summary-item-full">
<span class="summary-label">Titre</span>
<strong>
${c((e==null?void 0:e.value)||"Non renseigné")}
</strong>
</div>

<div class="summary-item">
<span class="summary-label">Type</span>
<strong>
${c(v(t))}
</strong>
</div>

<div class="summary-item">
<span class="summary-label">Accès</span>
<strong>
${c(v(w))}
</strong>
</div>
`,w&&w.value==="premium"&&(i+=`
<div class="summary-item">
<span class="summary-label">Prix</span>
<strong>
${c((u==null?void 0:u.value)||"0")} FCFA
</strong>
</div>
`),i+=`
</div>
</div>
`,n&&n.value.trim()&&(i+=`
<div class="summary-section">
<h6>
<i class="bi bi-card-text me-2"></i>
Description
</h6>

<p class="summary-description">
${c(n.value.trim())}
</p>
</div>
`),J.innerHTML=i}window.nextStep=function(e){if(e===2&&!ae()){alert("Veuillez compléter la classification du document.");return}if(e===3){if(!re()){alert("Veuillez compléter les informations du document.");return}oe()}A=e,O()},window.previousStep=function(e){A=e,O()},d.addEventListener("submit",function(e){if(A!==3){e.preventDefault();return}if(W&&!W.checked){e.preventDefault(),alert("Veuillez confirmer que les informations saisies sont exactes."),W.focus();return}R&&(R.disabled=!0,R.innerHTML=`
<span
class="spinner-border spinner-border-sm me-2"
role="status"
aria-hidden="true">
</span>
Publication en cours...
`)}),d.querySelectorAll("input, select, textarea").forEach(function(e){e.addEventListener("change",function(){this.classList.remove("is-invalid")}),e.addEventListener("input",function(){this.classList.remove("is-invalid")})}),Q(),X(),O(),console.log("[Document Wizard] Initialisation terminée.")});
