Adresse du client:

{foreach from=$adresses item=adresse}

Prénom: {$adresse.firstname}<br />

Nom: {$adresse.lastname}<br />

Adresse 1 : {$adresse.adress1}<br />

Code postal: {$adresse.postcode}<br />

Ville: {$adresse.city}<br />

etc...

{/foreach}