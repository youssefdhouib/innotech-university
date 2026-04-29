@component('mail::message')
# 🎓 Bonjour {{ $application->first_name }} {{ $application->last_name }},

Nous avons le plaisir de vous informer que votre **demande de préinscription** à l’Université **InnoTech** a été **acceptée** par notre comité d’admission.

Merci de compléter le formulaire complémentaire pour la confirmation de votre inscription en cliquant sur le bouton ci-dessous :

{{-- Bouton personnalisé --}}
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tr>
        <td align="center">
            <a href="{{ $link }}" target="_blank" style="
        display: inline-block;
        background-color: #1a237e;
        color: #ffffff;
        padding: 12px 25px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 16px;
        text-decoration: none;
      ">
                📥 Confirmer ma préinscription
            </a>
        </td>
    </tr>
</table>

---

### 📌 Informations importantes

- 🔒 Ce lien est **valide pendant 3 jours** à compter de la date de réception.
- ⛔ Passé ce délai, la demande sera annulée.
- 📎 Vous devez **joindre des copies conformes et bien lisibles** des documents requis (pièce d’identité, diplôme, relevé de notes, etc.).

---

Cordialement,
**Service des Admissions**
InnoTech University
@endcomponent
