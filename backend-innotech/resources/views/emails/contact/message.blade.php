@component('mail::message')
# 🎓 Nouveau message via le formulaire de contact

<table width="100%" style="margin-top: 20px;">
    <tr>
        <td><strong>Nom :</strong></td>
        <td>{{ $data['name'] }}</td>
    </tr>
    <tr>
        <td><strong>Email :</strong></td>
        <td><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></td>
    </tr>
    <tr>
        <td><strong>Service :</strong></td>
        <td>{{ ucfirst($data['service']) }}</td>
    </tr>
</table>

---

### ✉️ Message :

{{ $data['message'] }}

---

Merci,
**Université InnoTech**

@slot('footer')
© {{ now()->year }} Université InnoTech. Tous droits réservés.
@endslot

@endcomponent
